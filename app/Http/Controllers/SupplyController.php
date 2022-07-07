<?php

namespace App\Http\Controllers;

use App\Imports\SupplyImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\supply;
use App\Models\category_supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Notifications\criticalSupply;
use Redirect;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Arr;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {

            return datatables(DB::connection(session()->get('database'))
                ->table('supplies')
                ->whereNull('supplies.deleted_at')
                ->join('category_supplies', 'category_supplies.id', '=', 'supplies.id_category_supplies')
                ->select(
                    'supplies.id as _id',
                    'supplies.id',
                    'supplies.name_supply',
                    'supplies.unit_meassurement',
                    'supplies.quantity',
                    'supplies.critical_quantity',
                    'category_supplies.name_category',

                )
                ->orderBy('supplies.id')
                ->get())
                ->addColumn('action', 'Mantenedores.supply.datatable.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $category_supplies = category_supply::all();
        $supplySelected = new supply();

        return view('Mantenedores.supply.index', compact('category_supplies', 'supplySelected'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_supplies = category_supply::all();
        return view('Mantenedores.supply.create', compact('category_supplies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), supply::$rules, supply::$messages);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $supplyData = request()->except('_token');
                $supply = new supply;
                $supply->name_supply = $supplyData['name_supply'];
                $supply->unit_meassurement = $supplyData['unit_meassurement'];
                $supply->quantity = $supplyData['quantity'];
                $supply->critical_quantity = $supplyData['critical_quantity'];
                $supply->id_category_supplies = $supplyData['id_category_supplies'];
                $supply->save();
                DB::connection(session()->get('database'))->commit();
                return response('Se ingresó el insumo con exito.', 200);
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('No se pudo realizar el ingreso del insumo.', 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }




        return response('No se pudo realizar el ingreso del insumo.', 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function show(supply $supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function edit(supply $supply)
    {
        $id = $supply->id;
        $supplySelected = DB::table('supplies')
            ->whereNull('supplies.deleted_at')
            ->where('supplies.id', '=', $id)
            ->join('category_supplies', 'category_supplies.id', '=', 'supplies.id_category_supplies')
            ->select(
                'supplies.id as _id',
                'supplies.id',
                'supplies.name_supply',
                'supplies.unit_meassurement',
                'supplies.quantity',
                'supplies.critical_quantity',
                'supplies.id_category_supplies',
            )
            ->orderBy('supplies.id')
            ->get();
        return json_encode([$supplySelected]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), supply::$rules, supply::$messages);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {

                $supply = supply::findOrFAil($id);
                $supply->category_supply()->dissociate();
                $supply->name_supply = $request->input('name_supply');
                $supply->unit_meassurement = $request->input('unit_meassurement');
                $supply->quantity = $request->input('quantity');
                $supply->critical_quantity = $request->input('critical_quantity');
                $id_category_supplies = $request->input('id_category_supplies');
                $supply->category_supply()->associate($id_category_supplies);
                $supply->update();

                DB::connection(session()->get('database'))->commit();
                auth()->user()->notify(new criticalSupply($supply));
                return response('Se editó el insumo con exito.', 200);
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('No se pudo editar el insumo.', 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }
        return response('No se pudo editar el insumo.', 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function destroy(supply $supply)
    {
        $id = $supply->id;
        try {
            $supply = supply::on(session()->get('database'))->find($id);
            $supply->delete();
            DB::connection(session()->get('database'))->commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::connection(session()->get('database'))->rollBack();
            return response('Ocurrió un error. No se eliminó el insumo.', 400);
        }
        return response('success', 200);
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $data = supply::all();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtn = "
                                <button onclick='editSupply({$row->id})' class='edit btn btn-success btn-sm'><i class='fa-solid fa-pen-to-square me-1'></i><span class=''>Editar</span></button> 
                                <button onclick='deleteSupply({$row->id})' class='delete btn btn-danger btn-sm'><i class='fa-solid fa-trash-can me-1'></i><span>Borrar</span></button>
                                ";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function importExcelView(request $request)
    {
        return view('Mantenedores.supply.importExcel');
    }

    public function importExcel(request $request)
    {
        $file = $request->file('import_file');

        if (!$file) {
            return Redirect::back()->withErrors(['message' => 'No has cargado un archivo.']);
        } else {
            try {
                Excel::import(new SupplyImport, $file);
                return redirect()->action('App\Http\Controllers\SupplyController@index');
            } catch (\Throwable $th) {
                return Redirect::back()->withErrors(['message' => 'Ocurrió un error con el archivo. Verifique los datos']);
            }
        }
    }
    public function dashboardSupply(){
        $countSupplies = DB::table('supplies')
        ->select(DB::raw('count(supplies.id) as `countsupplies`'))
        ->where('supplies.critical_quantity', '>=', 'supplies.unit_meassurement')
        ->get();

           
        $listSupplies = DB::table('supplies')
        ->select('supplies.name_supply','supplies.critical_quantity','supplies.unit_meassurement','supplies.quantity')
        ->where('supplies.critical_quantity', '>=', 'supplies.unit_meassurement')
        ->orderBy('supplies.unit_meassurement')
        ->get();
        
        return response::json(array('countSupplies'=>$countSupplies, 'listSupplies' => $listSupplies));
    }
}

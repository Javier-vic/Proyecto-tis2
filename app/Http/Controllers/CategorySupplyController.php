<?php

namespace App\Http\Controllers;

use App\Models\category_supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Response;

class CategorySupplyController extends Controller
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
                ->table('category_supplies')
                ->whereNull('category_supplies.deleted_at')
                ->select(
                    'category_supplies.id as _id',
                    'category_supplies.id',
                    'category_supplies.name_category',
                )
                ->orderBy('category_supplies.id')
                ->get())
                ->addColumn('action', 'Mantenedores.category_supply.datatable.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $category_supplies = category_supply::all();
        return view('Mantenedores.category_supply.index', compact('category_supplies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Mantenedores.category_supply.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), category_supply::$rules, category_supply::$messages);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $category_supplyData = request()->except('_token');
                $category_supply = new category_supply;
                $category_supply->name_category = $category_supplyData['name_category'];
                $category_supply->save();
                DB::connection(session()->get('database'))->commit();
                return response('Se ingresó la categoría con exito.', 200);
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('No se pudo realizar el ingreso de la categoría.', 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }

        return response('No se pudo realizar el ingreso de la categoría.', 400);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category_supply  $category_supply
     * @return \Illuminate\Http\Response
     */
    public function show(category_supply $category_supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category_supply  $category_supply
     * @return \Illuminate\Http\Response
     */
    public function edit(category_supply  $category_supply)
    {
        $id = $category_supply->id;
        $categorySupplySelected = DB::table('category_supplies')
            ->whereNull('category_supplies.deleted_at')
            ->where('category_supplies.id', '=', $id)
            ->select(
                'category_supplies.id as _id',
                'category_supplies.id',
                'category_supplies.name_category',
            )
            ->orderBy('category_supplies.id')
            ->get();
        return json_encode([$categorySupplySelected]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category_supply  $category_supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category_supply  $category_supply)
    {
        $validator = Validator::make($request->all(), category_supply::$rules, category_supply::$messages);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {

                $category_supply = category_supply::find($category_supply->id);
                $category_supply->name_category         = $request->name_category;
                $category_supply->save();
                DB::connection(session()->get('database'))->commit();
                return response('Se editó la categoría con exito.', 200);
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('No se pudo editar la categoría.', 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400);
        }
        return response('No se pudo editar la categoría.', 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category_supply  $category_supply
     * @return \Illuminate\Http\Response
     */
    public function destroy(category_supply $category_supply)
    {
        $id = $category_supply->id;
        try {
            $category_supply = category_supply::on(session()->get('database'))->find($id);
            $category_supply->delete();
            DB::connection(session()->get('database'))->commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::connection(session()->get('database'))->rollBack();
            return response('Ocurrió un error. No se eliminó la categoría.', 400);
        }
        return response('success', 200);


   
    }

    public function dataTable(Request $request){
        if($request->ajax()){
            $data = category_supply::all();
            return DataTables::of($data)
                ->addColumn('action',function($row){
                    $actionBtn = "
                                <button onclick='editCategorySupply({$row->id})' class='edit btn btn-success btn-sm'><i class='fa-solid fa-pen-to-square me-1'></i><span class=''>Editar</span></button> 
                                <button onclick='deleteCategorySupply({$row->id})' class='delete btn btn-danger btn-sm'><i class='fa-solid fa-trash-can me-1'></i><span>Borrar</span></button>
                                ";  
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
    }

}

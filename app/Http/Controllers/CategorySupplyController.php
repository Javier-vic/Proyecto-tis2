<?php

namespace App\Http\Controllers;

use App\Models\category_supply;
use Illuminate\Http\Request;

class CategorySupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['category_supplies'] = category_supply::paginate(20);
        return view('Mantenedores.category_supply.index', $datos);
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
        $category_supplyData = request()->except('_token');
        $category_supply = new category_supply;
        $category_supply->name_category = $category_supplyData['name_category'];
        $category_supply->save();
        return response('',200);
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
    public function edit($id)
    {
        $category_supply = category_supply::findOrFAil($id);
        return view('Mantenedores.category_supply.edit', compact('category_supply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category_supply  $category_supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category_supply = category_supply::findOrFAil($id);
        $category_supply->name_category = $request->input('name_category');
        $category_supply->update();

        return redirect()->route('category_supply.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category_supply  $category_supply
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        category_supply::destroy($id);
        return redirect()->route('category_supply.index');
    }

    public function dataTable(Request $request){
        if($request->ajax()){
            $data = category_supply::all();
            return DataTables::of($data)
                ->addColumn('viewPermits', function($row){
                    $button = "<button onclick='viewPermits({$row->id})' class='btn btn-success'>Ver permisos</button>"; 
                    return $button;
                })
                ->addColumn('action',function($row){
                    $actionBtn = "
                                <button onclick='editRole({$row->id})' class='edit btn btn-success btn-sm'><i class='fa-solid fa-pen-to-square me-1'></i><span class=''>Editar</span></button> 
                                <button onclick='deleteRole({$row->id})' class='delete btn btn-danger btn-sm'><i class='fa-solid fa-trash-can me-1'></i><span>Borrar</span></button>
                                ";  
                    return $actionBtn;
                })
                ->rawColumns(['viewPermits','action'])
                ->make(true);

        }
    }

}

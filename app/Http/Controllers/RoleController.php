<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\permit;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Ui\Presets\React;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('Mantenedores.Role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permits = permit::all();
        $role = new role();
        return view('Mantenedores.Role.create',['permits'=>$permits, 'role'=>$role]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $values = request()->except('_token');
        $role = new role();
        $role->name_role = $values['name_role'];
        $permits = array();
        foreach($values['permits'] as $item => $value){
            $permits[] = (int)$value;
        }
        $role->save();
        $role->permit()->attach($permits);
        return redirect()->route('roles.index');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $role = role::find($id);
        $role->delete();
        return response('',200);
    }
    public function getPermits(Request $request){
        $data = permit::all();
        $value = $data['id'];
        return $data;
    }
    public function dataTable(Request $request){
        if($request->ajax()){
            $data = role::all();
            return DataTables::of($data)
                ->addColumn('viewPermits', function($row){
                    $button = "<button onclick='viewPermits({$row->id})' class='btn btn-success'>Ver permisos</button>"; 
                    return $button;
                })
                ->addColumn('action',function($row){
                    $actionBtn = "
                                <a href='#' class='btn btn-primary btn-sm'>Mostrar</a>
                                <a href='#' class='edit btn btn-success btn-sm'>Editar</a> 
                                <button onclick='deleteRole({$row->id})' class='delete btn btn-danger btn-sm'>Borrar</button>
                                ";  
                    return $actionBtn;
                })
                ->rawColumns(['viewPermits','action'])
                ->make(true);

        }
    }
}

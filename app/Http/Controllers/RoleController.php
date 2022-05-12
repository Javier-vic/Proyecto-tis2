<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\permit;
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
    public function destroy(role $role)
    {
        //
    }

    public function dataTable(Request $request){
        if($request->ajax()){
            $data = role::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);

        }
    }
}

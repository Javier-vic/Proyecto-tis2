<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\permit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

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
        $role = new role();
        $permits = permit::all();
        return view('Mantenedores.Role.index',['role'=>$role,'permits'=>$permits]);
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
        $validator = Validator::make($request->all(),role::$rules,role::$message);
        if($validator->passes()){
            try{
                $values = request()->except('_token');
                $role = new role();
                $role->name_role = $values['name_role'];
                $permits = array();
                foreach($values['permits'] as $item => $value){
                    $permits[] = (int)$value;
                }
                $role->save();
                $role->permit()->attach($permits);
                return response('El rol fue registrado con exito.',200);
            }catch(\Throwable $th){
                DB::connection(Session()->get('database'))->rollBack();
                return response('No se pudo realizar el registro del rol',400);
            }
        }else{
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ),400);
        }
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
        $role->update(['name_role'=>$request->name_role]);
        $role->permit()->detach();
        $permits = array();
        foreach($request->permits as $item => $value){
            $permits[] = (int)$value;
        }
        $role->permit()->attach($permits);
        //$role->permit()->attach();
        return $permits;
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
        $id = request()->id;
        $name = DB::table('roles')
                ->where('roles.id','=',$id)
                ->select('roles.name_role')
                ->get();
        $permits = DB::table('roles')
                     ->where('roles.id','=',$id)
                     ->join('role_permit','roles.id','=','role_permit.id_role')
                     ->join('permits','role_permit.id_permit','=','permits.id')
                     ->select('permits.tipe_permit','permits.id')
                     ->get();
        return json_encode([$name,$permits]);
    }
    public function dataTable(Request $request){
        if($request->ajax()){
            $data = role::where('id','!=',1)->where('id','!=',2)->get();
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

    public static function havePermits($idrole,$permit){
        $flag = DB::table('roles')
                    ->select(DB::raw('count(*)'))
                    ->join('role_permit','roles.id','=','role_permit.id_role')
                    ->where('roles.id','=',$idrole)
                    ->where('role_permit.id_permit','=',$permit)
                    ->count();

        return $flag;
    }
}

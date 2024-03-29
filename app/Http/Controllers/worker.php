<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
class worker extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = DB::table('roles')
                    ->where('id','!=',1)
                    ->where('id','!=',2)
                    ->get(); 
        return view('Mantenedores.worker.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getWorker(Request $request){
        try{
            $worker = DB::table('users')
                ->join('roles','users.id_role','=','roles.id')
                ->where('users.id','=',$request->id)
                ->select(['users.*','roles.name_role'])
                ->get();
            return $worker;
        }catch(\Throwable $th){

        }
    }
    public function getAsistByWorker(Request $request, User $user){
        $year = strtok($request->month,'-');
        $month = strtok($year);
        $data = DB::select('select SEC_TO_TIME(sum(TIME_TO_SEC(asists.end)-TIME_TO_SEC(asists.created_at))) AS horas_trabajadas FROM `asists` where id_user= ? and YEAR(created_at)=? and month(created_at) =? group by id_user;', [$user->id,$year,$month]);
        //DB::select('select * from users where active = ?', [1])
        if(isset($data[0])){
            return response::json(Array(
                $data[0],
                'name_worker' => $user->name,
                'date' => $request->month
            ));
        }else{
            return response::json(Array(
                ['horas_trabajadas'=>'00:00:00'],
                'name_worker' => $user->name,
                'date' => $request->month
            ));
        }
    }
    public function dataTableWorkers()
    {
        $worker = DB::table('users')
                ->join('roles','users.id_role','=','roles.id')
                ->where('id_role','!=',1)
                ->where('id_role','!=',2)
                ->select(['users.*','roles.name_role'])
                ->get();
        return DataTables::of($worker)
                ->addColumn('action',function($row){
                    $actionBtn = "
                                <button onclick='asistByWorker({$row->id})' class='edit btn btn-primary btn-sm'><i class='fa-solid fa-business-time me-lg-1'></i><span class='d-none d-lg-inline-block'>Asistencia</span></button>
                                <button onclick='editWorker({$row->id})' class='edit btn btn-success btn-sm'><i class='fa-solid fa-pen-to-square me-lg-1'></i><span class='d-none d-lg-inline-block'>Editar</span></button> 
                                <button onclick='deleteWorker({$row->id})' class='delete btn btn-danger btn-sm'><i class='fa-solid fa-trash-can me-lg-1'></i><span class='d-none d-lg-inline-block'>Borrar</span></button>
                                ";  
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //dd($request);
        $validator = Validator::make($request->all(),User::$rules,User::$messages);
        $emailver = DB::table('users')
                        ->where('email','=',$request->email)
                        ->get();
        if($validator->passes()){
            if(sizeof($emailver)>0){
                return Response::json(array(
                    'success' => false,
                    'errors' => [
                        'email' => 'El correo ya se encuentra registrado'
                    ]
                ), 400);
            }
            if($request->phone == 569){
                return Response::json(array(
                    'success' => false,
                    'errors' => [
                        'phone' => 'Completar numero'
                    ]
                ), 400);
            }
            if($request->password != $request->password_confirm){
                return Response::json(array(
                    'success' => false,
                    'errors' => [
                        'password_confirm' => 'Las contraseñas deben coincidir'
                    ]
                ), 400);
            }
            try{
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'id_role' => $request->id_role,
                    'phone' => $request->phone,
                    'address' => $request->address
                ]);
                return response('El trabajador fue registrado con exito.',200);
            }catch(\Throwable $th){
                DB::connection(Session()->get('database'))->rollBack();
                return response('No se pudo realizar el registro del trabajador',400);
            }
        }else{
            $msg = $validator->getMessageBag()->toArray();
            if($request->phone == 569){
                $msg['phone'] = 'Se debe completar el numero';
            }
            if($request->password != $request->password_confirm){
                $msg['password_confirm'] = 'Las contraseñas deben coincidir';
            }
            if(sizeof($emailver)>0){
                $msg['email'] = 'El correo ya se encuentra registrado';
            }
            return Response::json(array(
                'success' => false,
                'errors' => $msg
            ), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);

        if(isset($request->changePassword)){
            $validator = Validator::make($request->all(),User::$rules,User::$messages);
        }else{
            $validator = Validator::make($request->all(),User::$rulesWithoutPassword,User::$messages);
        }
        $emailver = DB::table('users')
                        ->where('email','=',$request->email)
                        ->get();
        if($validator->passes()){
            if($user->email != $request->email){
                if(sizeof($emailver)>0){
                    return Response::json(array(
                        'success' => false,
                        'errors' => [
                            'email' => 'El correo ya se encuentra registrado'
                        ]
                    ), 400);
                }
            }
            if($request->phone == 569){
                return Response::json(array(
                    'success' => false,
                    'errors' => [
                        'phone' => 'Completar numero'
                    ]
                ), 400);
            }
            if($request->password != $request->password_confirm){
                return Response::json(array(
                    'success' => false,
                    'errors' => [
                        'password_confirm' => 'Las contraseñas deben coincidir'
                    ]
                ), 400);
            }
            try{
                $user->name = $request->name;
                $user->email = $request->email;
                $user->id_role = $request->id_role;
                $user->phone = $request->phone;
                $user->address = $request->address;
                if(isset($request->changePassword)){
                    $user->password = Hash::make($request->password);
                }
                $user->save();
                return response('Trabajador editado correctamente',200);
            }catch(\Throwable $th){
                DB::connection(Session()->get('database'))->rollBack();
                return response('No se pudo realizar el registro del trabajador',400);
            }
        }else{
            $msg = $validator->getMessageBag()->toArray();
            if($request->phone == 569){
                $msg['phone'] = 'Se debe completar el numero';
            }
            if($request->password != $request->password_confirm){
                $msg['password_confirm'] = 'Las contraseñas deben coincidir';
            }
            if($user->email != $request->email){
                if(sizeof($emailver)>0){
                    $msg['password_confirm'] = 'El correo ya se encuentra registrado';
                }
            }
            return Response::json(array(
                'success' => false,
                'errors' => $msg
            ), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response('Eliminado correctamente!',200);        
    }
}

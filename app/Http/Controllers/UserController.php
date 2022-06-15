<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\user;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        $validator = Validator::make($request->all(), user::$rules, user::$messages);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {

                $values = request()->except('_token');
                //VALIDACIÓN DE QUE AMBAS CONTRASEÑAS SON IGUALES
                if ($values['password'] != $values['password_confirmation']) {
                    return Response::json(array(
                        'success' => false,
                        'errors' => ['password' => 'Las contraseñas no coinciden'],

                    ), 400);
                }
                //VALIDACIÓN DE QUE EL CORREO NO SE ENCUENTRA REGISTRADO
                $checkCorreo = User::where('email', $values['email'])->first();
                if ($checkCorreo) {
                    return Response::json(array(
                        'success' => false,
                        'errors' => ['email' => 'El correo ya se encuentra registrado'],

                    ), 400);
                }

                $user = new user;
                $user->name = $values['name'];
                $user->email = $values['email'];
                $user->password = Hash::make($values['password']);
                $user->id_role = '2'; //ROL DE CLIENTE 
                $user->address = $values['address'];
                $user->phone = $values['phone'];


                $user->save();
                DB::connection(session()->get('database'))->commit();
                return response('Se creó su cuenta con exito.', 200);
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('Ocurrió un error en el registro', 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login(Request $request, user $user)
    {

        $validator = Validator::make($request->all(), user::$rulesLogin, user::$messagesLogin);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $values = request()->except('_token');
                $userValues = User::where('email', $values['email'])->first();
                $passwordUser = $values['password'];
                $hashedPassword = $userValues->password;
                if ($userValues && Hash::check($passwordUser, $hashedPassword)) {
                    if ($userValues->id_role == '2') {
                        return Response::json(array(
                            'success' => true,
                            'redirect' => 'http://127.0.0.1:8000/landing',

                        ), 200);
                    } else {
                        return view('home');
                    }
                } else {
                    return Response::json(array(
                        'success' => false,
                        'errors' => ['loginFail' => 'Estas credenciales no existen en nuestros registros'],

                    ), 400);
                }
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('Ocurrió un error', 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }
    }
}

<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect()->action('App\Http\Controllers\LandingController@index');
        } else {
            return view('auth.register');
        }
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
                Auth::login($user);
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

    public function orderbyuser()
    {
        $user = auth()->user()->id;

        $orders = DB::table('orders')
            ->join('order_user', 'orders.id', '=', 'order_user.id_order')
            ->select('orders.*')
            ->where('order_user.id_user', '=', $user)
            ->get();

        $orderItems = DB::table('products_orders')
            ->select(DB::raw('sum(products_orders.cantidad) as articulos, products_orders.order_id'))
            ->groupby('products_orders.order_id')
            ->get();
        // dd($orderItems);

        $productOrders = DB::table('products_orders')
            ->join('products', 'products_orders.product_id', '=', 'products.id')
            ->select('products_orders.*', 'products.*')
            ->get();

        return view('Usuario.Landing.orders', compact('orders', 'productOrders', 'orderItems'));
    }


    public function orderDetails(request $request)
    {

        $values = request()->except('_token');
        $id = $values['id'];
        $order = DB::table('orders')
            ->select('orders.*')
            ->where('orders.id', '=', $id)
            ->get();

        $productOrders = DB::table('products_orders')
            ->select('products_orders.product_id', 'products.name_product', 'products_orders.cantidad', 'products.price')
            ->join('products', 'products_orders.product_id', '=', 'products.id')
            ->where('products_orders.order_id', '=', $id)
            ->get();

        return response(json_encode([$productOrders, $order]), 200);
    }
}

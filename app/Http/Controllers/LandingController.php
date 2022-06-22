<?php

namespace App\Http\Controllers;

use App\Models\category_product;
use Illuminate\Support\Facades\DB;
use App\Models\landing;
use Illuminate\Http\Request;
use App\Models\order;
use App\Models\coupon;
use App\Models\product;
use App\Models\user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //OBTIENE TODAS LAS CATEGORÍAS
        $category_products = category_product::all();
        ////////////////////////////////////////////////

        //OBTIENE LOS PRODUCTOS Y ASOCIADOS A SU CATEGORÍA
        $productAvailable = DB::table('products')
            ->whereNull('products.deleted_at')
            ->join('category_products', 'category_products.id', '=', 'products.id_category_product')
            ->select(
                'products.id',
                'products.stock',
                'products.name_product',
                'products.description',
                'products.image_product',
                'category_products.name as category',
                'category_products.id as category_id',
                'products.price'

            )
            ->orderBy('products.id')
            ->get();
        ////////////////////////////////////////////////

        //OBTIENE LAS CATEGORÍAS QUE ESTÁN DISPONIBLES SOLAMENTE ( con productos en stock)
        $categoryAvailable = DB::table('category_products')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('products')
                    ->whereColumn('products.id_category_product', 'category_products.id');
            })
            ->get();
        ////////////////////////////////////////////////

        $bestSellers = DB::table('products_orders')
            ->select('products_orders.product_id', 'products.name_product', 'products.description', 'products.image_product', 'products.price', 'products.stock', 'products.id', DB::raw('sum(products_orders.cantidad) as cantidad'))
            ->join('products', 'products_orders.product_id', 'products.id')
            ->groupBy('products_orders.product_id', 'products.name_product', 'products.description', 'products.image_product', 'products.price', 'products.stock', 'products.id')
            ->limit(3)
            ->orderBy('cantidad', 'DESC')
            ->get();
        ////////////////////////////////////////////////


        //OBTIENE LAS CATEGORÍAS QUE ESTÁN DISPONIBLES SOLAMENTE Y PASA SOLO LOS NOMBRES A UN ARRAY( con productos en stock)
        $categoryAvailableNames = $categoryAvailable->pluck('name')->toArray();
        ////////////////////////////////////////////////

        return view('Usuario.Landing.landing', compact('category_products', 'categoryAvailable', 'productAvailable', 'categoryAvailableNames', 'bestSellers'));
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

        $rules = [
            'name_order'          => 'required|string',
            'cantidad' => 'required|min:1',
            'cantidad.*' => 'required',
            'address' => 'required',
            'mail' => 'required',
            'number' => 'required|gt:0|integer',
            'payment_method' => 'required',

        ];
        $messages = [
            'required'      => 'Este campo es obligatorio',
            'cantidad.required' => 'Debes seleccionar al menos un producto',
            'address.required' => 'Debes seleccionar el tipo de envío',
            'payment_method.required' => 'Debes seleccionar un método de pago',
            'integer' => 'El número no puede ser decimal',
            'gt' => 'El número debe ser mayor a 0'
        ];

        $values = request()->except('_token');
        $productos = json_decode($values['cantidad']);
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $totalValue = 0;
                $cantidades = array();
                $checkStock = array();
                $values = request()->except('_token');
                $order = new Order;
                $order->name_order = $values['name_order'];
                $order->mail = $values['mail'];
                $order->number = $values['number'];
                $order->payment_method = $values['payment_method'];
                $order->name_order = $values['name_order'];
                $order->order_status = 'Espera';
                $order->pick_up = $values['pick_up'];
                $order->address = $values['address'];
                foreach ($productos as $product) {
                    array_push($cantidades, $product->cantidad);
                    $totalValue += ($product->price * $product->cantidad);
                    $productToCheck = product::find($product->id);
                    if ($product->cantidad <= $productToCheck->stock) {
                        $productToCheck->stock = $productToCheck->stock - $product->cantidad;
                        $productToCheck->save();
                    } else {
                        array_push($checkStock, [$product->id, $product->cantidad - $productToCheck->stock]);
                    }
                }
                //////////////VALIDA EL CUPÓN////////////
                if ($values['coupon'] != null) {
                    $couponToCheck = coupon::where('code', $values['coupon'])->first();
                    if ($couponToCheck) {
                        $newQuantity = $couponToCheck->quantity - 1;
                        $userId = auth()->user()->id;
                        $user = User::find($userId);
                        //VERIFICAMOS QUE EL USUARIO NO OCUPE EL MISMO CUPÓN MÁS DE 1 VEZ
                        $checkUserCoupon = DB::table('coupon_user')
                            ->select(
                                'id',
                            )
                            ->where('coupon_id', $couponToCheck->id)
                            ->where('user_id', $userId)
                            ->get();


                        if (sizeof($checkUserCoupon) > 0) {
                            return Response::json(array(
                                'success' => false,
                                'coupon' => false,
                                'message' => 'Ya has utilizado este cupón',
                                'errors' => ['coupon' => '']

                            ), 400);
                        } else {
                            $user->coupons()->attach($couponToCheck->id);
                        }
                    } else {
                        return Response::json(array(
                            'success' => false,
                            'coupon' => false,
                            'message' => 'El cupón no existe',
                            'errors' => ['coupon' => '']

                        ), 400);
                    }
                    if ($couponToCheck != null && $newQuantity >= 0 && $couponToCheck->emited <= $couponToCheck->caducity) {
                        $order->total = $totalValue * (1 - $couponToCheck->percentage / 100);
                        $couponToCheck->quantity = $newQuantity;
                        $couponToCheck->save();
                    } else {
                        return Response::json(array(
                            'success' => false,
                            'coupon' => false,
                            'message' => 'El cupón expiró',

                        ), 400);
                    }
                } else {
                    $order->total = $totalValue;
                }
                ////////////////////////////////////
                $order->save();

                //RELLENA LA TABLA RELACION ENTRE PRODUCTOS Y ORDERS
                for ($i = 0; $i < sizeof($cantidades); $i++) {
                    $order->products()->attach($productos[$i]->id, ['cantidad' => $cantidades[$i]]);
                }
                //SI ESTE ARRAY CONTIENE VALORES SON LOS PRODUCTOS QUE NO TIENEN EL STOCK SUFICIENTE Y LOS RETORNA
                if (sizeof($checkStock) > 0) {
                    DB::connection(session()->get('database'))->rollBack();
                    return Response::json(array(
                        'success' => false,
                        'stock' => false,
                        'errors' => $checkStock,
                        'message' => 'Ocurrió un problema con el stock'

                    ), 400);
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////
                // $couponToCheck = coupon::find('code', );
                DB::connection(session()->get('database'))->commit();
                return response('Se ingresó la orden con exito.', 200);


                // $order->products()->attach($id, ['cantidad' => $cont]);
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return Response::json(array(
                    'success' => false,
                    'message' => 'Ocurrió un error. No se generó la compra'

                ), 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
                'message' => 'Faltan campos por completar',
            ), 400);
        }
        return Response::json(array(
            'success' => false,
            'message' => 'Ocurrió un error. No se generó la compra'

        ), 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function show(landing $landing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function edit(landing $landing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, landing $landing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function destroy(landing $landing)
    {
        //
    }

    public function checkCoupon(request $request)
    {
        $values = request()->except('_token');

        $couponToCheck = coupon::where('code', $values['code'])->first();
        if ($couponToCheck) {
            if ($couponToCheck->emited <= $couponToCheck->caducity && $couponToCheck->quantity - 1 >= 0) {
                return Response::json(array(
                    'success' => true,
                    'correct' => 'El cupón es valido',
                    'couponPercentage' => $couponToCheck->percentage

                ), 200);
            } else {
                return Response::json(array(
                    'success' => false,
                    'errors' => 'El cupón ya caducó'

                ), 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => 'El cupón no es valido'

            ), 400);
        }
    }

    public function userProfile(request $request)
    {
        $userId = auth()->user()->id;
        $userData = user::where('id', $userId)->first();
        //OBTIENE TODAS LAS CATEGORÍAS
        $category_products = category_product::all();
        ////////////////////////////////////////////////
        return view('Usuario.Profile.profile', compact('userData', 'category_products'));
    }

    public function updateUserProfile(request $request, user $user)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|max:12',
            'passwordConfirm' => 'required|min:5|max:12',
            'address' => 'required',
            'phone' => 'required|lt:999999999|gt:0'
        ];
        $messages = [
            'required' => ' El campo es obligatorio',
            'email' => ' No es un correo electrónico válido.',
            'lt' => ' El numero no existe',
            'gt' => ' No es un numero valido',
            'min' => ' Como minimo deben ser 5 caracteres',
            'max' => ' Como máximo deben ser 12 caracteres',

        ];
        $values = request()->except('_token');
        $userId = $user->id;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $user = user::find($userId);
                $user->name = $values['name'];
                $user->email = $values['email'];
                $user->address = $values['address'];
                $user->phone = $values['phone'];
                if ($values['password'] != 'empty' && $values['passwordConfirm'] != 'empty') {
                    if ($values['password'] == $values['passwordConfirm']) {
                        $user->password = Hash::make($values['password']);
                    } else {
                        return Response::json(array(
                            'success' => false,
                            'message' => 'Ocurrió un error. Intentalo nuevamente',
                            'errors' => ['password' => 'Las contraseñas no coinciden'],

                        ), 400);
                    }
                }
                $user->save();
                DB::connection(session()->get('database'))->commit();
                return Response::json(array(
                    'success' => true,
                    'message' => 'Se actualizó el perfil correctamente'

                ), 200);
            } catch (\Throwable $t) {
                DB::connection(session()->get('database'))->rollBack();
                return Response::json(array(
                    'success' => false,
                    'message' => 'Ocurrió un error. Intentalo nuevamente'

                ), 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
                'message' => 'Faltan campos por completar'

            ), 400);
        }
    }
}

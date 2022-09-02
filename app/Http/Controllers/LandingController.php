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
use App\Models\map;
use App\Models\image_main;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use URL;
class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
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
                    ->whereNull('products.deleted_at')

                    ->whereColumn('products.id_category_product', 'category_products.id');
            })
            ->get();
        ////////////////////////////////////////////////

        $bestSellers = DB::table('products_orders')
            ->select('products_orders.product_id', 'products.name_product', 'products.description', 'products.image_product', 'products.price', 'products.stock', 'products.id', DB::raw('sum(products_orders.cantidad) as cantidad'))
            ->join('products', 'products_orders.product_id', 'products.id')
            ->whereNull('products.deleted_at')
            ->groupBy('products_orders.product_id', 'products.name_product', 'products.description', 'products.image_product', 'products.price', 'products.stock', 'products.id')
            ->limit(3)
            ->orderBy('cantidad', 'DESC')
            ->get();
        ////////////////////////////////////////////////


        //OBTIENE LAS CATEGORÍAS QUE ESTÁN DISPONIBLES SOLAMENTE Y PASA SOLO LOS NOMBRES A UN ARRAY( con productos en stock)
        $categoryAvailableNames = $categoryAvailable->pluck('name')->toArray();
        ////////////////////////////////////////////////
        $imagesMain = image_main::orderBy('order')->get();



        return view('Usuario.Landing.landing', compact('category_products', 'categoryAvailable', 'productAvailable', 'categoryAvailableNames', 'imagesMain', 'bestSellers'));
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

    public function ubicacion()
    {
        return view('Usuario.Landing.Location');
    }

    public function getLocation()
    {
        $location = DB::table('maps')
            ->select('maps.latitud', 'maps.longitud', 'maps.direccion')
            ->where('maps.id', 1)
            ->get();



        return response($location, 200);
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
            'number' => 'required|gt:910000000|lt:999999999|integer',
            'payment_method' => 'required',
            'comment' => 'max:255'
        ];
        $messages = [
            'required'      => 'Este campo es obligatorio',
            'cantidad.required' => 'Debes seleccionar al menos un producto',
            'address.required' => 'Debes seleccionar el tipo de envío',
            'payment_method.required' => 'Debes seleccionar un método de pago',
            'integer' => 'El número no puede ser decimal',
            'gt' => 'El número no es válido, modifíquelo en su perfil',
            'lt' => 'El número no es válido, modifíquelo en su perfil',
            'comment.max' => 'Has excedido el limite de texto'
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
                $order->comment = $values['comment'];
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
                        // $productToCheck->stock = $productToCheck->stock - $product->cantidad;
                        // $productToCheck->save();
                    } else {
                        array_push($checkStock, [$product->id, $product->cantidad - $productToCheck->stock]);
                    }
                }
                //Suma el valor del delivery al valor total
                if ($values['delivery_price'] != null) {
                    $totalValue += $values['delivery_price'];
                }

                if (auth()->user()) {
                    $userId = auth()->user()->id;
                    $user = User::find($userId);
                    //////////////VALIDA EL CUPÓN////////////
                    if ($values['coupon'] != null) {
                        $couponToCheck = coupon::where('code', $values['coupon'])->first();
                        if ($couponToCheck) {
                            $newQuantity = $couponToCheck->quantity - 1;

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
                            $totalValue = $totalValue * (1 - $couponToCheck->percentage / 100);
                            $couponToCheck->quantity = $newQuantity;
                            $couponToCheck->save();
                        } else {
                            return Response::json(array(
                                'success' => false,
                                'coupon' => false,
                                'message' => 'El cupón expiró',

                            ), 400);
                        }
                    }
                    ////////////////////////////////////
                }
                if (intval($values['paymentSelected']) != 0) {
                    $totalValue = $totalValue * 1.0319;
                }
                $order->total = intval($totalValue);
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
                if (auth()->user()) {
                    $user->orders()->attach($order->id);
                }
                //SI EL METODO DE PAGO NO ES EFECTIVO
                if (intval($values['paymentSelected']) != 0) {
                    $order->delete();

                    /////////////COMIENZO LLAMADA DE PASARELA DE PAGO

                    $token = request()->_token;
                    $urlConfirmation = URL::to('/') . "/landing";
                    $urlReturn = URL::to('/') . "/landing/confirmation";
                    //$urlConfirmation = $request->segment($index, 'default')
                    $params = array(
                        "apiKey" => "6C7EEDFF-CE18-4A7C-8372-86DAB5D6L117",
                        "token" => $token,
                        "commerceOrder" => $order->id,
                        "subject" => "Nueva compra",
                        "amount" => intval($totalValue),
                        "email" => $values['mail'],
                        "urlConfirmation" => $urlConfirmation,
                        "urlReturn" => $urlReturn,
                        "paymentMethod" => intval($values['paymentSelected']),

                    );
                    $keys = array_keys($params);
                    sort($keys);
                    $secretKey = "13d5ea307f465ffed4051223d5327490d032e0b2";

                    $toSign = "";
                    foreach ($keys as $key) {
                        $toSign .= $key . $params[$key];
                    };

                    $signature = hash_hmac('sha256', $toSign, $secretKey);

                    $url = 'https://sandbox.flow.cl/api';
                    // Agrega a la url el servicio a consumir
                    $url = $url . '/payment/create';

                    //Agrega la firma a los parámetros
                    $params["s"] = $signature;

                    try {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($ch, CURLOPT_POST, TRUE);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                        $response = curl_exec($ch);
                        if ($response === false) {
                            $error = curl_error($ch);
                            throw new Exception($error, 1);

                            return Response::json(array(
                                'success' => false,
                                'message' => 'Problema con los servicios de pago. Intentelo más tarde',

                            ), 400);
                        }
                        $info = curl_getinfo($ch);
                        if (!in_array($info['http_code'], array('200', '400', '401'))) {
                            return Response::json(array(
                                'success' => false,
                                'message' => 'Problema con los servicios de pago. Intentelo más tarde',

                            ), 400);
                        }
                        $responseToJSON = json_decode($response);

                        if (isset($responseToJSON->code)) {
                            if ($responseToJSON->code == 1620) {
                                return Response::json(array(
                                    'success' => false,
                                    'message' => 'El correo no existe, verifiquelo',
                                ), 400);
                            }
                        }
                        if (in_array($info['http_code'], array('200'))) {

                            $payUrl = $responseToJSON->url . "?token=" . $responseToJSON->token;
                            DB::connection(session()->get('database'))->commit();

                            return Response::json(array(
                                'success' => true,
                                'urlCompra' => $payUrl,
                                'message' => 'Redirigiendo hacía página de compra...',

                            ), 200);
                        } else {
                            return Response::json(array(
                                'success' => false,
                                'message' => 'Ocurrió un error al intentar pagar , intentalo nuevamente o selecciones otro método de pago.',

                            ), 400);
                        }
                    } catch (Exception $e) {
                        echo 'Error: ' . $e->getCode() . ' - ' . $e->getMessage();
                    }

                    ///////////////FIN LLAMADA PASARELA DE PAGO
                }

                DB::connection(session()->get('database'))->commit();
                return response('Se ingresó la orden con exito.', 200);


                // $order->products()->attach($id, ['cantidad' => $cont]);
            } catch (\Throwable $th) {
                dd($th);
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

    public function transactionConfirmation(request $request)
    {
        $values = request()->except('_token');

        $params = array(
            "token" => $values['token'],
            "apiKey" => "6C7EEDFF-CE18-4A7C-8372-86DAB5D6L117"

        );
        $keys = array_keys($params);
        sort($keys);
        $secretKey = "13d5ea307f465ffed4051223d5327490d032e0b2";

        $toSign = "";

        foreach ($keys as $key) {
            $toSign .= $key . $params[$key];
        };

        $signature = hash_hmac('sha256', $toSign, $secretKey);

        $url = 'https://sandbox.flow.cl/api';
        // Agrega a la url el servicio a consumir
        $url = $url . '/payment/getStatus';
        // agrega la firma a los parámetros
        $params["s"] = $signature;
        //Codifica los parámetros en formato URL y los agrega a la URL
        $url = $url . "?" . http_build_query($params);
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($ch);
            if ($response === false) {
                $error = curl_error($ch);
                throw new Exception($error, 1);
            }
            $info = curl_getinfo($ch);
            // if (!in_array($info['http_code'], array('200', '400', '401'))) {
            //     throw new Exception('Unexpected error occurred. HTTP_CODE: ' . $info['http_code'], $info['http_code']);
            // }
            if (in_array($info['http_code'], array('200'))) {
                $responseToJSON = json_decode($response);
                $resultadosOrden = [
                    'orden_compra' => $responseToJSON->commerceOrder,
                    'fecha_compra' => $responseToJSON->requestDate,
                    'estado_compra' => $responseToJSON->status,
                    'correo_comprador' => $responseToJSON->payer,
                    'monto' => $responseToJSON->amount,
                    'medio_pago' => $responseToJSON->paymentData->media,
                ];
                //CASO SE COMPLETÓ PAGO CORRECTAMENTE
                if ($responseToJSON->status == 2) {
                    Order::where('id', $responseToJSON->commerceOrder)->restore();

                    //ESTO ES PARA RESTAR AL STOCK  DE LOS PRODUCTOS SOLO EN EL CASO QUE EL PAGO SE EFECTUÓ CORRECTAMENTE...
                    $products = DB::table('products_orders')
                        ->select(
                            'id',
                            'product_id',
                            'cantidad'
                        )
                        ->where('order_id', $responseToJSON->commerceOrder)
                        ->get();
                    foreach ($products as $product_quantity) {
                        $product = product::find($product_quantity->product_id);
                        $product->stock -= $product_quantity->cantidad;
                        $product->save();
                    }
                    //////////////////////////////////

                    return view('Usuario.Landing.paymentConfirmed', $resultadosOrden);
                    // return view('Usuario.landing.paymentFailed', $resultadosOrden);
                } else {


                    //CASOS 1, 3 Y 4
                    if ($responseToJSON->status == 1) {
                        $resultadosOrden['estado_compra'] = 1;
                    } else if ($responseToJSON->status == 3) {
                        $resultadosOrden['estado_compra'] = 3;
                    } else {
                        $resultadosOrden['estado_compra'] = 4;
                    }
                    return view('Usuario.Landing.paymentFailed', $resultadosOrden);
                }
            } else {
                return view('Usuario.Landing.paymentError');
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getCode() . ' - ' . $e->getMessage();
        }
    }

    public function transactionVoucher(request $request)
    {

        $values = request()->except('_token');
        $idOrden = $values['id'];

        $datosOrden = DB::table('orders')
            ->select(
                'id',
                'name_order',
                'total',
                'mail',
                'payment_method',
                'created_at',
                'total'
            )
            ->where('id', $idOrden)
            ->get();
        $direccionLocal = DB::table('maps')->select('direccion')->get();
        $direccionLocal = $direccionLocal[0]->direccion;

        $productosComprados = DB::select("SELECT products.name_product, products.price ,products_orders.cantidad FROM products JOIN products_orders on(products.id=products_orders.product_id ) JOIN orders on (orders.id=products_orders.order_id)
        WHERE orders.id = $idOrden");
        $pdf = Pdf::loadView('Usuario.Landing.paymentVoucher',  compact('datosOrden', 'productosComprados', 'direccionLocal'));
        return $pdf->download('boleta.pdf');
        // return view('Usuario.Landing.paymentVoucher', compact('datosOrden', 'productosComprados', 'direccionLocal'));
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

    public function updateUserProfile(request $request, User $user)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|max:12',
            'passwordConfirm' => 'required|min:5|max:12',
            'address' => 'required',
            'phone' => 'required|lt:999999999|gt:910000000'
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

    public function userCart(request $request)
    {
        $mapa = map::first();
        return view('Usuario.Cart.cart', compact('mapa'));
    }
}

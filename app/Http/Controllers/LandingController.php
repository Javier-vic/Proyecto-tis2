<?php

namespace App\Http\Controllers;

use App\Models\category_product;
use Illuminate\Support\Facades\DB;
use App\Models\landing;
use Illuminate\Http\Request;
use App\Models\order;
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

        //OBTIENE LAS CATEGORÍAS QUE ESTÁN DISPONIBLES SOLAMENTE Y PASA SOLO LOS NOMBRES A UN ARRAY( con productos en stock)
        $categoryAvailableNames = $categoryAvailable->pluck('name')->toArray();
        ////////////////////////////////////////////////

        return view('usuario.landing.landing', compact('category_products', 'categoryAvailable', 'productAvailable', 'categoryAvailableNames'));
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
            'payment_method' => 'required'

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
        // dd($values);
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $totalValue = 0;
                $cantidades = array();
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
                }
                $order->total = $totalValue;
                $order->save();

                try {
                    for ($i = 0; $i < sizeof($cantidades); $i++) {
                        $order->products()->attach($productos[$i]->id, ['cantidad' => $cantidades[$i]]);
                    }
                    DB::connection(session()->get('database'))->commit();
                    return response('Se ingresó la orden con exito.', 200);
                } catch (\Throwable $th) {
                    DB::connection(session()->get('database'))->rollBack();
                    return response('Ocurrió un error. No se pudo crear la orden. ', 400);
                }

                // $order->products()->attach($id, ['cantidad' => $cont]);
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('Ocurrió un error. No se pudo crear la orden. ', 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }
        return response('No se pudo realizar el ingreso de la ordenFINORDER.', 400);
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
}

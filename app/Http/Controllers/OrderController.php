<?php

namespace App\Http\Controllers;

use App\Http\Controllers\productController;
use App\Models\order;
use App\Models\products_orders;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {

            return datatables(DB::connection(session()->get('database'))
                ->table('orders')
                ->select(
                    'orders.id as _id',
                    'orders.id',
                    'orders.name_order',
                    'orders.address',
                    'orders.order_status',
                    'orders.payment_method',
                    'orders.pick_up',
                    'orders.total'

                )
                ->orderByDesc('id')
                ->get())
                ->addColumn('viewOrder', 'mantenedores.order.datatable.view')
                ->rawColumns(['viewOrder'])
                ->addColumn('action', 'mantenedores.order.datatable.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        //
        // consulta de los productos mas ordenados
        //


        $years = DB::table('orders')
            ->select((DB::raw('YEAR(orders.created_at) year')))
            ->groupby('year')
            ->get();


        ///
        ///
        ///


        return view('Mantenedores.order.index', ['years' => $years]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product =  $valores = DB::table('products')
            ->select('*')
            ->where('products.stock', '>', 0)
            ->get();


        $category =  DB::table('category_products')
            ->select('category_products.name')
            ->get();

        return view('Mantenedores.order.create', compact('product', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, product $product)
    {


        $rules = [
            'name_order'          => 'required|string',
            'cantidad' => 'required|array|min:1',
            'cantidad.*' => 'required|gt:0|integer',
            'address' => 'required'

        ];
        $messages = [
            'required'      => 'Este campo es obligatorio',
            'cantidad.required' => 'Debes seleccionar al menos un producto',
            'integer' => 'El número no puede ser decimal',
            'gt' => 'El número debe ser mayor a 0'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $datosOrder = request()->except('_token');
                $order = new order;
                $order->name_order = $datosOrder['name_order'];
                $order->order_status = $datosOrder['order_status'];
                $order->payment_method = $datosOrder['payment_method'];
                $order->address = $datosOrder['address'];


                $order->pick_up = $datosOrder['pick_up'];
                $order->comment = $datosOrder['comment'];

                $permits = array();
                $cantidad = array();
                $valores = array();
                $price = array();



                foreach ($datosOrder['cantidad'] as $item => $value) {

                    if ($value > 0 && isset($value)) {

                        $cantidad[] = (int)$value;
                        $permits[] = (int)$item;
                    }
                }

                // consulta de precio y stock a productos seleccinados

                $valores = DB::table('products')
                    ->select('products.price', 'products.stock', 'products.id')
                    ->whereIn('id', $permits)
                    ->get();

                // obtenemos las cantidades disponibles


                $size = sizeof($permits);

                //      Calcular el total   ////
                for ($i = 0; $i < $size; $i++) {
                    $stock = $valores[$i]->stock;
                    if ($stock < $cantidad[$i]) {
                        return Response::json(array(
                            'success' => false,
                            'errors2' => $valores

                        ), 400);
                    } else {
                        $updateproducts = product::find($permits[$i]);
                        $updateproducts->stock = $stock - $cantidad[$i];
                        $updateproducts->update();
                    }

                    $price[$i] = $cantidad[$i] * $valores[$i]->price;
                }

                $x = array_sum($price);


                $order->total = $x;
                $order->save();

                for ($i = 0; $i < $size; $i++) {
                    $id = $permits[$i]; //id
                    $cont = $cantidad[$i]; //cantidad


                    $order->products()->attach($id, ['cantidad' => $cont]);
                    DB::connection(session()->get('database'))->commit();
                    return response('Se ingresó la orden con éxito.', 200);
                }
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('No se pudo realizar el ingreso de la orden.', 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }





        return view('Mantenedores.order.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(order $order)
    {


        $orderData = order::findOrFail($order->id);



        $productsSelected = DB::table('products_orders')
            ->where('products_orders.order_id', '=', $order->id)
            ->whereNull('products.deleted_at')
            ->join('products', 'products_orders.product_id', 'products.id')
            ->select(
                'products_orders.product_id',
                'products_orders.cantidad',
                'products.*'

            )
            ->orderBy('products_orders.order_id')
            ->get();


        $selectedIds = $productsSelected->pluck('product_id');

        $product = DB::table('products')
            ->select('*')
            ->whereNotIn('id', $selectedIds)
            ->where('products.stock', '>', 0)
            ->orderBy('products.id')
            ->get();




        return view('Mantenedores.order.edit', compact('orderData', 'product', 'productsSelected'));
    }








    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order, product $product)
    {
        $rules = [
            'name_order'          => 'required|string',
            'cantidad' => 'required|array|min:1',
            'cantidad.*' => 'required|gt:0|integer',
            'address' => 'required'

        ];
        $messages = [
            'required'      => 'Este campo es obligatorio',
            'cantidad.required' => 'Debes seleccionar al menos un producto',
            'integer' => 'El número no puede ser decimal',
            'gt' => 'El número debe ser mayor a 0'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $datosOrder = request()->except('_token');
                $productos = order::find($order->id);

                $productos->name_order = $datosOrder['name_order'];
                $productos->order_status = $datosOrder['order_status'];
                $productos->payment_method = $datosOrder['payment_method'];
                $productos->address = $datosOrder['address'];
                $productos->pick_up = $datosOrder['pick_up'];
                $productos->comment = $datosOrder['comment'];

                $permits = array();
                $cantidad = array();
                $valores = array();
                $price = array();


                foreach ($datosOrder['cantidad'] as $item => $value) {

                    if ($value > 0 && isset($value)) {

                        $cantidad[] = (int)$value;
                        $permits[] = (int)$item;
                    }
                }




                $valores = DB::table('products')
                    ->select('products.price', 'products.stock', 'products.id')
                    ->whereIn('id', $permits)
                    ->get();

                for ($i = 0; $i < count($cantidad); $i++) {


                    $cantidadOld = DB::table('products_orders')
                        ->select('products_orders.cantidad')
                        ->where('order_id', $order->id)
                        ->where('product_id', $permits[$i])
                        ->get();

                    if (isset($cantidadOld[0]->cantidad)) {
                        $old = $cantidadOld[0]->cantidad;
                    } else {

                        $old = 0;
                    }

                    $stock = $valores[$i]->stock;


                    if ($old  <= $cantidad[$i]) {

                        if (($cantidad[$i] - $old) <= $stock) {

                            $updateproducts = product::find($permits[$i]);
                            $updateproducts->stock = $stock - ($cantidad[$i] - $old);
                            $updateproducts->save();
                        } else {
                            return Response::json(array(
                                'success' => false,
                                'errors2' => $valores

                            ), 400);
                        }
                    } else {

                        $updateproducts = product::find($permits[$i]);
                        $updateproducts->stock = $stock + ($old - $cantidad[$i]);
                        $updateproducts->save();
                    }
                    $price[$i] = $cantidad[$i] * $valores[$i]->price;
                }
                $x = array_sum($price);



                $productos->total = $x;
                $productos->save();

                $order->products()->detach();

                for ($i = 0; $i < count($permits); $i++) {
                    $id = $permits[$i]; //id
                    $cont = $cantidad[$i]; //cantidad


                    $order->products()->attach($id, ['cantidad' => $cont]);
                }
                DB::connection(session()->get('database'))->commit();
                return response('Se editó la orden con éxito.', 200);
            } catch (\Throwable $th) {
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }



        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */



    public function getview(request $request)
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

    public function getMonthOrder(request $request)
    {

        $sales = DB::table('orders')
            ->select(DB::raw('sum(orders.total) as `data`'), DB::raw('YEAR(orders.created_at) year, MONTH(orders.created_at) month'))
            ->whereyear('created_at', $request->year)
            ->groupby('year', 'month')
            ->get();




        return response($sales, 200);
    }

    ///eliminar

    public function getbestsellers()
    {

        $bestseller = DB::table('products_orders')
            ->select('products_orders.product_id', 'products.name_product', DB::raw('sum(products_orders.cantidad) as cantida'))
            ->join('products', 'products_orders.product_id', 'products.id')
            ->groupBy('products_orders.product_id', 'products.name_product')
            ->limit(3)
            ->orderBy('cantida', 'DESC')
            ->get();



        return response($bestseller, 200);
    }

    public function destroy(order $order)
    {


        $order = order::find($order->id);
        $order->delete();
        return view('Mantenedores.order.index');
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\productController;
use App\Models\order;
use App\Models\products_orders;
use App\Models\product;
use App\Models\user;
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

        if (isset($years[0])) {
            return view('Mantenedores.order.index', ['years' => $years]);
        } else {
            return view('Mantenedores.order.index');
        }
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
            'name_order' => 'required|string',
            'cantidad' => 'required|min:1',
            'cantidad.*' => 'required|gt:0|integer',

            'payment_method' => 'required',
            'comment' => 'max:255'


        ];
        $messages = [
            'required'      => 'Este campo es obligatorio',
            'cantidad.required' => 'Debes seleccionar al menos un producto',
            'payment_method.required' => 'Debes seleccionar un método de pago',
            'integer' => 'El número no puede ser decimal',
            'comment.max' => 'Has excedido el limite de texto',
            'gt' => 'El número debe ser mayor a 0'
        ];

        $values = request()->except('_token');
        $cantidad = $values['cantidad'];
        $cantidadIds =  array_keys($values['cantidad']);


        // $productos = json_decode($values['cantidad']);



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
                foreach ($cantidad as $key => $product) {
                    $productToCheck = product::find($key);
                    array_push($cantidades, intval($product));
                    $totalValue += ($productToCheck->price * intval($product));

                    if (intval($product) <= $productToCheck->stock) {
                        $productToCheck->stock = $productToCheck->stock - intval($product);
                        $productToCheck->save();
                    } else {
                        array_push($checkStock, [$key, intval($product) - $productToCheck->stock]);
                    }
                }

                $order->total = $totalValue;
                $order->save();

                //RELLENA LA TABLA RELACION ENTRE PRODUCTOS Y ORDERS
                foreach ($cantidad as $key => $product) {
                    $order->products()->attach($key, ['cantidad' => intval($product)]);
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
    public function pendingOrdersView()
    {

        $pendingOrders = order::where('order_status', '!=', 'Listo')->get();
        foreach ($pendingOrders as $order) {
            $productsOrder = DB::table('products')
                ->select('*')
                ->join('products_orders', 'products.id', '=', 'products_orders.product_id')
                ->where('products_orders.order_id', '=', $order->id)
                ->get();
            $order->listProducts = $productsOrder;
        }
        return view('Mantenedores.order.pending', ['pendingOrders' => $pendingOrders]);
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
                $productos->number = $datosOrder['number'];
                $productos->mail = $datosOrder['mail'];

                //VERIFICAMOS SI ES QUE SE ELIMINÓ ALGÚN PRODUCTO PARA DEVOLVER SU CANTIDAD PEDIDA AL STOCK
                $productosOld = DB::table('products_orders')
                    ->select(
                        'product_id',
                        'cantidad'
                    )
                    ->where('order_id', $order->id)
                    ->pluck('cantidad', 'product_id')
                    ->toArray();

                $productosNew = array_map('intval', $datosOrder['cantidad']);

                $productosDeleted = array_diff($productosOld, $productosNew);
                if ($productosDeleted != []) {
                    foreach ($productosDeleted as $id => $quantity) {
                        $updateStock = product::find($id);
                        $updateStock->stock += $productosOld[$id];
                        $updateStock->save();
                    }
                }
                ////////////////////////////////////////////////////////////////////////////////////////////

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
                dd($th);
                DB::connection(session()->get('database'))->rollBack();
                return Response::json(array(
                    'success' => false,
                    'message' => 'Ocurrió un error. Intentalo nuevamente'

                ), 400);
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

    public function GetSaleMonth(request $request)
    {

        $mes = Carbon::now();
        $año = $mes->year;
        $mes = $mes->month;

        $saleYear = DB::table('orders')
            ->select(DB::raw('COALESCE(sum(orders.total), 0) as `ganancias` , count(orders.id) as `data`'))
            ->whereYear('orders.created_at', '=', $año)
            ->get();



        $saleMonth = DB::table('orders')
            ->select(DB::raw('COALESCE(sum(orders.total), 0) as `ganancias` , count(orders.id) as `data`'))
            ->whereMonth('orders.created_at', '=', $mes)
            ->get();


        $countProducts = DB::table('products')
            ->select(DB::raw('count(products.id) as `countproducts`'))
            ->where('products.stock', '=', 0)
            ->get();

        $listProducts = DB::table('products')
            ->select('products.name_product')
            ->where('products.stock', '=', 0)
            ->get();


        $countSupplies = DB::table('supplies')
            ->select(DB::raw('count(supplies.id) as `countsupplies`'))
            ->where('supplies.critical_quantity', '>=', 'supplies.unit_meassurement')
            ->get();


        $listSupplies = DB::table('supplies')
            ->select('supplies.name_supply', 'supplies.critical_quantity', 'supplies.unit_meassurement', 'supplies.quantity')
            ->where('supplies.critical_quantity', '>=', 'supplies.unit_meassurement')
            ->orderBy('supplies.unit_meassurement')
            ->get();

        $years = DB::table('orders')
            ->select((DB::raw('YEAR(orders.created_at) year')))
            ->groupby('year')
            ->get();


        ///
        ///
        ///

        if (isset($years[0])) {
            return response::json(array(
                'saleMonth' => $saleMonth,
                'saleYear' => $saleYear,
                'years' => $years,



            ), 200);
        } else {
            return response::json(array(
                'saleMonth' => $saleMonth,
                'saleYear' => $saleYear,

            ), 200);
        }
    }

    public function getMonthOrder(request $request)
    {

        $sales = DB::table('orders')
            ->select(DB::raw('sum(orders.total) as `data`, count(orders.id) as `cantidad`'), DB::raw('YEAR(orders.created_at) year, MONTH(orders.created_at) month'))
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
            ->limit(5)
            ->orderBy('cantida', 'DESC')
            ->get();


        return response($bestseller, 200);
    }

    public function getBestClient()
    {

        $BestClient = DB::table('orders')
            ->select('users.name', 'users.email', 'users.phone', DB::raw('COALESCE(sum(orders.total), 0)  as gastado'), DB::raw('count(orders.id) as cantidad'))
            ->leftjoin('order_user', 'orders.id', 'order_user.id_order')
            ->rightjoin('users', 'order_user.id_user', 'users.id')
            ->where('users.id_role', 2)
            ->where('orders.total', ">", 0)
            ->limit(5)
            ->groupby('users.name', 'users.email', 'users.phone')
            ->orderby('orders.total', 'DESC')
            ->get();


        return response($BestClient, 200);
    }



    public function destroy(order $order)
    {


        $order = order::find($order->id);
        $order->delete();
        return view('Mantenedores.order.index');
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

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\productController;
use App\Models\order;
use App\Models\products_orders;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\support\Facades\DB;
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
                ->orderBy('orders.id', 'DESC')
                ->get())
                ->addColumn('viewOrder', 'mantenedores.order.datatable.view')
                ->rawColumns(['viewOrder'])
                ->addColumn('action', 'mantenedores.order.datatable.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('Mantenedores.order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = product::all();

        return view('Mantenedores.order.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        
        
        foreach ($datosOrder['permits'] as $item => $value) {
            $permits[] = (int)$value;
        }
        // consulta de precio y stock a productos seleccinados

        $valores = DB::table('products')
        ->select('products.price' ,'products.stock')
        ->whereIn('id', $permits)
        ->get();
         
        // obtenemos las cantidades seleccionadas

        foreach ($datosOrder['cantidad'] as $item => $value) {
            if ($value > 0) {
                $cantidad[] = (int)$value;
                
            }
        }
       
        //      Calcular el total   ////
        for ($i = 0; $i < sizeof($permits); $i++) {
            $stock = $valores[$i]->stock;
            if($stock <= $cantidad[$i]){

                return response('No hay stock suficiente',400);

            }

            $price[$i] = $cantidad[$i] * $valores[$i]->price;
            
        }

        $x = array_sum($price);


        $order->total = $x;
        $order->save();

        for ($i = 0; $i < count($permits); $i++) {
            $id = $permits[$i]; //id
            $cont = $cantidad[$i]; //cantidad

            
            $order->products()->attach($id,['cantidad'=>$cont]);
            
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
        //dd(order::findOrFail($order->id))
        $product = product::all();
        $selectOrder = order::findOrFail($order->id);
        
    
        
        $query = DB::table('products_orders')
        ->select('products_orders.product_id', 'products_orders.cantidad')
        ->where('products_orders.order_id', '=', $order->id)
        ->get();
        
       dd($query);
        $name = $query->pluck('product_id')->all();
        $cantidad = $query->pluck('cantidad')->all(); 
        
        dd($name);
        return view('Mantenedores.order.edit', compact('selectOrder', 'name', 'product','query'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order)
    {   

        
        $productos = order::find($request->id);

        $product = DB::table('products_orders')
        ->select('products_orders.product_id')
        ->where('products_orders.order_id', '=', $request->id)
        ->get();
        
        $datosOrder = request()->except('_token');
        $productos = new order;
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

        foreach ($datosOrder['permits'] as $item => $value) {
            $permits[] = (int)$value;
        }

        $valores = DB::table('products')
        ->select('products.price')
        ->whereIn('id', $permits)
        ->get();




        foreach ($datosOrder['cantidad'] as $item => $value) {
            if ($value > 0) {
                $cantidad[] = (int)$value;
            }
        }

        for ($i = 0; $i < count($cantidad); $i++) {
            $price[$i] = $cantidad[$i] * $valores[$i]->price;
        }
        $x = array_sum($price);


        $productos->total = $x;
        $productos->save();

        for ($i = 0; $i < count($permits); $i++) {
            $id = $permits[$i];
            $cont = $cantidad[$i];

           

            $order->products()->attach($id);
           
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
            ->select('products_orders.product_id','products.name_product', 
            DB::raw('count(products_orders.product_id) as cantidad'))
            ->join('products', 'products_orders.product_id', '=', 'products.id')
            ->where('products_orders.order_id', '=', $id)
            ->groupBy('products_orders.product_id','products.name_product','products.price')
            ->get();
            
        return response(json_encode([$productOrders, $order]), 200);
    }



    public function destroy($id)
    {
        $order = order::findOrFail($id);
        $order->delete($id);

        return redirect('order');
    }
}

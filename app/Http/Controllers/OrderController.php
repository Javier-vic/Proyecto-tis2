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
    public function store(Request $request, product $product )
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

        
        
        foreach ($datosOrder['cantidad'] as $item => $value) {

            if ($value > 0 && isset($value) ){

                $cantidad[] = (int)$value;
                $permits[] = (int)$item;
               
            }
        }
        // consulta de precio y stock a productos seleccinados

        $valores = DB::table('products')
        ->select('products.price' ,'products.stock')
        ->whereIn('id', $permits)
        ->get();
         
        // obtenemos las cantidades disponibles

      
        $size = sizeof($permits);
       
        //      Calcular el total   ////
        for ($i = 0; $i < $size; $i++) {

            $stock = $valores[$i]->stock;
            if($stock <= $cantidad[$i]){

                return response('No hay stock suficiente',400);

            }
            else {

                $updateproducts = product::find($permits[$i]);
                $updateproducts->stock = $stock - $cantidad[$i];
                $updateproducts->save();
                
                

            }

            $price[$i] = $cantidad[$i] * $valores[$i]->price;
            
        }

        $x = array_sum($price);


        $order->total = $x;
        $order->save();

        for ($i = 0; $i < $size; $i++) {
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
        $orderData = order::findOrFail($order->id);

    
        
        $productsSelected = DB::table('products_orders')
        ->where('products_orders.order_id', '=', $order->id)
        ->whereNull('products.deleted_at')
        ->join('products','products_orders.product_id','products.id')
        ->select(
        'products_orders.product_id', 
        'products_orders.cantidad',
        'products.*'

        )
        ->get();

        
        $selectedIds = $productsSelected->pluck('product_id');
        
        $products = DB::table('products')
        ->select('*')
        ->whereNotIn('id',$selectedIds)
        ->whereNull('products.deleted_at')
        ->get();

        
        return view('Mantenedores.order.edit', compact('orderData', 'products','productsSelected'));

    }








    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order , product $product)
    {   
        
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

            if ($value > 0 && isset($value) ){

                $cantidad[] = (int)$value;
                $permits[] = (int)$item;
               
            }
        }
        
        
   

        $valores = DB::table('products')
        ->select('products.price', 'products.stock')
        ->whereIn('id', $permits)
        ->get();

        /** if($stock <= $cantidad[$i]){

                

            } */

        
       
        

        for ($i = 0; $i < count($cantidad); $i++) {

            
            $cantidadOld = DB::table('products_orders')
            ->select('products_orders.cantidad')
            ->where('order_id', $order->id)
            ->where('product_id', $permits[$i])
            ->get();

            $old = $cantidadOld[0]->cantidad;
            $stock = $valores[$i]->stock;

            
            if($old  <= $cantidad[$i]){

                if (($cantidad[$i] - $old) <= $stock) {

                    $updateproducts = product::find($permits[$i]);
                    $updateproducts->stock = $stock - ($cantidad[$i] - $old);
                    $updateproducts->save();
                    
                } else {
                    return response('No hay stock suficiente',400);
                }
                
               
                
               

            }
            else {
                

            
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
            
            
            $order->products()->attach($id,['cantidad'=>$cont]);
            
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
            ->select('products_orders.product_id','products.name_product', 'products_orders.cantidad')
            ->join('products', 'products_orders.product_id', '=', 'products.id')
            ->where('products_orders.order_id', '=', $id)
            ->get();
            
        return response(json_encode([$productOrders, $order]), 200);
    }


    ///eliminar

    public function destroy(order $order)
    {   
       

        $order = order::find($order->id);
        $order->delete();
       return view('Mantenedores.order.index');


    }
}

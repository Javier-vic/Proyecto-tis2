<?php

namespace App\Http\Controllers;

use App\Models\order;
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
        $product = product::all();
        if (request()->ajax()) {

            return datatables(DB::connection(session()->get('database'))
                ->table('orders')
                ->whereNull('orders.deleted_at')
                ->select(
                    'orders.id as _id',
                    'orders.id',
                    'orders.name_order',
                    'orders.total',
                    'orders.order_status',
                    'orders.payment_method',
                    'orders.pick_up',
                    'orders.comment'

                )
                ->orderBy('orders.id')
                ->get())
                ->addColumn('action', 'mantenedores.order.datatable.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        
        return view('Mantenedores.order.index', compact('product'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create()
    {   
        $product = product::all();
    
        return view('Mantenedores.order.create', compact('product'));
    }

    
    public function store(Request $request)
    {   
       
        $datosOrder = request()->except('_token');
        $order = new order;
        $order->name_order = $datosOrder['name_order'];
        $order->order_status = $datosOrder['order_status'];
        $order->payment_method = $datosOrder['payment_method'];
        
        $order->pick_up = $datosOrder['pick_up'];
        $order->comment = $datosOrder['comment'];
        
        $permits = array();
        $cantidad = array();
 
        foreach($datosOrder['permits'] as $item => $value){
            $permits[] = (int)$value;
        }

     

        foreach($datosOrder['cantidad'] as $item => $value){
            if($value > 0){
                $cantidad[] = (int)$value;
            }

            
        }



        $order->total = 0;
        $order->save();

        for ($i=0; $i < count($permits) ; $i++) { 
            $id = $permits[$i];
            $cont = $cantidad[$i];
            
            for ($j=0; $j < $cont ; $j++) { 

                $order->products()->attach($id);
            }
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
      
        $order = order::findOrFail($order->id);
        return view('Mantenedores.order.edit', compact('order'));
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
        $productos = order::find($order->id);
        $productos->name_order = $request->name_order;
        $productos->order_status = $request->order_status;
        $productos->payment_method = $request-> payment_method;
        $productos->total = $request->total;
        $productos->pick_up = $request->pick_up;
        $productos->comment = $request->comment;
        $productos->save();
        
     
        return redirect()->route('order.index');
        
        
    }

    public function addproduct(Request $request)
 
    {   
   


        return view('Mantenedores.order.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */

    public function getselectproducts(Response $response){
        
    $id = request()->id;
    $name = DB::table('products')
            ->where('products_orders.order_id','=',$id)
            ->select('product.name_product', 'pr')
            ->get();
            $permits = DB::table('products_oreders')
                        ->select('products.name_product', 'produts_order.product_id', )
                         ->join('products','products_orders.product_id','=','products.id')
                         ->groupBy('produts_order.order_id')
                         ->groupBy('produts_order.product_id')
                         ->get();



            return json_encode([$name,$permits]);
        

    }


    
    public function destroy($id)
    {
        $order = order::findOrFail($id);
        $order->delete($id);
        return redirect('order');

    }
}

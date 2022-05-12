<?php

namespace App\Http\Controllers;

use App\Models\order;
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
                ->make(true);
        }
        
        return view('Mantenedores.order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('order.create');
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
        $productos = new Product;
        $productos->name_order = $datosOrder['name_order'];
        $productos->order_status = $datosOrder['order_status'];
        $productos->payment_method = $datosOrder['payment_method'];
        $productos->pick_up = $datosOrder['pick_up'];
        $productos->comment = $datosOrder['comment'];
    
        return redirect()->route('Mantenedores.order.index');
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
    public function edit($id)
    {
        //
        $order = order::findOrFail($id);
        return view('order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $datosOrder = request()->except(['_token', '_method']);
        order::where('id','=',$id)->update($datosOrder);

        $order= order::findOrFail($id);
        return view('order.edit', compact('order'));
        
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        order::destroy($id);
        return redirect('order');
    }
}

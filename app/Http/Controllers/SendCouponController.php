<?php

namespace App\Http\Controllers;

use App\Models\sendCoupon;
use Illuminate\Http\Request;
use Illuminate\support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Mail\welcomeMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models;
use DataTables;

class SendCouponController extends Controller
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
                ->table('send_coupons')
                ->select(
                    'orders.code',
                    'orders.emited',
                    'orders.quantity',
                    'orders.clientype',
                    

                )
                ->groupby('code')
                ->orderByDesc('id')
                ->get())
                ->make(true);
        }
     
        return view('Mantenedores.SendCoupon.index');

    }
    
    public function store(Request $request)
    {
        $condition = $request->except('_token');

        if($request->hasFile('foto')){
            $condition['foto'] = $request->file('foto')->store('uploads','public');
        }
        
        switch ($condition['cliente']) {
            case 0:
                $customers =  DB::table('orders')
                ->select( 'users.name', 'users.email','users.phone', DB::raw('COALESCE(sum(orders.total), 0)  as gastado'), DB::raw('count(orders.id) as cantidad'))
                ->leftjoin('order_user','orders.id','order_user.id_order')
                ->rightjoin('users','order_user.id_user','users.id')
                ->where('users.id_role' , 2)
                ->limit($condition['cantidad'])
                ->groupby('users.name', 'users.email','users.phone')
                ->orderby('gastado', 'DESC')
                ->get();   
                
                break;
            case 1:
                echo "i es igual a 1";
                break;
            case 2:
                echo "i es igual a 2";
                break;
        }
        foreach ($customers as $value){
            $correo = new welcomeMail($value,$condition['foto']);
            $email = $value->email;
            Mail::to($email)->send($correo);
        } 
            
        if(Storage::delete('public/'.$condition['foto'])){
        
                return "mensaje enviado";
            }
            else {return "error";}
    }
}



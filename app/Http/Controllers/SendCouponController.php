<?php

namespace App\Http\Controllers;

use App\Models\sendCoupon;
use Illuminate\Http\Request;
use Illuminate\support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
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

}

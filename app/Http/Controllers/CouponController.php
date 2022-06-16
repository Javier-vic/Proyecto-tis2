<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\coupon;
use Carbon\Carbon;

class CouponController extends Controller
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
                ->table('coupons')
                ->whereNull('coupons.deleted_at')
                ->select(
                    'coupons.id as _id',
                    'coupons.id',
                    'coupons.code',
                    'coupons.percentage',
                    'coupons.caducity',
                    'coupons.emited',
                    'coupons.quantity',

                )
                ->orderBy('coupons.id')
                ->get())
                ->addColumn('action', 'Mantenedores.coupon.datatable.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('Mantenedores.coupon.index');
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


        $validator = Validator::make($request->all(), coupon::$rules, coupon::$messages);

        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $values = request()->except('_token');
                $cupon = new Coupon;
                $cupon->code = $values['code'];
                $cupon->percentage = $values['percentage'];
                $cupon->emited = Carbon::createFromFormat('d-m-Y', $values['emited'], 'America/Santiago')->toDateTimeString();
                $cupon->caducity = Carbon::createFromFormat('d-m-Y', $values['caducity'], 'America/Santiago')->toDateTimeString();
                $cupon->quantity = $values['quantity'];
                $cupon->save();
                DB::connection(session()->get('database'))->commit();
                return response([$values, $cupon->id], 200);
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('No se pudo realizar el ingreso del cupón.', 400);
            }
        } else {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }

        return response('No se pudo realizar el ingreso del cupón.', 400);
    }
    public function refreshCoupons(request $request)
    {
        $coupons = coupon::all();
        return response($coupons, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(coupon $coupon)
    {

        $id = $coupon->id;
        try {
            $coupon = coupon::on(session()->get('database'))->find($id);
            $coupon->delete();

            DB::connection(session()->get('database'))->commit();
        } catch (\Illuminate\Database\QueryException $e) {

            DB::connection(session()->get('database'))->rollBack();

            return response('Ocurrió un error. No se eliminó el cupón', 400);
        }

        return response('Se eliminó el cupón correctamente', 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\asist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class AsistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currentAsist = DB::table('asists')
                            ->where('asists.id_user','=',Request()->user()->id)
                            ->whereDate("asists.created_at",'=',Carbon::today()->toDate())
                            ->whereNull('asists.end')
                            ->get();
        
        return view('Mantenedores.asist.index',['currentAsist'=>$currentAsist]);
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
        //
        Try{
            $asist = new asist(['id_user'=>Request()->user()->id]);
            $asist->save();
            return response(['message'=>'Asistencia registrada','asist'=>$asist],200);
        }catch(\Throwable $th){
            return response('No se pudo realizar el registro del rol',400);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\asist  $asist
     * @return \Illuminate\Http\Response
     */
    public function show(asist $asist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\asist  $asist
     * @return \Illuminate\Http\Response
     */
    public function edit(asist $asist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\asist  $asist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, asist $asist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\asist  $asist
     * @return \Illuminate\Http\Response
     */
    public function destroy(asist $asist)
    {
        //
        //dd(Carbon::today()->toDate());
        dd(Carbon::today()->toDate());
        $asist->end= Carbon::today()->toDate();
        return redirect(route('asist.index'));
    }
    public function dataTable(Request $request){
        if($request->ajax()){
            $data = DB::table('asists')
                    ->where('asists.id_user','=',Request()->user()->id)
                    ->orderByDesc('asists.id')
                    ->get();
            return DataTables::of($data)       
                   ->make(true);
        }else{

        }
    }
    public function finishAsist(asist $asist){
        $asist->end = Carbon::now()->toDate();
        $asist->save();
        return response([$asist->end],200);
    }
}

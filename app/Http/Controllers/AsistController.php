<?php

namespace App\Http\Controllers;

use App\Models\asist;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

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
                            ->where('asists.id_user','=','Date(now())')
                            ->whereNull('asists.end')
                            ->get();
        dd($currentAsist);
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
    }
    public function dataTable(Request $request){
        if($request->ajax()){
            $data = DB::table('asists')
                    ->where('asists.id_user','=',Request()->user()->id)
                    ->whereNull('asists.end')
                    ->get();
            return DataTables::of($data)       
                   ->make(true);
        }else{

        }
    }
}

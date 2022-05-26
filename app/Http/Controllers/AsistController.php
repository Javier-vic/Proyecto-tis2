<?php

namespace App\Http\Controllers;

use App\Models\asist;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

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
        return view('Mantenedores.asist.index');
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
            $data = asist::all();
            return DataTables::of($data)       
                   ->make(true);
        }else{

        }
    }
}

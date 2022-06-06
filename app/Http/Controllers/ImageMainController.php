<?php

namespace App\Http\Controllers;

use App\Models\image_main;
use Illuminate\Http\Request;

class ImageMainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('Mantenedores.image_main.index');
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
     * @param  \App\Models\image_main  $image_main
     * @return \Illuminate\Http\Response
     */
    public function show(image_main $image_main)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\image_main  $image_main
     * @return \Illuminate\Http\Response
     */
    public function edit(image_main $image_main)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\image_main  $image_main
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, image_main $image_main)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\image_main  $image_main
     * @return \Illuminate\Http\Response
     */
    public function destroy(image_main $image_main)
    {
        //
    }
}

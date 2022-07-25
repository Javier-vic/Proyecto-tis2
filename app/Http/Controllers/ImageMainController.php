<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
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
        $images = image_main::orderBy('order')->get();
        return view('Mantenedores.image_main.index',['images'=>$images]);
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
        //image_main::truncate();
        $values = $request->all();
        for($i=1; $i<5; $i++){
                $image_main = image_main::find($values["idImage-{$i}"]);
                $image_main->order = $values["order-{$i}"];
                $image_main->save();
            }
            if(($request->hasFile("image-{$i}")) && (image_main::where('order',$values["order-{$i}"])->first()==null)){
                $imageMain = new image_main();
                $imageMain->order = $values["order-{$i}"];
                $imageMain->route = $request->file("image-{$i}")->store('uploads','public');
                $imageMain->save();
            }else if(($request->hasFile("image-{$i}")) && (image_main::where('order',$values["order-{$i}"])->first()!=null)){
                $oldImage = image_main::where('order',$values["order-{$i}"])->first();
                Storage::delete('public/' . $oldImage->route);
                $oldImage->delete();    
                $imageMain = new image_main();
                $imageMain->order = $values["order-{$i}"];
                $imageMain->route = $request->file("image-{$i}")->store('uploads','public');
                $imageMain->save();
            }
        return;
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
    public function destroy($id)
    {
        //
        $image = image_main::find($id);
        $image->delete();
        Storage::delete('public/' . $image->route);
        return response('',200);
    }
}

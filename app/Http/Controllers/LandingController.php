<?php

namespace App\Http\Controllers;

use App\Models\category_product;
use Illuminate\Support\Facades\DB;
use App\Models\landing;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //OBTIENE TODAS LAS CATEGORÍAS
        $category_products = category_product::all();
        ////////////////////////////////////////////////

        //OBTIENE LOS PRODUCTOS Y ASOCIADOS A SU CATEGORÍA
        $productAvailable = DB::table('products')
            ->whereNull('products.deleted_at')
            ->join('category_products', 'category_products.id', '=', 'products.id_category_product')
            ->select(
                'products.id',
                'products.stock',
                'products.name_product',
                'products.description',
                'products.image_product',
                'category_products.name as category',
                'category_products.id as category_id',
                'products.price'

            )
            ->orderBy('products.id')
            ->get();
        ////////////////////////////////////////////////

        //OBTIENE LAS CATEGORÍAS QUE ESTÁN DISPONIBLES SOLAMENTE ( con productos en stock)
        $categoryAvailable = DB::table('category_products')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('products')
                    ->whereColumn('products.id_category_product', 'category_products.id');
            })
            ->get();
        ////////////////////////////////////////////////

        //OBTIENE LAS CATEGORÍAS QUE ESTÁN DISPONIBLES SOLAMENTE Y PASA SOLO LOS NOMBRES A UN ARRAY( con productos en stock)
        $categoryAvailableNames = $categoryAvailable->pluck('name')->toArray();
        ////////////////////////////////////////////////

        return view('usuario.landing.landing', compact('category_products', 'categoryAvailable', 'productAvailable', 'categoryAvailableNames'));
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

    public function ubicacion()
    {
        return view('Usuario.Landing.Location');
    }
    
    public function getLocation()
    {
        $location = DB::table('maps' )
        ->select('maps.latitud','maps.longitud')
        ->where('maps.id', 1)
        ->get();    

    

        return response($location,200);
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
     * @param  \App\Models\landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function show(landing $landing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function edit(landing $landing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, landing $landing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\landing  $landing
     * @return \Illuminate\Http\Response
     */
    public function destroy(landing $landing)
    {
        //
    }
}

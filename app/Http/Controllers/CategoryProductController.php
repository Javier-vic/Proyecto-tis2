<?php

namespace App\Http\Controllers;

use App\Models\category_product;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }
    public function store_category_product(Request $request)
    {
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category_product  $category_product
     * @return \Illuminate\Http\Response
     */
    public function show(category_product $category_product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category_product  $category_product
     * @return \Illuminate\Http\Response
     */
    public function edit(category_product $category_product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category_product  $category_product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category_product $category_product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category_product  $category_product
     * @return \Illuminate\Http\Response
     */
    public function destroy(category_product $category_product)
    {
        //
    }
}

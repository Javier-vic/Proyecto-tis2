<?php

namespace App\Http\Controllers;

use App\Models\category_supply;
use Illuminate\Http\Request;

class CategorySupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['category_supplies'] = category_supply::paginate(5);
        return view('Mantenedores.category_supply.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Mantenedores.category_supply.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category_supplyData = request()->except('_token');
        $category_supply = new category_supply;
        $category_supply->name_category = $category_supplyData['name_category'];
        $category_supply->save();

        return redirect()->route('category_supply.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category_supply  $category_supply
     * @return \Illuminate\Http\Response
     */
    public function show(category_supply $category_supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category_supply  $category_supply
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_supply = category_supply::findOrFAil($id);
        return view('Mantenedores.category_supply.edit', compact('category_supply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category_supply  $category_supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category_supply = category_supply::findOrFAil($id);
        $category_supply->name_category = $request->input('name_category');
        $category_supply->update();

        return redirect()->route('category_supply.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category_supply  $category_supply
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        category_supply::destroy($id);
        return redirect()->route('category_supply.index');
    }
}

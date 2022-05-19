<?php

namespace App\Http\Controllers;

use App\Models\supply;
use App\Models\category_supply;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['supplies'] = supply::paginate(5);
        return view('Mantenedores.supply.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_supplies = category_supply::all();
        return view('Mantenedores.supply.create', compact('category_supplies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplyData = request()->except('_token');
        $supply = new supply;
        $supply->name_supply = $supplyData['name_supply'];
        $supply->unit_meassurement = $supplyData['unit_meassurement'];
        $supply->quantity = $supplyData['quantity'];
        // $category_supply->supplies()->save($supply);
        $supply->id_category_supplies = $supplyData['id_category_supply'];
        $supply->save();

        return redirect()->route('supply.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function show(supply $supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supply = supply::findOrFAil($id);
        $category_supplies = category_supply::all();
        return view('Mantenedores.supply.edit', compact('supply', 'category_supplies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supply = supply::findOrFAil($id);
        $supply->category_supply()->dissociate();
        $supply->name_supply = $request->input('name_supply');
        $supply->unit_meassurement = $request->input('unit_meassurement');
        $supply->quantity = $request->input('quantity');
        $id_category_supplies = $request->input('id_category_supplies');
        $supply->category_supply()->associate($id_category_supplies);
        $supply->update();

        return redirect()->route('supply.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        supply::destroy($id);
        return redirect()->route('supply.index');
    }
}

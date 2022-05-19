<?php

namespace App\Http\Controllers;

use App\Models\category_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryProductController extends Controller
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
                ->table('category_products')
                ->whereNull('category_products.deleted_at')
                ->select(
                    'category_products.id as _id',
                    'category_products.id as id',
                    'category_products.name',
                )
                ->orderBy('category_products.id')
                ->get())
                ->addColumn('action', 'mantenedores.category.datatable.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('Mantenedores.category.index');
        
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
        $categoryProductData = request()->except('_token');
        $category_product = new category_product;
        $category_product->name = $categoryProductData['name'];
        $category_product->save();

        return redirect()->route('category_product.index');
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
    public function categoryProductModalEdit(request $request)
    {
        $id = request()->id;
        $categoryProductSelected = DB::table('category_products')
            ->whereNull('category_products.deleted_at')
            ->where('category_products.id', '=', 1)
            ->select(
                'category_products.id as id',
                'category_products.name'
            )
            ->orderBy('category_products.id')
            ->get();
        return json_encode([$categoryProductSelected]);

        // return view('mantenedores.product.edit', compact('productSelected'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category_product  $category_product
     * @return \Illuminate\Http\Response
     */
    public function destroy(category_product $category_product)
    {
        dd('DESTRUIR');
        //
    }
}

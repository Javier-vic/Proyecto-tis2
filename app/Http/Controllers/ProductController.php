<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ProductController extends Controller
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
                ->table('products')
                ->whereNull('products.deleted_at')
                ->select(
                    'products.id as _id',
                    'products.id',
                    'products.stock',
                    'products.name_product',
                    'products.description',

                )
                ->orderBy('products.id')
                ->get())
                ->addColumn('action', 'mantenedores.product.datatable.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('mantenedores.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mantenedores.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productData = request()->except('_token');
        $producto = new Product;
        $producto->stock = $productData['stock'];
        $producto->name_product = $productData['name_product'];
        $producto->description = $productData['description'];
        $producto->image_product = $productData['image_product'];
        $producto->id_category_product = $productData['id_category_product'];
        $producto->save();

        if ($request->hasFile('image_product')) {
            $productData['image_product'] = $request->file('image_product')->store('uploads', 'public');
        }

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        $productSelected = product::find($product->id);

        return view('mantenedores.product.edit', $productSelected);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        try {
            $id = $product->id;
        } catch (DecryptException $error) {
            echo '<script>alert("Producto no eliminado")</script>';
            return back();
        }

        $product = product::on(session()->get('database'))->find($id);
        $product->delete();


        return redirect()->route('product.index');
    }
}

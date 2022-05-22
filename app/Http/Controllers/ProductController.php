<?php

namespace App\Http\Controllers;

use App\Models\category_product;
use Illuminate\Support\Facades\DB;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;

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
                    'products.price',
                    'products.image_product'

                )
                ->orderBy('products.id')
                ->get())
                ->addColumn('action', 'mantenedores.product.datatable.action')
                ->addColumn('image', 'mantenedores.product.datatable.image')
                ->rawColumns(['action', 'image'])
                ->addIndexColumn()
                ->make(true);
        }
        $category_products = category_product::all();
        $productSelected = new product();


        return view('mantenedores.product.index', compact('category_products', 'productSelected'));
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
        $values = request()->except('_token');
        $productData = request()->except('_token');
        $producto = new Product;
        $producto->stock = $values['stock'];
        $producto->name_product = $productData['name_product'];
        $producto->description = $productData['description'];
        $producto->price = $productData['price'];
        if ($request->hasFile('image_product')) {
            $producto->image_product = $request->file('image_product')->store('uploads', 'public');
        }
        $producto->id_category_product = $productData['id_category_product'];
        $producto->save();

        if ($request->hasFile('image_product')) {
            $productData['image_product'] = $request->file('image_product')->store('uploads', 'public');
        }

        return response('Se agregó el producto con exito.', 200);
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
    public function productView(request $request)
    {
        $id = request()->id;
        $productSelected = DB::table('products')
            ->whereNull('products.deleted_at')
            ->where('products.id', '=', $id)
            ->join('category_products', 'category_products.id', '=', 'products.id_category_product')
            ->select(
                'products.id as _id',
                'products.id',
                'products.stock',
                'products.name_product',
                'products.description',
                'products.image_product',
                'category_products.name as category',
                'products.price'

            )
            ->orderBy('products.id')
            ->get();
        return json_encode([$productSelected]);
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
        $category_products = category_product::all();

        // dd($productSelected->id_category_product);
        return view('mantenedores.product.edit', compact('productSelected', 'category_products'));
    }
    public function productModalEdit(request $request)
    {
        $id = request()->id;
        $productSelected = DB::table('products')
            ->whereNull('products.deleted_at')
            ->where('products.id', '=', $id)
            ->join('category_products', 'category_products.id', '=', 'products.id_category_product')
            ->select(
                'products.id as _id',
                'products.id',
                'products.stock',
                'products.name_product',
                'products.description',
                'products.image_product',
                'products.price',
                'category_products.name as category'

            )
            ->orderBy('products.id')
            ->get();
        return json_encode([$productSelected]);

        // return view('mantenedores.product.edit', compact('productSelected'));
    }
    public function productModalEditStore(request $request, product $product)
    {
        // $datosProducto = request()->except(['_token', '_method']);
        // $producto = product::find($request->id);
        // $producto->stock         = $request->stock;
        // $producto->name_product   = $request->name_product;
        // $producto->description    = $request->description;
        // if ($request->image_product != null) {
        //     Storage::delete('public/' . $request->urlImagen);
        //     $producto->image_product = $request->file('image_product')->store('uploads', 'public');
        // }
        // $producto->save();
        // return redirect()->route('product.index');
        return json_encode(['HOL']);


        // return view('mantenedores.product.edit', compact('productSelected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(request $request, product $product)
    {
        $values = request()->except('_token');
        dd($values);
        $datosProducto = request()->except(['_token', '_method']);
        $producto = product::find($product->id);
        $producto->stock         = $request->stock;
        $producto->name_product   = $request->name_product;
        $producto->description    = $request->description;
        $producto->id_category_product = $request->id_category_product;
        $producto->price = $request->price;
        if ($request->hasFile('image_product')) {
            Storage::delete('public/' . $product->image_product);
            $producto->image_product = $request->file('image_product')->store('uploads', 'public');
        }
        $producto->save();
        return redirect()->route('product.index');
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

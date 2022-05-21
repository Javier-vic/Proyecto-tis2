<?php

namespace App\Http\Controllers;

use App\Models\category_product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use RealRashid\SweetAlert\Facades\Alert;




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


        $rules = [
            'name'          => 'required|string',
        ];

        $messages = [
            'required'      => 'Este campo es obligatorio',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $values = request()->except('_token');

                $category_product = new category_product;
                $category_product->name = $values['name'];
                $category_product->save();
                DB::connection(session()->get('database'))->commit();
                return response('Se ingresó la categoría con exito.', 200);
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('No se pudo realizar el ingreso de la categoría.', 400);
            }
            return response('No se pudo realizar el ingreso de la categoría.', 400);
            // alert()->success('Categoría creada correctamente!');
        }

        return response('No se pudo realizar el ingreso de la categoría.', 400);
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
        $rules = [
            'name'          => 'required|string',
            'lastname'          => 'required|string',
            'age'          => 'required|string',

        ];

        $messages = [
            'required'      => 'Este campo es obligatorio',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            DB::beginTransaction();
            try {

                $datosProducto = request()->except(['_token', '_method']);
                $category_product = category_product::find($category_product->id);
                $category_product->name         = $request->name;
                $category_product->save();
                DB::connection(session()->get('database'))->commit();
                return response('Se editó la categoría con exito.', 200);
            } catch (\Throwable $th) {
                DB::connection(session()->get('database'))->rollBack();
                return response('No se pudo editar la categoría.', 400);
            }
            return response('No se pudo editar la categoría.', 400);
            // alert()->success('Categoría creada correctamente!');
        }
        return response('No se pudo editar la categoría.', 400);
    }
    public function categoryProductModalEdit(request $request)
    {
        $id = request()->id;
        $categoryProductSelected = DB::table('category_products')
            ->whereNull('category_products.deleted_at')
            ->where('category_products.id', '=', $id)
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

        // try {
        //     $equipment = Equipment::on(session()->get('database'))->find($id);
        //     $equipment->delete();

        //     DB::connection(session()->get('database'))->commit();
        // } catch (\Illuminate\Database\QueryException $e) {

        //     DB::connection(session()->get('database'))->rollBack();

        //     return  response()->json(['success' => false, 'error' => $e]);
        // }


        $categoryProduct = category_product::on(session()->get('database'))->find($category_product->id);
        $categoryProduct->delete();


        return response('success', 200);
    }
}

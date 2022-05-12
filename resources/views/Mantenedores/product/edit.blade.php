@extends('layouts.navbar')
@section('content')
    <a role="button" class="btn btn-dark mr-2" href="{{ route('product.index') }}">
        <i class="fa fa-fw fa-arrow-left mr-2"></i> Volver
    </a>
    <form action="{{ route('product.update', $productSelected->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        <div class="mb-3">
            <label for="" class="form-label">Nombre :</label>
            <input type="text" class="form-control" id="name_product" name="name_product"
                value="{{ $productSelected->name_product }}" aria-describedby="name_product_help">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Ingrese la cantidad del producto</label>
            <input type="number" class="form-control" id="stock" name="stock" aria-describedby="stock_help"
                value={{ $productSelected->stock }}>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Descripción : </label>
            <input type="text" class="form-control" id="description" name="description"
                aria-describedby="description_help" value={{ $productSelected->description }}>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Imagen : </label>
            <input type="file" class="form-control" id="image_product" name="image_product"
                aria-describedby="name_product_help">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Categoria del producto (Acá se debe desplegar una lista con los nombres de
                la tabla de la q vienen) : </label>
            <input type="text" class="form-control" id="id_category_product" name="id_category_product"
                value={{ $productSelected->id_category_product }} aria-describedby="name_product_help">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

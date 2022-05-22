@extends('layouts.navbar')
@section('content')
    <div class="d-flex justify-content-end">
        <a role="button" class="btn btn-dark mr-2 " href="{{ route('product.index') }}">
            <i class="fa fa-fw fa-arrow-left mr-2 "></i> Volver
        </a>
    </div>
    <form action="{{ route('product.update', $productSelected->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        <div class="mb-3">
            <label for="" class="form-label">Nombre </label>
            <input type="text" class="form-control" id="name_product" name="name_product"
                value="{{ $productSelected->name_product }}" aria-describedby="name_product_help">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Ingrese la cantidad del producto</label>
            <input type="number" class="form-control" id="stock" name="stock" aria-describedby="stock_help"
                value={{ $productSelected->stock }}>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Descripción  </label>
            <input type="text" class="form-control" id="description" name="description"
                aria-describedby="description_help" value={{ $productSelected->description }}>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Precio  </label>
            <input type="text" class="form-control" id="price" name="price"
                aria-describedby="description_help" value={{ $productSelected->price }}>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Categoria </label><br>

            <select name="id_category_product" id="" name="id_category_product">
                @foreach ($category_products as $category_product)
                @if($category_product->id == $productSelected->id_category_product){
                    <option value={{ $category_product->id }} selected id="">{{ $category_product->name }}</option>
                }
                @else{
                    <option value={{ $category_product->id }} id="">{{ $category_product->name }}</option>
                }
                @endif

                @endforeach
            </select>
        </div>
        <div class="mb-3 ">
            <label for="" class="form-label">Imagen  </label>
            <input type="file" class="form-control" id="image_product" name="image_product"
                aria-describedby="name_product_help" >
            <img src="{{ asset('storage') . '/' . $productSelected->image_product }}" class="img-fluid " alt="">

        </div>
    

        <div class="d-flex justify-content-center"><button type="submit" class="btn btn-primary p-3">Editar</button></div>
    </form>
@endsection

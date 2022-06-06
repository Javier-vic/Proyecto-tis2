@extends('layouts.navbar')

@section('titlePage')
    <h2 class="">Imagenes publicitarias</h2>
@endsection

@section('content')
    <div class="row">

    </div>
    <div class="row">
        <div class="col-12 col-md-3 my-2">
            <input type="file" class="form-control" name="image-1">
        </div>
        <div class="col-12 col-md-3 my-2">
            <input type="file" class="form-control" name="image-2">
        </div>
        <div class="col-12 col-md-3 my-2">
            <input type="file" class="form-control" name="image-3">
        </div>
        <div class="col-12 col-md-3 my-2">
            <input type="file" class="form-control" name="image-4">
        </div>
    </div>
    <div class="row">
        <div class="col d-flex justify-content-center">
            <button class="btn btn-success">Guardar cambios</button>
        </div>
    </div>
@endsection


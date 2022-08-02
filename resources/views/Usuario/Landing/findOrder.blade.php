@extends('layouts.userNavbar')

<style>
    input,button:focus{
        outline: none !important;
        box-shadow: none !important;
    }
</style>

@section('content')
<div>@include('Usuario.Landing.modal.view')</div>
<div class="container">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 border border-danger shadow-lg p-3">
            <div>
                <h2 class="fw-bold text-danger m-1 my-4 text-center">Ver el estado de mi pedido</h2>
            </div>
            <div class="text-center my-4">
                <form action="{{route('show.order')}}" method="get">
                    @csrf

                    <div class="input-group mb-3">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon1">
                            <i class="fa-solid fa-magnifying-glass text-danger btn-find-order"></i>
                        </button>
                        <input type="text" class="form-control" id="id" name="id" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                    </div>

                </form>
            </div>
            <div id="content-order">               
                @foreach($order as $data)
                <h5 class="m-2 my-3 fw-bold">Nombre de la orden: <span class="fw-normal">{{$data->name_order}}</span></h5>
                <h5 class="m-2 my-3 fw-bold">Total del pedido: <span class="fw-normal">{{$data->total}}</span></h5>
                <h5 class="m-2 my-3 fw-bold">Estado del pedido: <span class="fw-normal">{{$data->order_status}}</span></h5>
                <h5 class="m-2 my-3 fw-bold">Metodo de pago: <span class="fw-normal">{{$data->payment_method}}</span></h5>
                <h5 class="m-2 my-3 fw-bold">Retiro: <span class="fw-normal">{{$data->pick_up}}</span></h5>
                @endforeach               
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
    
</div>
@endsection
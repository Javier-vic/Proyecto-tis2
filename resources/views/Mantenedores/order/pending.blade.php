@extends('layouts.navbar')
@section('content')
    <div class="row">
        @foreach ($pendingOrders as $item)
            <div class="col-lg-3">
                <div class="card {{($item->order_status == "Espera")? 'border-danger border-2': null;}}">
                    <div class="card-body">
                        <span class="card-title fs-5 text-center d-block">Nombre cliente: <span class="fw-bold"> {{$item->name_order}} </span></span>
                        <div class="card-subtitle text-muted text-center">Número: {{$item->number}} - Despacho: {{$item->address}}</div>
                        <div class="card-text mt-3">
                            <span class="fw-bold fs-5">Orden:</span>
                            <ul class="list-group fs-5">
                                @foreach ($item->listProducts as $product)
                                    <li class="list-group-item">{{$product->name_product}} - cantidad : {{$product->cantidad}}</li>
                                @endforeach
                            </ul>
                            @if($item->order_status == "Espera")
                                <div class="text-center text-white rounded bg-danger p-2 w-50 mx-auto fs-5 mt-4 mb-2">
                                    {{$item->order_status}} 
                                </div>
                                <div class="row my-2">
                                    <button class="btn btn-success w-auto mx-auto">Tomar orden</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('js_after')
    <script>
        $(document).ready(function(){
            console.log(@json($pendingOrders));
        });
        function tomarOrden(){ 
            
        }
        function terminarOrder(){

        }
        function ordenEntregada(){

        }
    </script>
@endsection

@extends('layouts.userNavbar')

<style>
    .order-box{
            border-width: 3px !important;
    }
</style>

@section('content')

    <div class="bg-white order-box border border-danger rounded">
        <div>
            <h2 class="p-3 text-danger pedidos-titulo">Mis pedidos</h2>
        </div>
        <div>
            @foreach ($orders as $order)
                @foreach ($productOrders as $productorder)
                    <div>
                        @if ($order->pick_up = 'si')
                            <h2>{{$order->address}}</h2>
                        @else
                            <h2>Retiro</h2>
                        @endif
                    </div>
                    <div>
                        <h6>{{$order->created_at}}</h6>
                    </div>
                @endforeach
            @endforeach

        </div>
    </div>

@endsection
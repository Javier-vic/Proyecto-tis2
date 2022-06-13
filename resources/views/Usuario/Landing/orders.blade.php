@extends('layouts.userNavbar')

<style>
    .order-box{
            border-width: 3px !important;
    }
</style>

@section('content')

    <div class="bg-white order-box border border-danger rounded">
        <div>
            <h2 class="p-3 text-danger fw-bold">Mis pedidos</h2>
        </div>
        <div>
            @foreach ($orders as $order)
                

                <div>                  
                    <div class="d-inline-block">
                        foto
                        <img src="{{ asset('storage') . '/' . $product->image_product }}" class="img-fluid rounded object-fit-cover " style="height: 239px;object-fit: cover;" />
                    </div>
                    <div class="d-inline-block">
                        <div>
                            @if ($order->pick_up == 'si')
                                <h2 class="fw-bold">{{$order->address}}</h2>
                            @else
                                <h2 class="fw-bold">Retiro</h2>
                            @endif
                        </div>
                        <div >
                            <h6 class="d-inline-block px-1 text-muted">cantidad de productos</h6>
                            <h6 class="d-inline-block px-1 text-muted">${{$order->total}}</h6>
                            <h6 class="d-inline-block px-1 text-muted">{{$order->created_at}}</h6>
                        </div>
                        @foreach ($productOrders as $productorder)
                            @if ($productorder->order_id == $order->id )
                            <div>
                                <h6 class="d-inline-block px-1 text-danger fw-bold">{{$productorder->cantidad}}</h6>
                                <h6 class="d-inline-block px-1">{{$productorder->name_product}}</h6>
                            </div>
                            @endif
                        @endforeach
                        
                    </div>
                    <div>
                        <hr style="width:95%" class="mx-auto">
                    </div>
                </div>               
            @endforeach

        </div>
    </div>

@endsection
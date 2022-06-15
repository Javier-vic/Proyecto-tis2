@extends('layouts.userNavbar')

@section('content')

    <div>@include('Usuario.Landing.modal.view')</div>
    <div class="bg-white shadow-lg border border-dark rounded">
        <div>
            <h2 class="p-3 text-danger fw-bold">Mis pedidos</h2>
        </div>
        <div class="container">
            @foreach ($orders as $order)
                
                <div class="row p-2"> 
                    <!-- IMAGEN DE LA ORDER                  -->
                    <div class="col-lg-4 d-inline-block ">
                        @foreach ($productOrders as $productorder)
                            @if ($productorder->order_id == $order->id )
                                <img src="{{ asset('storage') . '/' . $productorder->image_product }}" class="img-fluid rounded object-fit-cover " style="height: 239px;object-fit: cover;" />
                                @break    
                            @endif
                        @endforeach
                    </div>
                    
                    <div class="col-lg-6 d-inline-block">
                        <!-- DIRECCION O RETIRO -->
                        <div>
                            @if ($order->pick_up == 'si')
                                <h2 class="fw-bold">{{$order->address}}</h2>
                            @else
                                <h2 class="fw-bold">Retiro</h2>
                            @endif
                        </div>   
                        
                        <!-- INFORMACION EXTRA -->
                        <div >
                            <h6 class="d-inline-block px-1 text-muted">cantidad de productos</h6>
                            <h6 class="d-inline-block px-1 text-muted">${{$order->total}}</h6>
                            <h6 class="d-inline-block px-1 text-muted">Pedido realizado el {{$order->created_at}}</h6>
                        </div>

                        <!-- LISTADO DE PRODUCTOS -->
                        @foreach ($productOrders as $productorder)
                            @if ($productorder->order_id == $order->id )
                            <div>
                                <h6 class="d-inline-block px-1 text-danger fw-bold">{{$productorder->cantidad}}</h6>
                                <h6 class="d-inline-block px-1">{{$productorder->name_product}}</h6>
                            </div>
                            @endif
                        @endforeach
                        
                    </div>

                    <!-- BOTON MODAL DE DETALLES DE LA ORDEN -->
                    <div class="col-lg-2 d-inline-block">
                        <button type="button" onclick="showOrderDetails({{$order->id}})" class=" btn btn-danger mb-5" data-bs-toggle="modal" data-bs-target="#viewOrder">
                            Ver detalle
                        </button>
                    </div>
                </div>               
                
                <div>
                    <hr style="width:95%" class="mx-auto">
                </div>
            @endforeach

        </div>
    </div>

@endsection

@section ('js_after')
    <script>
        const showOrderDetails = (id) =>{
            $.ajax({
                type: "GET",
                url: "{{ route('order.details') }}",
                data: {
                    'id': id,
                },
                dataType: "json",
                success: function(response) {
                    resultado = response;
                    $('#nameOrderVIEWMODAL').val(resultado[1]);
                    $('#name_order').val(resultado[1][0].name_order);
                    $('#payment').val(resultado[1][0].payment_method);
                    $('#total').val(resultado[1][0].total);
                    $('#dely').val(resultado[1][0].pick_up);
                    $('#date').val(resultado[1][0].created_at);

                    // $('#addorderLabel').html(${resultado.product_id})
                    console.log(resultado)
                    $('#pruebaProductos').empty();
                    resultado[0].map(product => {
                        $('#pruebaProductos').append(
                            `
                            <tr>
                                <td>${product.name_product}</td>
                                <td>${product.cantidad}</td>
                                <td>${product.cantidad*product.price}</td>
                            </tr> 
                            `
                        )
                    })
                }
            });
        }
    </script>
@endsection
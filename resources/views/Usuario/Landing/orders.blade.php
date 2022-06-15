@extends('layouts.userNavbar')

@section('content')

    <div>@include('Usuario.Landing.modal.view')</div>
    <div class="bg-white shadow-lg border border-dark rounded">
        <div>
            <h2 class="p-3 text-danger fw-bold">Mis pedidos</h2>
        </div>
        <div>
            @foreach ($orders as $order)
                
                <div class="d-inline-block">                  
                    <div class="d-inline-block">
                        foto
                        
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
                    <div class="justify-content-end  d-inline-block">
                        <button type="button" onclick="showOrderDetails({{$order->id}})" class="btn btn-danger mb-5" data-bs-toggle="modal" data-bs-target="#viewOrder">
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
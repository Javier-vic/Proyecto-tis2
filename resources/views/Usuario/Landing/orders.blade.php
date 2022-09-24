<style>
    .fondo.modalBlur>*:not(.modal){
        -webkit-filter: blur(4px);
    }

    .aa{
       background-color: #f3f3f3;
    }

    .view-input{
        background-color: #f3f3f3;
        border: none;
    }

</style>
<script type = "text/JavaScript" src = "https://MomentJS.com/downloads/moment.js"></script>

<div>@include('Usuario.Landing.modal.view')</div>


@section('content')
<div class="fondo">
    
    @extends('layouts.userNavbar')
        
        <div class="bg-white shadow-lg border rounded">
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
                                    <img src="{{ asset('storage') . '/' . $productorder->image_product }}" class="shadow-lg img-fluid rounded object-fit-cover " style="height: 239px;object-fit: cover;" />
                                    @break    
                                @endif
                            @endforeach
                        </div>
                        
                        <div class="col-lg-6 d-inline-block">
                            <!-- DIRECCION O RETIRO -->
                            <div class="my-2 mx-1">
                                @if ($order->pick_up == 'si')
                                    <h2 class="fw-bold">{{$order->address}}</h2>
                                @else
                                    <h2 class="fw-bold">Retiro</h2>
                                @endif
                                <h2 class="text-muted">{{$order->id}}</h2>
                            </div>   
                            
                            <!-- INFORMACION EXTRA -->
                            <div >
                                @foreach ($orderItems as $orderitem)
                                    @if ($orderitem->order_id == $order->id)
                                        <h6 class="d-inline-block px-1 text-muted">{{$orderitem->articulos}} articulos</h6>
                                    @endif
                                @endforeach
                                <h6 class="d-inline-block px-1 text-muted">${{$order->total}}</h6>
                                <h6 class="d-inline-block px-1 text-muted aaa">Pedido realizado el {{$order->created_at}}</h6>                               
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
                    $('#date').val(resultado[1][0].created_at);
                    $('#dely').val(resultado[1][0].pick_up);
                    $('#dely_address').val(resultado[1][0].address);

                    console.log(resultado)
                    $('#pruebaProductos').empty();
                    resultado[0].map(product => {
                        $('#pruebaProductos').append(
                            `
                            <tr>
                                <td>${product.name_product}</td>
                                <td class="text-danger fw-bold">${product.cantidad}</td>
                                <td>${product.cantidad*product.price}</td>
                            </tr> 
                            `
                        )
                    })
                }
            });
        }
    </script>

    <script>
        (function(){
            //Show Modal
            $('#viewOrder').on('show.bs.modal', function (e) {
                console.log('show');
                $('.fondo').addClass('modalBlur');
            })
            
            //Remove modal
            $('#viewOrder').on('hide.bs.modal', function (e) {
                console.log('hide');
                $('.fondo').removeClass('modalBlur');
            })
        })();
    </script>
@endsection
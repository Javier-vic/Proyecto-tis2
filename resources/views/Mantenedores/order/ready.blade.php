@extends('layouts.navbar')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <div class="row">
        @foreach ($readyOrders as $item)
        <div class="col-xl-4 col-md-6 col-12 mt-2">
            <div class="card border-success border-2">
                <div class="card-body">
                    <div class="card-title fs-5 text-center d-block">
                        <div class="">
                            Nombre cliente: <span class="fw-bold"> {{$item->name_order}}</span>
                            
                        </div>
                        <div class="">
                            Fecha: <span class="fw-bold">{{$item->created_at}}</span>
                        </div>
                    </div>
                    <div class="card-text mt-3">
                        <span class="fw-bold fs-5">Orden:</span>
                        <ul class="list-group fs-5">
                            @foreach ($item->listProducts as $product)
                                <li class="list-group-item">{{$product->name_product}} - cantidad : {{$product->cantidad}} 
                                </li>
                            @endforeach
                        </ul>
                        <span class="fw-bold fs-5">Comentarios: </span>
                        <div class="fs-5 border px-3 py-2 rounded">
                            {{($item->comment != null) ? $item->comment: "Sin comentarios";}}
                        </div>
                        <div class="text-center text-white rounded bg-success p-2 w-50 mx-auto fs-5 mt-4 mb-2">
                            {{$item->order_status}} 
                        </div>
                        <div class="row my-2">
                            <button class="btn btn-primary w-auto mx-auto" onclick="updateOrden({{$item->id}},'Entregado')">Orden entregada</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
@section('js_after')
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        </script>
    <script>
        var audio = new Audio('{{asset('audio/campana.mp3')}}')
        var countOrders = 0;
        $(document).ready(function(){
            countOrders = @json($readyOrders).length;
            const loop = setInterval(()=>queryOrders(), 3000);
        });
        function queryOrders(flag=false){
            $.ajax({
                type: "GET",
                url: "{{route('readyOrdersView')}}",
                success: function (response) {
                    if(response.length > countOrders || flag){
                        (flag) ? renderOrders(response,true):renderOrders(response);
                        countOrders = response.length;
                    }
                }
            });
        }
        function renderOrders(data,flag){
            $("#containerOrders").empty();
            data.map((order)=>{
                var products="";
                var style = "";
                var updOrder= "";
                order.listProducts.map((product)=>{
                    products += `<li class="list-group-item">${product.name_product} - cantidad : ${product.cantidad}</li>`
                })
                if(order.order_status=='Espera'){
                    style = 'border-danger border-2';
                    updOrder = `<div class="text-center text-white rounded bg-danger p-2 w-50 mx-auto fs-5 mt-4 mb-2">
                                    ${order.order_status} 
                                </div>
                                <div class="row my-2">
                                    <button class="btn btn-success w-auto mx-auto" onclick="updateOrden(${order.id},'Cocinando')">Tomar orden</button>
                                </div>`
                }
                if(order.order_status=='Cocinando'){
                    style = 'border-warning border-2';
                    updOrder = `<div class="text-center text-white rounded bg-warning p-2 w-50 mx-auto fs-5 mt-4 mb-2">
                                    ${order.order_status} 
                                </div>
                                <div class="row my-2">
                                    <button class="btn btn-success w-auto mx-auto" onclick="updateOrden(${order.id},'Listo')">Actualizar a listo</button>
                                </div>`
                }
                $("#containerOrders").append(
                    `<div class="col-xl-4 col-md-6 col-12 mt-2">
                        <div class="card ${style}">
                            <div class="card-body">
                                <div class="card-title fs-5 text-center d-block">
                                    <div>Nombre cliente: <span class="fw-bold">${order.name_order}</span></div>
                                    <div>Fecha: <span class="fw-bold">${moment(order.created_at).format('YYYY-MM-DD HH:mm:ss')}</span></div>
                                </div>
                                <div class="card-text mt-3">
                                    <span class="fw-bold fs-5">Orden:</span>
                                    <ul class="list-group fs-5">${products}</ul>
                                    <span class="fw-bold fs-5">Comentarios:</span>
                                    <div class="fs-5 border px-3 py-2 rounded">${(order.comment!=null)? order.comment: 'Sin comentarios'}</div>
                                    ${updOrder}
                                </div>
                            </div>
                        </div>
                    </div>`)                
            })
            if(!flag){
                audio.play();
            }
        }
        function updateOrden(id,status){ 
            Swal.fire({
                title:'¿Estás seguro de actualizar esta orden?',
                text:'No se puede revertir',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, actualizar!',
                cancelButtonText: 'Cancelar',
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        type: "post",
                        url: "{{route('updateOrderStatus')}}",
                        data: {id: id, status:status},
                        success: function (response) {
                            queryOrders(true);
                        }
                    });
                }
            })
        }
    </script>
@endsection
@extends('layouts.navbar')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="row" id="containerOrders">
        @foreach ($pendingOrders as $item)
            <div class="col-xl-4 col-md-6 col-12 mt-2">
                <div class="card {{($item->order_status == "Espera")? 'border-danger border-2': null;}}  {{($item->order_status == "Cocinando")? 'border-warning border-2': null;}}">
                    <div class="card-body">
                        <div class="card-title fs-5 d-block">
                            <div class="d-flex">
                                Nombre cliente:<span class="ms-1 fw-bold">{{$item->name_order}}</span>
                                <div class="ms-auto px-2 rounded-pill {{($item->order_status == "Espera")? 'bg-danger text-white': null;}}  {{($item->order_status == "Cocinando")? 'bg-warning text-dark ': null;}}">
                                    {{$item->order_status}}
                                </div>
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
                            @if($item->order_status == "Espera")
                                <div class="row my-2">
                                    <button class="btn btn-success w-auto mx-auto" onclick="updateOrden({{$item->id}},'Cocinando')">Tomar orden</button>
                                </div>
                            @endif
                            @if($item->order_status == "Cocinando")
                                <div class="row my-2">
                                    <button class="btn btn-success w-auto mx-auto" onclick="updateOrden({{$item->id}},'Listo')">Actualizar a listo</button>
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
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">

        function sendStatus(id,status){
            console.log('gola')
            $.ajax({
                type: "post",
                url: "{{route('send.orderReady')}}",
                data: {id: id,status:status},
                success: function (response) {
                    
                
                }
            });


        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        </script>
    <script>
        var countOrders = 0;
        var audio;
        $(document).ready(function(){
            audio = new Audio('{{asset('audio/campana.mp3')}}')
            countOrders = @json($pendingOrders).length;
            const loop = setInterval(()=>queryOrders(), 3000);
        });


        function queryOrders(flag=false){
            $.ajax({
                type: "GET",
                url: "{{route('pendingOrdersView')}}",
                success: function (response) {
                    //renderOrders(response);
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
                    styleStatus = "ms-auto px-2 rounded-pill bg-danger text-white"
                    updOrder = `<div class="row my-2">
                                    <button class="btn btn-success w-auto mx-auto" onclick="updateOrden(${order.id},'Cocinando')">Tomar orden</button>
                                </div>`
                }
                if(order.order_status=='Cocinando'){
                    style = 'border-warning border-2';
                    styleStatus = "ms-auto px-2 rounded-pill bg-warning text-dark"
                    updOrder = `<div class="row my-2">
                                    <button class="btn btn-success w-auto mx-auto" onclick="updateOrden(${order.id},'Listo')">Actualizar a listo</button>
                                </div>`
                
                 
                }
                $("#containerOrders").append(
                    `<div class="col-xl-4 col-md-6 col-12 mt-2">
                        <div class="card ${style}">
                            <div class="card-body">
                                <div class="card-title fs-5 d-block">
                                    <div class="d-flex">
                                        <div>Nombre cliente: <span class="ms-1 fw-bold">${order.name_order}</span></div>
                                        <div class="${styleStatus}">${order.order_status}</div>
                                    </div>
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
                            sendStatus(id,status)
                        }
                    });
                }
            })
        }
    </script>
@endsection

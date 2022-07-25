@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
@endsection
@section('content')
    
    <form onsubmit="updateOrder(event,{{ $orderData->id }})" method="POST">

        @csrf
        {{ method_field('PATCH') }}

        {{ $orderData->id }}

         <!-- First / Last Name -->
        <div class="row">

            <div class="col-md-8">

                <fieldset  class="form-group border p-3 categoryName mb-4 anyClass"  style="overflow-x: hidden; overflow-y: scroll;">
                  
                    <legend class="h1 text-center ">Productos disponibles</legend>

                    <nav id="navbar-example2" class="navbar navbar-light bg-light px-3">
                        <ul class="nav nav-pills">
        
                            @foreach ($category as $item)
                            <li class="nav-item">
                                <a class="nav-link" href="#listaProductos{{$item->id}}">{{$item->name}}</a>
                            </li>
                            @endforeach
        
                        </ul>
                    </nav>
                
                    <div class="mt-5"  >
        
                        <div id="listarSeleccionados" class="row list mt-5" height="100px"> 
                            <h2 class="row list mt-5 mb-3" >Productos seleccionados</h2>
                        </div>
        
                        @foreach ($category as $item)
                        <div id="listaProductos{{$item->id}}" class="row list mt-3" height="100px"> 
                            <h2>{{$item->name}}</h2>
                        </div>
                        @endforeach
                       
                    </div>
        
             
        
                </fieldset>
        
                <fieldset class="form-group border p-3 mt-3">
                    <legend class="w-auto px-2">Datos cliente</legend>
                    <div class="mb-4">
                        <label for="name_order" class="form-label">Nombre cliente :</label>
                        <input type="text" class="form-control input-modal" value="{{ isset($order->name_order) ? $order->name_order : '' }}"
                            id="name_order" name="name_order" aria-describedby="name_product_help" >
                        <span class="createmodal_error" id="name_order_errorCREATEMODAL"></span>
                    </div>
    
            
                    <div class="mb-4">
                        <label for="name_order" class="form-label">fecha :</label>
                        <input type="text" class="form-control" id="date" name="date" aria-describedby="name_product_help">
                    </div>
            
            
                    <div class="mb-4">
                        <label class="form-label">Estado pedido :</label>
                        <select id="order_status" class="form-control" name="order_status">
                            <option value="Espera">Espera</option>
                            <option value="Cocinando">Cocinando</option>
                            <option value="Listo">Listo</option>
                            <option value="Entregado">Entregado</option>
            
                        </select>
                    </div>
            
            
            
                    <div class="mb-4">
                        <label for="pick_up" class="form-label">Despacho pedido </label>
                        <select id="mi-select" class="form-control" name="pick_up"
                            value="{{ isset($order->pick_up) ? $order->pick_up : '' }}">
            
                            <option value="si" {{ $orderData->pick_up == 'si' ? 'selected' : '' }}>SI</option>
                            <option value="no" {{ $orderData->pick_up == 'no' ? 'selected' : '' }}>NO</option>
            
                        </select>
                    </div>
            
                    <div class="mb-4 entradas">
                        <label for="" class="form-label">Número de celular </label>
                        <input type="text" class="form-control input-modal" class="form-control" id="number" name="number">
                        <span class="createmodal_error" id="number_errorCREATEMODAL"></span>
                    </div>
            
                    <div class="mb-4 entradas">
                        <label for="" class="form-label">Email </label>
                        <input type="text" class="form-control input-modal" class="form-control" id="mail" name="mail">
                        <span class="createmodal_error" id="mail_errorCREATEMODAL"></span>
                    </div>
            
                    <div class="mb-4 entradas">
                        <label for="" class="form-label">Direccion </label>
                        <input type="text" class="form-control input-modal" class="form-control" id="address" name="address">
                        <span class="createmodal_error" id="address_errorCREATEMODAL"></span>
                    </div>
            
                    <div class="mb-4">
                        <label class="form-label">Metodo de pago </label>
                        <select id="payment_method" class="form-control" name="payment_method" aria-describedby="name_product_help"
                            value="{{ isset($orderData->payment_method) ? $orderData->payment_method : '' }}">
                            <option value="Efectivo">Efectivo</option>
                            <option value="Credito">Credito</option>
                            <option value="Debito">Debito</option>
                        </select>
                    </div>
            
                    <div class="mb-4">
                        <label for="comment" class="form-label">Comentarios :</label>
                        <input type="text" class="form-control" value="{{ isset($orderData->comment) ? $orderData->comment : '' }}"
                            class="form-control" id="comment" name="comment">
                    </div>
            
        
                </fieldset>
    
    
            </div>



            <div class="col-4 anyClass py-3 px-1 align-self-start sticky-top d-none d-md-block rounded sticky-margin-top shadow" style="widht=100%" >
                   
                <div class="bg-black text-end rounded-pill pe-4">  <p id ="total" class="h1 text-white">$ 0</p> </div>
                
                <div id = "listSelect" >



                </div>

                <div id ="buttom-order" class="col-12 mt-3 d-flex justify-content-center ">

                    <button type="button" class="btn btn-danger btn-sm">Borrar todo <i class="fa-solid fa-trash"></i> </button>


                </div>
            </div>
        </div>
        

        <button type="submit" class="btn btn-primary">Realizar pedido</button>





    </form>
@endsection

@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        var total = 0; 
        var productsMap = new Map()
        $(document).ready(function() {
            if ($('#mi-select').val() == 'no') $('.entradas').addClass('d-none')
            else $('.entradas').removeClass('d-none')
        });
        $("#mi-select").change(function() {
            if ($(this).val() == 'si') {
                $('.entradas').removeClass('d-none');
                $('#address').removeClass('is-valid');
                $('#address').val('');


            } else {

                $('.entradas').addClass('d-none');
                $('#address').val('Sin direccion');
            }

        });

        // mostrar productos y orden
        const selectproduct = @json($orderData); //datos orden
        const products = @json($product); // todo los productos
        const productsSelected = @json($productsSelected); // id y cantidad productos seleccionados
        const size = products.length;

        // datos orden orden 
        $('#name_order').val(selectproduct.name_order);
        $('#date').val(selectproduct.created_at);
        $('#payment_method').val(selectproduct.payment_method);
        $('#order_status').val(selectproduct.order_status);
        $('#address').val(selectproduct.address);
        $('#total').val(selectproduct.total);
        $('#mail').val(selectproduct.mail);
        $('#number').val(selectproduct.number);

        // ****************************************************************************************************************
        //MODAL DE CREAR
        // ****************************************************************************************************************
        const updateOrder = (e, id) => {
            e.preventDefault();
            const productSelected = @json($productsSelected);
            console.log(productSelected);
            var formData = new FormData(e.currentTarget);
            var url = '{{ route('order.update', ':order') }}';
            url = url.replace(':order', id)
            formData.append('_method', 'put');
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response, jqXHR) {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Se editó la orden correctamente.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,
                        heightAuto: false,
                    })
                    //QUITA LAS CLASES Y ELEMENTOS DE INVALID
                    // $("input-modal").removeClass('is-invalid');
                    // $("input-modal").removeClass('is-valid');
                    // $(".createmodal_error").empty()
                    //////////////////////////////////////
                    $('#agregarProducto').modal('hide');

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseJSON.errors) {
                        var text = jqXHR.responseJSON.errors;

                    }
                    if (jqXHR.responseJSON.errors2) {
                        var text2 = jqXHR.responseJSON.errors2;
                    }

                    //LIMPIA LAS CLASES Y ELEMENTOS DE INVALID
                    $(".createmodal_error").empty()
                    $(".input-modal").addClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    //////////////////////////////////////////
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: "Ocurrió un error. Verifica los campos.",
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                    //AGREGA LAS CLASES Y ELEMENTOS DE INVALID
                    if (text) {
                        $.each(text, function(key, item) {
                            const index = key.lastIndexOf('.');
                            const after = key.slice(index + 1);

                            $("#" + key + "_errorCREATEMODAL").append("<span class='text-danger'>" +
                                item + "</span>")
                            $("#" + after + "errorCREATEMODAL").append(
                                "<span class='text-danger'>" +
                                item + "</span>")

                            $(`#${key}`).addClass('is-invalid');
                            $(`#valor${after}`).addClass('is-invalid');

                        });
                    }

                    if (text2) {
                        $.each(text2, function(key, item) {
                            if ($(`#valor${item.id}`).val() > item.stock) {
                                $(`#valor${item.id}`).addClass('is-invalid')
                                $("#" + item.id + "errorCREATEMODAL").append(
                                    "<span class='text-danger'>" +
                                    'No hay stock suficiente.' + "</span>")
                            }
                        })
                    }
                    //////////////////////////////////////

                }

            });


        }
        //****************************************************************************************************************

        //PRODUCTOS SELECCIONADOS

        productsSelected.map(productSelected => {
        var money = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(productSelected.price)
        var textEdit = productSelected.description
        console.log(productSelected.cantidad)
            $('#listarSeleccionados').append(
                `
                <div class="card col-2 mx-2" style="width: 13rem;">
                    

                    <div id = "datos-product${productSelected.id}">

                        <h3 class="card-title text-center mt-4">${productSelected.name_product}</h3>
                        <h4 class="mb-2 text-success text-center font-weight-bold">${money}</h4>
                        <p id = "descriptio-text${productSelected.id}" class="card-text comment text-dark " style="min-height: 70px;">${textEdit}<a class ="text-dark" id = "text${productSelected.id}"></a></p>
                       
                        <div>
                            
                            <input  type="text" name="cantidad[${productSelected.id}]" class="form-control input-modal"  value = "${productSelected.cantidad}"  id="valor${productSelected.id}"  >                                
                            <span class="createmodal_error createmodal_error_product" id="${productSelected.id}errorCREATEMODAL"></span>
                            
                            <div class="d-grid gap-2 col-12 my-2">
                                
                                <button id = "bottonproduct${productSelected.id}" class="btn btn-danger" value = "${productSelected.id}" type="button"><i class="fa-solid fa-trash"></i> Eliminar producto</button>
                            
                            </div>

                        </div>
                        <span>Cantidad disponible: ${productSelected.stock}</span>
                        
                    <div>
                  
                </div>  
                
                `
            )
            
            // agrega productos seleccionados a lista

            valor =  new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(productSelected.price)
            $('#listSelect').append
            (
                `
                <div id="productSelect${productSelected.id}"class="card col-12">
                    <div class="row">

                        <div class="col mt-2 ms-2"><h5 class="card-title">${productSelected.name_product}</h5></div>
                        <div class="col  mt-2 "> <h5 class=""> ${valor}</h5></div>
                        <div class="col "> <h5 id ="productCount${productSelected.id}" class="pt-2 ">x ${productSelected.cantidad}</h5></div>
                        
                        
                    <div>
                </div>
            
                
                `
            )
            

       
            
            
            $(document).ready(function(){

                     // agregar cantidad a lista
                    productsMap.set(productSelected.id,productSelected.cantidad)
                    count = $(`#valor${productSelected.id}`).val()
                    total = total + (productSelected.price * count) 
                    productsMap.set(productSelected.id,count)
                   
                    clp = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(total)
                    console.log(clp+"aju")
                    $(`#total`).html(clp);
                
                $(`#valor${productSelected.id}`).keyup(function(){
                    count = $(`#valor${productSelected.id}`).val()
                    total = total + (productSelected.price * count) - ( productSelected.price * productsMap.get(productSelected.id) )
                    productsMap.set(productSelected.id,count)
                    console.log(total)
                    clp = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(total)
                    $(`#total`).html(clp);
                    $(`#productCount${productSelected.id}`).html("x "+$(`#valor${productSelected.id}`).val());
                    
                });
            
            });


            if(textEdit.length >= 36)
            {

                $(`#descriptio-text${productSelected.id}`).html(textEdit.slice(0,35)+` <a class ="fs-6 fw-bold text-dark" id ="text${productSelected.id}"> ver mas</a>`);

                $(`#descriptio-text${productSelected.id}`).click(function (e) {

                    $(`#descriptio-text${productSelected.id}`);
                    if ($(`#descriptio-text${productSelected.id}`).hasClass('more')) {
                    
                        $(`#descriptio-text${productSelected.id}`).html(textEdit.slice(0,35)+` <a class ="text-dark fs-6 fw-bold" id ="text${productSelected.id}"> ver mas</a>`);
                        $(`#descriptio-text${productSelected.id}`).removeClass('more');
                        
                    } else {
                
                        $(`#descriptio-text${productSelected.id}`).html(textEdit+` <a class ="fs-6 text-dark fs-6 fw-bold" id = "text${productSelected.id}"> ver menos </a>`);
                        $(`#descriptio-text${productSelected.id}`).addClass('more');
                        
                    
                    }
            
                 });

            }

            

            //al hacer click cambia color botton y borra vista de input number

            $(`#bottonproduct${productSelected.id}`).click(function(e) {
                
               
                if ($(`#bottonproduct${productSelected.id}`).hasClass(`onselect`)) {

                    $(`#valor${productSelected.id}`).removeClass(`d-none`);
                    $(`#bottonproduct${productSelected.id}`).removeClass(`onselect`);
                    $(`#bottonproduct${productSelected.id}`).removeClass(`btn-success`);
                    $(`#bottonproduct${productSelected.id}`).addClass('btn-danger');
                    $(`#bottonproduct${productSelected.id}`).text('Eliminar Producto');
                    $(`#valor${productSelected.id}`).attr('name', `cantidad[${productSelected.id}]`);
                    $(`#valor${productSelected.id}`).val(0);
                    var valor =  new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(productSelected.price)
                    $("#buttom-order").removeClass('more');
                    console.log("funcion creada")
                    $('#listSelect').append
                    (
                        `
                        <div id="productSelect${productSelected.id}"class="card col-12">
                            <div class="row">

                                <div class="col mt-2 ms-2"><h5 class="card-title">${productSelected.name_product}</h5></div>
                                <div class="col  mt-2 "> <h5 class=""> ${valor}</h5></div>
                                <div class="col "> <h5 id ="productCount${productSelected.id}" class="pt-2 "></h5></div>
                                
                                
                            <div>
                        </div>
                    
                        
                        `
                    )
                    productsMap.set(productSelected.id,0)





                    console.log('agregado')

                } else {
                    $(`#valor${productSelected.id}`).addClass(`d-none`);
                    $(`#bottonproduct${productSelected.id}`).addClass(`onselect`);
                    $(`#bottonproduct${productSelected.id}`).removeClass(`btn-danger`);
                    $(`#bottonproduct${productSelected.id}`).addClass('btn-success');
                    $(`#valor${productSelected.id}`).removeAttr('name');
                    $(`#bottonproduct${productSelected.id}`).text('Agregar producto');
                    total = total - ( productSelected.price * productsMap.get(productSelected.id) )
                    money = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(total)
                    $(`#valor${productSelected.id}`).val('');	
                    $(`#productSelect${productSelected.id}`).remove();
                    $(`#total`).html(money);
                    productsMap.delete(productSelected.id);

                    console.log($('#listSelect').find('div').length)
                    
                    if ($('#listSelect').find('div').length <= 0 ) {
                        $("#buttom-order").addClass("d-none");

                    } 

                    console.log('eliminado')
                }

            });



        })

        $("#buttom-order").click(function (e) { 
            $("#listSelect").empty();

            for (let key of productsMap.keys()) {
               
                $(`#valor`+key).addClass(`d-none`);
                    $(`#bottonproduct`+key).addClass(`onselect`);
                    $(`#bottonproduct`+key).removeClass(`btn-danger`);
                    $(`#bottonproduct`+key).addClass('btn-success');
                    $(`#valor`+key).removeAttr('name');
                     $(`#errorvalor`+key).addClass('d-none')
                    $(`#bottonproduct`+key).html(
                        '<i class="fa-solid fa-plus"></i> Agregar producto');
                    $('.createmodal_error_product').empty();
                    $(`#productSelect`+key).remove();
                    productsMap.delete(key);


            }

            total = 0;
            $("#buttom-order").addClass("d-none");
            $(`#total`).html("$ "+total);
            
        });








        //PRODUCTOS NO SELECCIONADOS
        products.map(productSelected => {

            var url = '{{ asset('storage') . '/' . ':urlImagen' }}';
            url = url.replace(':urlImagen', productSelected.image_product);

            var money = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(productSelected.price)
            var textEdit = productSelected.description
            $(`#listaProductos${productSelected.id_category_product}`).append(
                `
                    <div class="card col-2 mx-2 mt-2" style="width: 12rem;">
                        <div>

                            
                            <h3 class="card-title text-center mt-4">${productSelected.name_product}</h3>
                            <h4 class="mb-2 text-success text-center font-weight-bold">${money}</h4>
                            <p id = "descriptio-text${productSelected.id}" class="card-text comment text-dark " style="min-height: 70px;">${textEdit}<a class ="text-dark" id = "text${productSelected.id}"></a></p>
                            <span>Cantidad disponible: ${productSelected.stock}</span>
                            
                                
                                <input type="number" class="form-control d-none input-modal" value = "${productSelected.cantidad}" id="valor${productSelected.id}" >
                                <span class="createmodal_error createmodal_error_product" id="${productSelected.id}errorCREATEMODAL"></span>
                                <div class="d-grid gap-2 col-12 my-2">
                                 
                                    <button id = "bottonproduct${productSelected.id}" class="btn btn-success onselect " type="button"><i class="fa-solid fa-plus"></i>Agregar producto</button>
                               
                                </div>

                            </div>
                            
                        <div>
                    </div>
                </div>  
                    
                    `
            )

             // mas o menos descripcion
    
            if(textEdit.length >= 36)
            {

                $(`#descriptio-text${productSelected.id}`).html(textEdit.slice(0,35)+` <a class ="fs-6 fw-bold text-dark" id ="text${productSelected.id}"> ver mas</a>`);

                $(`#descriptio-text${productSelected.id}`).click(function (e) {

                    $(`#descriptio-text${productSelected.id}`);
                    if ($(`#descriptio-text${productSelected.id}`).hasClass('more')) {
                    
                        $(`#descriptio-text${productSelected.id}`).html(textEdit.slice(0,35)+` <a class ="text-dark fs-6 fw-bold" id ="text${productSelected.id}"> ver mas</a>`);
                        $(`#descriptio-text${productSelected.id}`).removeClass('more');
                        
                    } else {
                
                        $(`#descriptio-text${productSelected.id}`).html(textEdit+` <a class ="fs-6 text-dark fs-6 fw-bold" id = "text${productSelected.id}"> ver menos </a>`);
                        $(`#descriptio-text${productSelected.id}`).addClass('more');
                        
                    
                    }
            
                 });

            }

            $(`#image_product${productSelected.id}EDITVIEW`).append($('<img>', {
                src: url,
                class: 'img-fluid mt-2 ',
                style: 'height: 200px;'
            }))


            $(`#bottonproduct${productSelected.id}`).click(function(e) {
                console.long
                if ($(`#bottonproduct${productSelected.id}`).hasClass(`onselect`)) {

                    $(`#valor${productSelected.id}`).removeClass(`d-none`);
                    $(`#bottonproduct${productSelected.id}`).removeClass(`onselect`);
                    $(`#bottonproduct${productSelected.id}`).removeClass(`btn-success`);
                    $(`#bottonproduct${productSelected.id}`).addClass('btn-danger');
                    $(`#bottonproduct${productSelected.id}`).text('Eliminar Producto');
                    $(`#valor${productSelected.id}`).attr('name', `cantidad[${productSelected.id}]`);
                    $(`#valor${productSelected.id}`).val(0);
                    $("#buttom-order").removeClass("d-none");
                    var valor =  new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(productSelected.price)
                    $('#listSelect').append
                    (
                        `
                        <div id="productSelect${productSelected.id}"class="card col-12">
                            <div class="row">

                                <div class="col mt-2 ms-2"><h5 class="card-title">${productSelected.name_product}</h5></div>
                                <div class="col  mt-2 "> <h5 class=""> ${valor}</h5></div>
                                <div class="col "> <h5 id ="productCount${productSelected.id}" class="pt-2 "></h5></div>
                                
                                
                            <div>
                        </div>
                    
                        
                        `
                    )
                    productsMap.set(productSelected.id,0)
                    $(document).ready(function(){
                        
                        $(`#valor${productSelected.id}`).keyup(function(){
                            count = $(`#valor${productSelected.id}`).val()
                            total = total + (productSelected.price * count) - ( productSelected.price * productsMap.get(productSelected.id) )
                            productsMap.set(productSelected.id,count)
                            console.log(total)
                            clp = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(total)
                            $(`#total`).html(clp);
                            $(`#productCount${productSelected.id}`).html("x "+$(`#valor${productSelected.id}`).val());
                            
                        });
                       
                    });



                    console.log('agregado')

                } else {
                    $(`#valor${productSelected.id}`).addClass(`d-none`);
                    $(`#bottonproduct${productSelected.id}`).addClass(`onselect`);
                    $(`#bottonproduct${productSelected.id}`).removeClass(`btn-danger`);
                    $(`#bottonproduct${productSelected.id}`).addClass('btn-success');
                    $(`#valor${productSelected.id}`).removeAttr('name');
                    $(`#bottonproduct${productSelected.id}`).html(
                        '<i class="fa-solid fa-plus"></i>  Agregar producto');
                    
                    total = total - ( productSelected.price * productsMap.get(productSelected.id) )
                    money = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(total)
                    $(`#productSelect${productSelected.id}`).remove();
                    $(`#total`).html(money);
                    productsMap.delete(productSelected.id);

                    console.log($('#listSelect').find('div').length)
                    
                    if ($('#listSelect').find('div').length <= 0 ) {
                        $("#buttom-order").addClass("d-none");

                    } 

                    console.log('eliminado')
                }

            });


        })
    </script>
@endsection

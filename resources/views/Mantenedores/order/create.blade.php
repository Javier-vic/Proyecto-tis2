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
        <style>
        .anyClass {
            height:800px;
            overflow-y: scroll;
        }
      
      </style>


    <div class="container">

        <form onsubmit="createOrder(event)" method="POST" entype="multipart/form-data" id="formCreate">
            @csrf

            <div class="row">
                <div class="col-md-8 ">
                    
                    <!-- First / Last Name -->
                    <fieldset  class="form-group border p-3 mx-3 categoryName mb-4 anyClass rounded"  style=" width = 100%; overflow-x: hidden; overflow-y: scroll;">
                        <legend class="h1 text-center ">Productos disponibles</legend>


                        <nav id="navbar-example2" class="navbar navbar-light rounded-pill shadow bg-light px-3">
                            <ul class="nav nav-pills">

                                @foreach ($category as $item)
                                <li class="nav-item">
                                    <a class="nav-link" href="#listaProductos{{$item->id}}">{{$item->name}}</a>
                                </li>
                                @endforeach

                            </ul>
                        </nav>
                    
                        <div class="mt-5"  >

                            @foreach ($category as $item)
                            <div id="listaProductos{{$item->id}}" class="row list  rounded shadow mt-3" height="100px"> 
                                <h2 class="mt-3 ms-2 rounded-pill">{{$item->name}} <hr></h2>
                            </div>
                            @endforeach
                           
                        </div>

        
                    </fieldset>

                    <fieldset class="form-group border p-3 mt-3">
                        <legend class="w-auto h1 text-center mb-5 px-2"> Datos cliente </legend>
                        <div class="mb-4">
                            <label for="name_order" class="form-label"> <i class="fa-solid fa-user me-2"></i> Nombre cliente :</label>
                            <input type="text" class="form-control input-modal" value="{{ isset($order->name_order) ? $order->name_order : '' }}"
                                id="name_order" name="name_order" aria-describedby="name_product_help" >
                            <span class="createmodal_error" id="name_order_errorCREATEMODAL"></span>
                        </div>
        
        
                        <div class="mb-4">
                            <label for="name_order" class="form-label"><i class="fa-solid fa-truck me-2"></i>Despacho pedido :</label>
                            <select id="mi-select" class="form-control" name="pick_up"
                                value="{{ isset($order->pick_up) ? $order->pick_up : '' }}">
        
                                <option value="si">SI</option>
                                <option value="no">NO</option>
        
                            </select>
                        </div>
        
                        <div class="mb-4 entradas">
                            <label for="comment" class="form-label"><i class="fa-solid fa-map-location-dot me-2"></i>Direccion :</label>
                            <input type="text" class="form-control input-modal" value="{{ isset($order->address) ? $order->address : '' }}"
                                class="form-control" id="address" name="address" >
                                <span class="createmodal_error" id="address_errorCREATEMODAL"></span>
                        </div>
        
                        <div class="mb-4 entradas">
                            <label for="comment" class="form-label"><i class="fa-solid fa-phone me-2"></i> Número de celular :</label>
                            <input type="text" class="form-control input-modal" value=""
                                class="form-control" id="number" name="number" >
                                <span class="createmodal_error" id="number_errorCREATEMODAL"></span>
                        </div>
        
                        <div class="mb-4 entradas">
                            <label for="comment" class="form-label"><i class="fa-solid fa-envelope me-2"></i> Email :</label>
                            <input type="text" class="form-control input-modal" value=""
                                class="form-control" id="mail" name="mail" >
                                <span class="createmodal_error" id="mail_errorCREATEMODAL"></span>
                        </div>
        
        
                        <div class="mb-4">
                            <label for="name_order" class="form-label">Metodo de pago :</label>
                            <select id="payment_method" class="form-control" name="payment_method"
                                aria-describedby="name_product_help"
                                value="{{ isset($order->payment_method) ? $order->payment_method : 'no' }}">
        
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjera">Tarjera</option>
                                <option value="Webpay">Webpay</option>
                                <option value="Transferencia">Transferencia</option>
        
                            </select>
                        </div>
        
        
        
                        <div class="mb-4">
                            <label for="comment" class="form-label"><i class="fa-solid fa-comment me-2"></i>Comentario :</label>
                            <input type="text" class="form-control" value="{{ isset($order->comment) ? $order->comment : '' }}"
                                class="form-control" id="comment" name="comment">
                        </div>
                    </fieldset>
                </div>


                <div class="col-4 anyClass py-3 px-1 align-self-start sticky-top d-none d-md-block rounded sticky-margin-top shadow " style="widht=100%" >
                   
                    <div class="bg-black text-end rounded-pill pe-4">  <p id ="total" class="h1 text-white">$ 0</p> </div>
                    
                    <div class="text-white mt-4 mx-3 px-2" id = "text-order" >
                        <img src="https://cdn.picpng.com/fork/silverware-plate-fork-spoon-52667.png" alt=""
                            class="img-fluid opacity-50 mb-2" width="500" height="350">
                        <p class="text-muted m-0">Aún no has seleccionado ningún producto.</p>
                        <p class="text-muted m-0">Selecciona alguno produto!</p>
                    </div>

                    <div id = "listSelect" >
                       



                    </div>

                    <div id ="buttom-order" class="col-12 mt-3 d-none d-flex justify-content-center ">

                        <button type="button" class="btn btn-danger btn-sm">Borrar todo <i class="fa-solid fa-trash"></i> </button>


                    </div>
                </div>


            
            </div>
            

           

            <button type="submit" class=" mt-3 btn btn-primary">Realizar pedido</button>
        </form>

        
    </div>
@endsection

@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        var total = 0;
        $("#mi-select").change(function() {
            if ($(this).val() == 'si') {
                $('.entradas').removeClass('d-none');
                $('#address').removeClass('is-valid');
                $('#address').val('');

      
    
        
        var count = 0;

            } else {

                $('.entradas').addClass('d-none');
                $('#address').val('Sin direccion');
            }

        });

        // ****************************************************************************************************************
        //MODAL DE CREAR
        // ****************************************************************************************************************
        const createOrder = (e) => {
            e.preventDefault();

            var formData = new FormData(e.currentTarget);
            var url = '{{ route('order.store') }}';
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
                        title: 'Se ingresó la orden correctamente.',
                        showConfirmButton: false,
                        timer: 20000,
                        backdrop: false,
                        heightAuto: false,
                    })
                    
                    location.reload();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR)
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

      
        // mostrar productos y orden
        var clp;
        const categorys = @json($category);
        const productsSelected = @json($product); // id y cantidad productos seleccionados
        var products = new Map()
        $(document).ready(function () {


            categorys.map(category => { 

                console.log($(`#listaProductos${category.id}`).find('div').length)

                if ($(`#listaProductos${category.id}`).find('div').length <= 0 ) {
                        $(`#listaProductos${category.id}`).remove();

                    } 

            })
            
      
        });

        $("#buttom-order").click(function (e) { 
            $("#listSelect").empty();

            for (let key of products.keys()) {
               
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
                    products.delete(key);


            }

            total = 0;
            $("#text-order").removeClass("d-none");
            $("#buttom-order").addClass("d-none");
            $(`#total`).html("$ "+total);
            
        });

        productsSelected.map(productSelected => {

            var money = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(productSelected.price)
            var textEdit = productSelected.description
            $(`#listaProductos${productSelected.id_category_product}`).append(
                `
                    <div class="card col-2 mx-3 my-3 shadow" style="width: 12rem;">
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
            
            var url = '{{ asset('storage') . '/' . ':urlImagen' }}';
            url = url.replace(':urlImagen', productSelected.image_product);
            $(`#image_product${productSelected.id}EDITVIEW`).append($('<img>', {
                src: url,
                class: 'img-fluid mt-2'
            }))

            // mas o menos descripcion
    
            if(textEdit.length >= 36){

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
            else {
                $(`text${productSelected.id}`).text('');

            }

            

            //al hacer click cambia color botton y borra vista de input number

            $(`#bottonproduct${productSelected.id}`).click(function(e) {
                if ($(`#bottonproduct${productSelected.id}`).hasClass(`onselect`)) {

                    $(`#valor${productSelected.id}`).removeClass(`d-none`);
                    $(`#bottonproduct${productSelected.id}`).removeClass(`onselect`);
                    $(`#bottonproduct${productSelected.id}`).removeClass(`btn-success`);
                    $(`#errorvalor${productSelected.id}`).removeClass('d-none')
                    $(`#valor${productSelected.id}`).val('')
                    $(`#bottonproduct${productSelected.id}`).addClass('btn-danger');
                    $(`#valor${productSelected.id}`).attr('name', `cantidad[${productSelected.id}]`);
                    $(`#bottonproduct${productSelected.id}`).html('<i class="fa-solid fa-trash"></i>  Eliminar Producto');
                    $("#buttom-order").removeClass("d-none");
                    $("#text-order").addClass("d-none");

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
                    products.set(productSelected.id,0)

                    
                    $(document).ready(function(){
                        
                        $(`#valor${productSelected.id}`).keyup(function(){
                            count = $(`#valor${productSelected.id}`).val()
                            total = total + (productSelected.price * count) - ( productSelected.price * products.get(productSelected.id) )
                            products.set(productSelected.id,count)
                            console.log(total)
                            clp = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(total)
                            $(`#total`).html(clp);
                            $(`#productCount${productSelected.id}`).html("x "+$(`#valor${productSelected.id}`).val());
                            
                        });
                       
                    });



                    

                } else {

                    $(`#valor${productSelected.id}`).addClass(`d-none`);
                    $(`#bottonproduct${productSelected.id}`).addClass(`onselect`);
                    $(`#bottonproduct${productSelected.id}`).removeClass(`btn-danger`);
                    $(`#bottonproduct${productSelected.id}`).addClass('btn-success');
                    $(`#valor${productSelected.id}`).removeAttr('name');
                    $(`#errorvalor${productSelected.id}`).addClass('d-none')
                    $(`#bottonproduct${productSelected.id}`).html(
                        '<i class="fa-solid fa-plus"></i> Agregar producto');
                    $('.createmodal_error_product').empty();
                    total = total - ( productSelected.price * products.get(productSelected.id) )
                    money = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(total)
                    $(`#productSelect${productSelected.id}`).remove();
                    $(`#total`).html(money);
                    products.delete(productSelected.id);

                    console.log($('#listSelect').find('div').length)
                    
                    if ($('#listSelect').find('div').length <= 0 ) {
                        $("#buttom-order").addClass("d-none");
                        $("#text-order").removeClass("d-none");

                    } 

                }
            });

            

        })
    </script>
@endsection

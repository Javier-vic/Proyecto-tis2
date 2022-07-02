@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')
    <div class="row">

        <div class="col">

            <form onsubmit="createOrder(event)" method="POST" entype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="name_order" class="form-label">Nombre cliente :</label>
                    <input type="text" class="form-control input-modal" value="{{ isset($order->name_order) ? $order->name_order : '' }}"
                        id="name_order" name="name_order" aria-describedby="name_product_help" >
                    <span class="createmodal_error" id="name_order_errorCREATEMODAL"></span>
                </div>


                <div class="mb-4">
                    <label for="order_status" class="form-label">Estado pedido :</label>
                    <select id="order_status" class="form-control" name="order_status"
                        value="{{ isset($order->order_status) ? $order->order_status : '' }}">

                        <option value="Espera">Espera</option>
                        <option value="Cocinando">Cocinando</option>
                        <option value="Listo">Listo</option>
                        <option value="Entregado">Entregado</option>

                    </select>
                </div>


                <div class="mb-4">
                    <label for="name_order" class="form-label">Despacho pedido :</label>
                    <select id="mi-select" class="form-control" name="pick_up"
                        value="{{ isset($order->pick_up) ? $order->pick_up : '' }}">

                        <option value="si">SI</option>
                        <option value="no">NO</option>

                    </select>
                </div>

                <div class="mb-4 entradas">
                    <label for="comment" class="form-label">Direccion :</label>
                    <input type="text" class="form-control input-modal" value="{{ isset($order->address) ? $order->address : '' }}"
                        class="form-control" id="address" name="address" >
                        <span class="createmodal_error" id="address_errorCREATEMODAL"></span>
                </div>

                <div class="mb-4 entradas">
                    <label for="comment" class="form-label">Número de celular :</label>
                    <input type="text" class="form-control input-modal" value=""
                        class="form-control" id="number" name="number" >
                        <span class="createmodal_error" id="number_errorCREATEMODAL"></span>
                </div>

                <div class="mb-4 entradas">
                    <label for="comment" class="form-label">Email :</label>
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
                        <option value="Credito">Credito</option>
                        <option value="Debito">Debito</option>

                    </select>
                </div>



                <div class="mb-4">
                    <label for="comment" class="form-label">Comentario :</label>
                    <input type="text" class="form-control" value="{{ isset($order->comment) ? $order->comment : '' }}"
                        class="form-control" id="comment" name="comment">
                </div>

                <div class="mt-5">
                    <h3>Productos disponibles</h3>
                    <h2 class="createmodal_error" id="cantidad_errorCREATEMODAL"></h2>
                    <div id="listaProductos" class="row">
                </div>


                </div>

                <button type="submit" class=" mt-3 btn btn-primary">Realizar pedido</button>
            </form>


        </div>



    </div>
@endsection

@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">



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
                        timer: 2000,
                        backdrop: false,
                        heightAuto: false,
                    })
                    location.reload();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if(jqXHR.responseJSON.errors){
                        var text = jqXHR.responseJSON.errors;

                    }
                    if(jqXHR.responseJSON.errors2){
                        var text2 = jqXHR.responseJSON.errors2;
                    }
                    
                    console.log(text2)
                    console.log(text)
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
                            $("#" + after + "errorCREATEMODAL").append("<span class='text-danger'>" +
                            item + "</span>")

                            $(`#${key}`).addClass('is-invalid');
                            $(`#valor${after}`).addClass('is-invalid');
            
                        });
                    }

                    if(text2){
                        $.each(text2,function(key,item){
                           if($(`#valor${item.id}`).val() > item.stock){
                               $(`#valor${item.id}`).addClass('is-invalid')
                               $("#" + item.id + "errorCREATEMODAL").append("<span class='text-danger'>" +
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

        const productsSelected = @json($product); // id y cantidad productos seleccionados


        productsSelected.map(productSelected => {



            $('#listaProductos').append(
                `
                    <div class="card col-2 mx-2" style="width: 15rem;">
                    <div id = "image_product${productSelected.id}EDITVIEW"></div>
                        <div>
                            <h5 class="card-title">${productSelected.name_product}</h5>
                            <p class="card-text">${productSelected.description}</p>
                            <span>Cantidad disponible: ${productSelected.stock}</span>
                            <div>
                                <h4 class="pt-2 ">${productSelected.price}</h4>
                                <input type="text" class="form-control d-none input-modal" value = "${productSelected.cantidad}" id="valor${productSelected.id}" >
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
                    $(`#bottonproduct${productSelected.id}`).html(
                        '<i class="fa-solid fa-trash"></i>  Eliminar Producto');

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
                }

            });



        })


    </script>
@endsection

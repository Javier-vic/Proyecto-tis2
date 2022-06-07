
@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')
<form onsubmit="updateOrder(event,{{$orderData->id}})" method="POST" >

    @csrf
    {{method_field('PATCH') }}

    {{$orderData->id}}
    <div class="mb-4">
        <label for="name_order" class="form-label">Nombre cliente :</label>
        <input type="text" class="form-control input-modal" value="" id="name_order" name="name_order" aria-describedby="name_product_help">
        <span class="createmodal_error" id="name_order_errorCREATEMODAL"></span>
    </div>

    <div class="mb-4">
        <label for="name_order" class="form-label">fecha :</label>
        <input type="text" class="form-control" id="date" name="date" aria-describedby="name_product_help">
    </div>
  

    <div class="mb-4">
        <label class="form-label">Estado pedido :</label>
        <select id="order_status"  class="form-control" name="order_status" >
            <option value="Espera" >Espera</option>
            <option value="Cocinando" >Cocinando</option>
            <option value="Listo">Listo</option>
            <option value="Entregado">Entregado</option>
        
        </select>
    </div>



    <div class="mb-4">
        <label for="pick_up" class="form-label">Despacho pedido :</label>
            <select id="mi-select"  class="form-control" name="pick_up" value = "{{isset($order->pick_up)?$order->pick_up:'' }}">

                <option value="si" {{ $orderData->pick_up == 'si' ? 'selected' : '' }}>SI</option>
                <option value="no" {{ $orderData->pick_up == 'no' ? 'selected' : '' }}>NO</option>
            
            </select>
    </div>

    <div class="mb-4 entradas">
        <label for="" class="form-label">Direccion :</label>
        <input type="text"  class="form-control input-modal" class="form-control" id="address" name="address" >
        <span class="createmodal_error" id="address_errorCREATEMODAL"></span>
    </div>
  
    <div class="mb-4">
        <label  class="form-label">Metodo de pago :</label>
            <select id="payment_method"  class="form-control" name="payment_method" aria-describedby="name_product_help" value="{{ isset($orderData->payment_method)?$orderData->payment_method:''}}">
                <option value="Efectivo" >Efectivo</option>
                <option value="Credito">Credito</option>
                <option value="Debito" >Debito</option>
            </select>
    </div>   

    <div class="mb-4">
        <label for="comment" class="form-label">comentario :</label>
        <input type="text"  class="form-control" value="{{ isset($orderData->comment)?$orderData->comment:'' }}" class="form-control" id="comment" name="comment" >
    </div>


    <div class="mb-4">
        <label for="total" class="form-label">Total :</label>
        <input type="number"  class="form-control" class="form-control" id="total" name="total" >
    </div>


    <div class="mt-5">
        <h3>Productos disponibles</h3>
        <h2 class="createmodal_error" id="cantidad_errorCREATEMODAL"></h2>
        <div id="listaProductos" class="row">
    </div>

   
   
   
    <button type="submit" class="btn btn-primary">Realizar pedido</button>





</form>


@endsection

@section('js_after')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
   $( document ).ready(function() {
    if($('#mi-select').val() == 'no') $('.entradas').addClass('d-none')
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
        const productsSelected = @json($productsSelected);    // id y cantidad productos seleccionados
        const size = products.length;

        // datos orden orden 
        $('#name_order').val(selectproduct.name_order);
        $('#date').val(selectproduct.created_at);
        $('#payment_method').val(selectproduct.payment_method);
        $('#order_status').val(selectproduct.order_status);
        $('#address').val(selectproduct.address);
        $('#total').val(selectproduct.total);

             // ****************************************************************************************************************
        //MODAL DE CREAR
        // ****************************************************************************************************************
        const updateOrder = (e,id) => {
            e.preventDefault();
 
            var formData = new FormData(e.currentTarget);
            var url = '{{ route('order.update', ':order') }}';
            url = url.replace(':order',id)
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

        //PRODUCTOS SELECCIONADOS
        productsSelected.map(productSelected =>{
                $('#listaProductos').append(
                `
                <div class="card col-2 mx-2" style="width: 15rem;">
                    <div id = "image_product${productSelected.id}EDITVIEW"></div>

                        <div id = "datos-product${productSelected.id}">

                            <h5 class="card-title">${productSelected.name_product}</h5>
                            <p class="card-text">${productSelected.description}</p>
                            <span class="card-text">Cantidad disponible: ${productSelected.stock}</span>
                            <div>
                                <h4 class="pt-2 ">$${productSelected.price}</h4>
                                <input  type="text" name="cantidad[${productSelected.id}]" class="form-control input-modal"  value = "${productSelected.cantidad}"  id="valor${productSelected.id}"  >                                
                                <span class="createmodal_error createmodal_error_product" id="${productSelected.id}errorCREATEMODAL"></span>
                                
                                <div class="d-grid gap-2 col-12 my-2">
                                 
                                    <button id = "bottonproduct${productSelected.id}" class="btn btn-danger" value = "${productSelected.id}" type="button"><i class="fa-solid fa-trash"></i> Eliminar producto</button>
                               
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
                 
                $(`#bottonproduct${productSelected.id}`).click(function (e) { 
                   
                    if ($(`#bottonproduct${productSelected.id}`).hasClass(`onselect`)) {
                        
                        $(`#valor${productSelected.id}`).removeClass(`d-none`);
                        $(`#bottonproduct${productSelected.id}`).removeClass(`onselect`);
                        $(`#bottonproduct${productSelected.id}`).removeClass(`btn-success`);
                        $(`#bottonproduct${productSelected.id}`).addClass('btn-danger');
                        $(`#bottonproduct${productSelected.id}`).text('Eliminar Producto');
                        $(`#valor${productSelected.id}`).attr('name',`cantidad[${productSelected.id}]`);
                        

                        
                        

                        console.log('agregado')
                    
                    } else {
                        $(`#valor${productSelected.id}`).addClass(`d-none`);
                        $(`#bottonproduct${productSelected.id}`).addClass(`onselect`);
                        $(`#bottonproduct${productSelected.id}`).removeClass(`btn-danger`);
                        $(`#bottonproduct${productSelected.id}`).addClass('btn-success');
                        $(`#valor${productSelected.id}`).removeAttr('name');
                        $(`#bottonproduct${productSelected.id}`).text('Agregar producto');

                        
                        console.log('eliminado')
                    }
                    
                });

                
               
            })

            
            //PRODUCTOS NO SELECCIONADOS
            products.map(productSelected =>{
                
                    var url = '{{ asset('storage') . '/' . ':urlImagen' }}';
                                url = url.replace(':urlImagen', productSelected.image_product);
                
                $('#listaProductos').append(
                    `
                    <div class="card col-2 mx-2" style="width: 15rem;">
                    <div id = "image_product${productSelected.id}EDITVIEW"></div>
                        <div>
                            <h5 class="card-title">${productSelected.name_product}</h5>
                            <p class="card-text">${productSelected.description}</p>
                            <span class="card-text">Cantidad disponible: ${productSelected.stock}</span>
                            <div>
                                <h4 class="pt-2 ">$${productSelected.price}</h4>
                                <input type="text" class="form-control d-none input-modal"  value = "${productSelected.cantidad}" id="valor${productSelected.id}"  >
                                <span class="createmodal_error createmodal_error_product" id="${productSelected.id}errorCREATEMODAL"></span>
                                
                                <div class="d-grid gap-2 col-12 my-2">
                                 
                                    <button id = "bottonproduct${productSelected.id}" class="btn btn-success onselect " type="button"><i class="fa-solid fa-plus"></i>  Agregar producto</button>
                               
                                </div>

                            </div>
                            
                        <div>
                    </div>
                </div>  
                    
                    ` 
                    )

                $(`#image_product${productSelected.id}EDITVIEW`).append($('<img>', {
                    src: url,
                    class: 'img-fluid mt-2 ' ,
                    style: 'height: 200px;'
                    }))


                    $(`#bottonproduct${productSelected.id}`).click(function (e) { 
                    console.long
                    if ($(`#bottonproduct${productSelected.id}`).hasClass(`onselect`)) {
                        
                        $(`#valor${productSelected.id}`).removeClass(`d-none`);
                        $(`#bottonproduct${productSelected.id}`).removeClass(`onselect`);
                        $(`#bottonproduct${productSelected.id}`).removeClass(`btn-success`);
                        $(`#bottonproduct${productSelected.id}`).addClass('btn-danger');
                        $(`#bottonproduct${productSelected.id}`).text('Eliminar Producto');
                        $(`#valor${productSelected.id}`).attr('name',`cantidad[${productSelected.id}]`);
                        $(`#valor${productSelected.id}`).val(0);
                        
                        

                        console.log('agregado')
                    
                    } else {
                        $(`#valor${productSelected.id}`).addClass(`d-none`);
                        $(`#bottonproduct${productSelected.id}`).addClass(`onselect`);
                        $(`#bottonproduct${productSelected.id}`).removeClass(`btn-danger`);
                        $(`#bottonproduct${productSelected.id}`).addClass('btn-success');
                        $(`#valor${productSelected.id}`).removeAttr('name');
                        $(`#bottonproduct${productSelected.id}`).html('<i class="fa-solid fa-plus"></i>  Agregar producto');
                       
                        
                        console.log('eliminado')
                    }
                    
                });


            })
            
         
    

 </script>



@endsection
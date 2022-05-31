@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')
    <div class="row">

        <div class="col">

            <form action="{{ url('/order') }}" method="POST" entype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="name_order" class="form-label">Nombre cliente :</label>
                    <input type="text" class="form-control" value="{{ isset($order->name_order) ? $order->name_order : '' }}"
                        id="name_order" name="name_order" aria-describedby="name_product_help">
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
                    <input type="text" class="form-control " value="{{ isset($order->address) ? $order->address : '' }}"
                        class="form-control" id="address" name="address">
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


                <div id="listaProductos" class="row">


                </div>

                <button type="submit" class=" mt-3 btn btn-primary">Realizar pedido</button>
            </form>


        </div>



    </div>
@endsection

@section('js_after')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#mi-select").change(function() {
                if ($(this).val() == 'si') {

                    $('.entradas').removeClass('d-none');
                } else {
                    $('.entradas').addClass('d-none');
                }

            });
        });

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
                            <div>
                                <h4 class="pt-2 ">${productSelected.price}</h4>
                                <input type="number" type="number" class="form-control d-none" min="1" value = "${productSelected.cantidad}" max = "${productSelected.stock}" id="valor${productSelected.id}"  >
                                
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
                    $(`#bottonproduct${productSelected.id}`).addClass('btn-danger');
                    $(`#valor${productSelected.id}`).attr('name', `cantidad[${productSelected.id}]`);
                    $(`#bottonproduct${productSelected.id}`).html(
                        '<i class="fa-solid fa-trash"></i>  Eliminar Producto');




                    console.log('agregado')

                } else {
                    $(`#valor${productSelected.id}`).addClass(`d-none`);
                    $(`#bottonproduct${productSelected.id}`).addClass(`onselect`);
                    $(`#bottonproduct${productSelected.id}`).removeClass(`btn-danger`);
                    $(`#bottonproduct${productSelected.id}`).addClass('btn-success');
                    $(`#valor${productSelected.id}`).removeAttr('name');
                    $(`#bottonproduct${productSelected.id}`).html(
                        '<i class="fa-solid fa-plus"></i> Agregar producto');


                    console.log('eliminado')
                }

            });



        })
    </script>
@endsection

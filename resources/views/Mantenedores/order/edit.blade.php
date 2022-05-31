
@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')
<form action="{{ route('order.update', $orderData->id) }}" method="POST" >

    @csrf
    {{method_field('PATCH') }}

    {{$orderData->id}}
    <div class="mb-4">
        <label for="name_order" class="form-label">Nombre pedido :</label>
        <input type="text" class="form-control" value="" id="name_order" name="name_order" aria-describedby="name_product_help">
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
        <input type="text"  class="form-control " class="form-control" id="address" name="address" >
    </div>
  
    <div class="mb-4">
        <label  class="form-label">Metodo de pago :</label>
            <select id="payment_method"  class="form-control" name="payment_method" aria-describedby="name_product_help" value="{{ isset($orderData->payment_method)?$orderData->payment_method:''}}">
                <option value="Efectivo" >Efectivo</option>
                <option value="Credito">Credito</option>
                <option value="Pedidos ya" >Pedidos ya</option>
           
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


    <div class="row " id="listaProductos"></div>
   
   
    <button type="submit" class="btn btn-primary">Realizar pedido</button>





</form>


@endsection

@section('js_after')

    <script type="text/javascript">
   

        // mostrar productos y orden
        const selectproduct = @json($orderData); //datos orden
        const products = @json($products); // todo los productos
        const productsSelected = @json($productsSelected);    // id y cantidad productos seleccionados
        const size = products.length;

        // datos orden orden 
        $('#name_order').val(selectproduct.name_order);
        $('#date').val(selectproduct.created_at);
        $('#payment_method').val(selectproduct.payment_method);
        $('#order_status').val(selectproduct.order_status);
        $('#address').val(selectproduct.address);
        $('#total').val(selectproduct.total);

        productsSelected.map(productSelected =>{

          
                
                $('#listaProductos').append(
                `
                <div class="card col-2 mx-2" style="width: 15rem;">
                    <div id = "image_product${productSelected.id}EDITVIEW"></div>

                        <div id = "datos-product${productSelected.id}">

                            <h5 class="card-title">${productSelected.name_product}</h5>
                            <p class="card-text">${productSelected.description}</p>
                            <div>
                                <h4 class="pt-2 ">${productSelected.price}</h4>
                                <input type="number" type="number" name="cantidad[${productSelected.id}]" class="form-control" min="1" value = "${productSelected.cantidad}" max = "${productSelected.stock}" id="valor${productSelected.id}"  >
                                
                              
                                
                                <div class="d-grid gap-2 col-12 my-2">
                                 
                                    <button id = "bottonproduct${productSelected.id}" class="btn btn-danger" value = "${productSelected.id}" type="button"><i class="fa-regular fa-trash"></i> Eliminar producto</button>
                               
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
                        $(`#bottonproduct${productSelected.id}`).html('<i class="fa-regular fa-trash"></i> Eliminar Producto');
                        $(`#valor${productSelected.id}`).attr('name',`cantidad[${productSelected.id}]`);
                        

                        
                        

                        console.log('agregado')
                    
                    } else {
                        $(`#valor${productSelected.id}`).addClass(`d-none`);
                        $(`#bottonproduct${productSelected.id}`).addClass(`onselect`);
                        $(`#bottonproduct${productSelected.id}`).removeClass(`btn-danger`);
                        $(`#bottonproduct${productSelected.id}`).addClass('btn-success');
                        $(`#valor${productSelected.id}`).removeAttr('name');
                        $(`#bottonproduct${productSelected.id}`).html('Agregar producto');

                        
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
                            <div>
                                <h4 class="pt-2 ">${productSelected.price}</h4>
                                <input type="number" type="number" class="form-control d-none" min="1" value = "${productSelected.cantidad}" max = "${productSelected.stock}" id="valor${productSelected.id}"  >
                                
                                <div class="d-grid gap-2 col-12 my-2">
                                 
                                    <button id = "bottonproduct${productSelected.id}" class="btn btn-success onselect " type="button">Agregar producto</button>
                               
                                </div>

                            </div>
                            
                        <div>
                    </div>
                </div>  
                    
                    ` 
                    )

                $(`#image_product${productSelected.id}EDITVIEW`).append($('<img>', {
                    src: url,
                    class: 'img-fluid mt-2'
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
                        $(`#bottonproduct${productSelected.id}`).html('<i class="fa-regular fa-trash"></i> Agregar producto');
                       
                        
                        console.log('eliminado')
                    }
                    
                });


            })
            
         
    

 </script>



@endsection
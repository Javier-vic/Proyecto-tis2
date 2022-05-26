
@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')
<form action="{{ route('order.update', $orderData->id) }}" method="POST" >

    @csrf
    {{method_field('PATCH') }}

   
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
                <option value="Debito" }>Debito</option>
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
        $(document).ready(function () {
                $("#mi-select").change(function(){
            if(this.value == 'si'){ 
            
                $(".entradas").show()
            
                
            }else{
                $(".address").prop('disabled', true);
            
                }
            
        });
        
        
            
        })

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
            console.log(productSelected)
            var url = '{{ asset('storage') . '/' . ':urlImagen' }}';
                            url = url.replace(':urlImagen', productSelected.image_product);
            
            //PRODUCTOS SELECCIONADOS
            $('#listaProductos').append(
            `
            <div class="card col-2 mx-2" style="width: 15rem;">
                <div id = "image_product${productSelected.id}EDITVIEW"></div>
                    <div>
                        <h5 class="card-title">${productSelected.name_product}</h5>
                        <p class="card-text">${productSelected.description}</p>
                        <div>
                            <input type="number" type="number" name="cantidad[]" class="form-control"  min="1" value = "${productSelected.cantidad}" max = "${productSelected.stock}" class="form-control" id="valor${productSelected.id}"  >
                            <input class="form-check-input" name="permits[]" type="checkbox" checked value="${productSelected.id}" id="check${productSelected.id}">
                        </div>
                        <h4 class="pt-2 ">${productSelected.price}</h4>
                </div>
            </div>  

            ` 
            )

            $(`#image_product${productSelected.id}EDITVIEW`).append($('<img>', {
                src: url,
                class: 'img-fluid mt-2'
                }))
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
                            <input type="number" type="number" name="cantidad[]" class="form-control" min="1" value = "${productSelected.cantidad}" max = "${productSelected.stock}" class="form-control" id="valor${productSelected.id}"  >
                            <input class="form-check-input" name="permits[]"  type="checkbox"  value="${productSelected.id}" id="check${productSelected.id}">
                        </div>
                        <h4 class="pt-2 ">${productSelected.price}</h4>
                </div>
            </div>  
            
            ` 
            )

            $(`#image_product${productSelected.id}EDITVIEW`).append($('<img>', {
                src: url,
                class: 'img-fluid mt-2'
                }))
            })
            
         
    

 </script>



@endsection
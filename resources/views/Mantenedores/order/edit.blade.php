
@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')
<form action="{{ route('order.update', $selectOrder->id) }}" method="POST" >

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

                <option value="si" {{ $selectOrder->pick_up == 'si' ? 'selected' : '' }}>SI</option>
                <option value="no" {{ $selectOrder->pick_up == 'no' ? 'selected' : '' }}>NO</option>
            
            </select>
    </div>

    <div class="mb-4 entradas">
        <label for="" class="form-label">Direccion :</label>
        <input type="text"  class="form-control " class="form-control" id="address" name="address" >
    </div>
  
    <div class="mb-4">
        <label  class="form-label">Metodo de pago :</label>
            <select id="payment_method"  class="form-control" name="payment_method" aria-describedby="name_product_help" value="{{ isset($selectOrder->payment_method)?$selectOrder->payment_method:''}}">
                <option value="Efectivo" >Efectivo</option>
                <option value="Credito">Credito</option>
                <option value="Debito" }>Debito</option>
            </select>
    </div>   

    <div class="mb-4">
        <label for="comment" class="form-label">comentario :</label>
        <input type="text"  class="form-control" value="{{ isset($selectOrder->comment)?$selectOrder->comment:'' }}" class="form-control" id="comment" name="comment" >
    </div>


    <div class="mb-4">
        <label for="total" class="form-label">Total :</label>
        <input type="number"  class="form-control" class="form-control" id="total" name="total" >
    </div>


    <div class="row " id="pruebaProductos"></div>
   
   
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
        const selectproduct = @json($selectOrder); //datos orden
        const product = @json($product); // todo los productos
        const query = @json($query);    // id y cantidad productos seleccionados
        const size = query.length;
        console.log(selectproduct);

        // datos orden orden 
        $('#name_order').val(selectproduct.name_order);
        $('#date').val(selectproduct.created_at);
        $('#payment_method').val(selectproduct.payment_method);
        $('#order_status').val(selectproduct.order_status);
        $('#address').val(selectproduct.address);
        $('#total').val(selectproduct.total);

    
        product.map(product =>{
            
            var url = '{{ asset('storage') . '/' . ':urlImagen' }}';
                            url = url.replace(':urlImagen', product.image_product);
            
            // muestra productos
            $('#pruebaProductos').append(
            `
            <div class="card col-2 mx-2" style="width: 15rem;">
                <div id = "image_product${product.id}EDITVIEW"></div>
                    <div>
                        <h5 class="card-title">${product.name_product}</h5>
                        <p class="card-text">${product.description}</p>
                        <div>
                            <input type="number" type="number" name="cantidad[]" class="form-control"  value = "0" max = "${product.stock}" class="form-control" id="valor${product.id}"  >
                            <input class="form-check-input" name="permits[]"  type="checkbox" id="check${product.id}">
                        </div>
                        <h4 class="pt-2 ">${product.price}</h4>
                    </div>
                </div>
                
                                    
                ` 
            )
                
                for (let index = 0; index < size ; index++) {
                    if(product.id == query[index].product_id ){


                        $(`#valor${product.id}`).val(query[index].cantidad);
                        $(`#check${product.id}`).prop("checked",true);


                    }
                    
                }
            

                $(`#image_product${product.id}EDITVIEW`).append($('<img>', {
                                src: url,
                                class: 'img-fluid mt-2'
                            }))
                            
                

            })
            
         
    

 </script>



@endsection
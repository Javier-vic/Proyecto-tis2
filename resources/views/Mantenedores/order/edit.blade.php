
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
    <input type="text" class="form-control" value="{{ $selectOrder->name_order }}" id="name_order" name="name_order" aria-describedby="name_product_help">
</div>
  

<div class="mb-4">
    <label for="order_status" class="form-label">Estado pedido :</label>
    <select id="order_status"  class="form-control" name="order_status" value = "{{ isset($selectOrder->order_status)?$selectOrder->order_status:'' }}">

        <option value="Cocinando"  {{ $selectOrder->order_status == 'Cocinando' ? 'selected' : '' }}>Cocinando</option>
        <option value="Listo"  {{ $selectOrder->order_status == 'Listo' ? 'selected' : '' }}>Listo</option>
        <option value="Entregado"  {{ $selectOrder->order_status == 'Entregado' ? 'selected' : '' }}>Entregado</option>
    
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
    <label for="comment" class="form-label">Direccion :</label>
    <input type="text"  class="form-control " value="{{ isset($selectOrder->address)?$selectOrder->address:'' }}" class="form-control" id="address" name="address" >
</div>
  
<div class="mb-4">
    <label for="name_order" class="form-label">Metodo de pago :</label>
    <select id="payment_method"  class="form-control" name="payment_method" aria-describedby="name_product_help" value="{{ isset($selectOrder->payment_method)?$selectOrder->payment_method:''}}">

        <option value="Efectivo" {{ $selectOrder->payment_met9hod == 'Efectivo' ? 'selected' : '' }} >Efectivo</option>
        <option value="Credito" {{ $selectOrder->payment_method == 'Credito' ? 'selected' : '' }}>Credito</option>
        <option value="Debito" {{ $selectOrder->payment_method == 'Debito' ? 'selected' : '' }}>Debito</option>
    
    </select>
</div>   

    <div class="mb-4">
        <label for="total" class="form-label">Total :</label>
        <input type="text"  class="form-control" value="{{ isset($selectOrder->total)?$selectOrder->total:''}}" class="form-control" id="total" name="total" >
    </div>


    <div class="mb-4">
        <label for="comment" class="form-label">Comentario :</label>
        <input type="text"  class="form-control" value="{{ isset($selectOrder->comment)?$selectOrder->comment:'' }}" class="form-control" id="comment" name="comment" >
    </div>

    <div class="row">
        
        @foreach ($product as $item)

        <div class="card col-2 mx-2" style="width: 15rem;">
            <img src="{{ asset('storage') . '/' . $item->image_product }}" class="card-img-top" alt="...">
            <div class="card-body">
    
                <h5 class="card-title">{{$item->name_product}}</h5>
                <p class="card-text">{{$item->description}}</p>
                <div class="form-check form-switch">
                <input class="form-check-input" name="permits[]" value="{{isset($selectOrder->total)?$selectOrder->total:''}}" {{ in_array($item->id, $name) ? 'checked' : '' }} type="checkbox" id="{{$item->id}}" >
                    <input type="number" id="{{$item->id}}" name="cantidad[]" class="form-control" value="{{}}" />
                    
                </div>
                <h4 class="pt-2 ms-.">${{$item->price}}</h4>
            </div>
        </div> 
    
         @endforeach


    </div>
   





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
            $(".entradas").hide();
        
            }
        
    });
    
    
        
    })

    

    

 </script>



@endsection
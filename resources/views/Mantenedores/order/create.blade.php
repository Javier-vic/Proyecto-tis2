@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')

<form action="{{ route('order.store') }}"  method= "POST" enctype="multipart/form-data" id="postForm">
    @csrf
    
    <div class="mb-4">
        <label for="name_order" class="form-label">Nombre pedido :</label>
        <input type="text" class="form-control" value="{{ isset($order->name_order)?$order->name_order:'' }}" id="name_order" name="name_order" aria-describedby="name_product_help">
    </div>
   
    
    <div class="mb-4">
        <label for="order_status" class="form-label">Estado pedido :</label>
        <select id="order_status"  class="form-control" name="order_status" value = "{{ isset($order->order_status)?$order->order_status:'' }}">
    
            <option value="Cocinando">Cocinando</option>
            <option value="Listo">Listo</option>
            <option value="Entregado">Entregado</option>
        
        </select>
    </div>
 
 
    <div class="mb-4">
        <label for="name_order" class="form-label">Despacho pedido :</label>
        <select id="pick_up"  class="form-control" name="pick_up" value = "{{isset($order->pick_up)?$order->pick_up:'' }}">
    
            <option value="no">SI</option>
            <option value="si">NO</option>
        
        </select>
    </div>
 
   
    <div class="mb-4">
        <label for="name_order" class="form-label">Metodo de pago :</label>
        <select id="payment_method"  class="form-control" name="payment_method" aria-describedby="name_product_help" value="{{ isset($order->payment_method)?$order->payment_method:''}}">
    
            <option value="Efectivo" >Efectivo</option>
            <option value="Credito">Credito</option>
            <option value="Debito">Debito</option>
        
        </select>
    </div>   
 
 
 
     <div class="mb-4">
         <label for="comment" class="form-label">Comentario :</label>
         <input type="text"  class="form-control" value="{{ isset($order->comment)?$order->comment:'' }}" class="form-control" id="comment" name="comment" >
     </div>

    <div class="row">
        @foreach ($product as $item)
            <div class="card col-2 mx-2" style="width: 18rem;">
                <img src="{{ asset('storage') . '/' . $item->image_product }}" class="card-img-top" alt="...">
                <div class="card-body">

                    <h5 class="card-title">{{$item->name_product}}</h5>
                    <p class="card-text">{{$item->name_product}}</p>
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="permits[]" value="{{$item->id}}" type="checkbox" id="{{$item->id}}">
                        <input type="number" id="typeNumber" name="cantidad[]" class="form-control" />
                       
                    </div>

                </div>
            </div>
        @endforeach

    </div>
    
     <button type="submit" class="btn btn-primary mt-2">Guardar pedido</button>
</form>

@endsection

@section('js_after')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<script type="text/javascript">
  
    const addorder = (e) =>{
                e.preventDefault();
                var data = $("#postForm").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{route('order.store')}}",
                    data: data,
                    dataType: "text",
                    success: function (response) {
                        Table.ajax.reload();
                    
                    }
                });
            }



</script>

@endsection

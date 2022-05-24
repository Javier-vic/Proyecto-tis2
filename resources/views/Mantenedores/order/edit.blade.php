
@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')
<form action="{{ route('order.update', $order->id) }}" method="POST" >

    @csrf
    {{method_field('PATCH') }}

       
   
<div class="mb-4">
    <label for="name_order" class="form-label">Nombre pedido :</label>
    <input type="text" class="form-control" value="{{ isset($order->name_order)?$order->name_order:'' }}" id="name_order" name="name_order" aria-describedby="name_product_help">
</div>
  

<div class="mb-4">
    <label for="order_status" class="form-label">Estado pedido :</label>
    <select id="order_status"  class="form-control" name="order_status" value = "{{ isset($order->order_status)?$order->order_status:'' }}">

        <option value="Cocinando"  {{ $order->order_status == 'Cocinando' ? 'selected' : '' }}>Cocinando</option>
        <option value="Listo"  {{ $order->order_status == 'Listo' ? 'selected' : '' }}>Listo</option>
        <option value="Entregado"  {{ $order->order_status == 'Entregado' ? 'selected' : '' }}>Entregado</option>
    
    </select>
</div>


<div class="mb-4">
    <label for="pick_up" class="form-label">Despacho pedido :</label>
    <select id="pick_up"  class="form-control" name="pick_up" value = "{{isset($order->pick_up)?$order->pick_up:'' }}">

        <option value="no" {{ $order->pick_up == 'si' ? 'selected' : '' }}>SI</option>
        <option value="si" {{ $order->pick_up == 'no' ? 'selected' : '' }}>NO</option>
    
    </select>
</div>

  
<div class="mb-4">
    <label for="name_order" class="form-label">Metodo de pago :</label>
    <select id="payment_method"  class="form-control" name="payment_method" aria-describedby="name_product_help" value="{{ isset($order->payment_method)?$order->payment_method:''}}">

        <option value="Efectivo" {{ $order->payment_met9hod == 'Efectivo' ? 'selected' : '' }} >Efectivo</option>
        <option value="Credito" {{ $order->payment_method == 'Credito' ? 'selected' : '' }}>Credito</option>
        <option value="Debito" {{ $order->payment_method == 'Debito' ? 'selected' : '' }}>Debito</option>
    
    </select>
</div>   

    <div class="mb-4">
        <label for="total" class="form-label">Total :</label>
        <input type="text"  class="form-control" value="{{ isset($order->total)?$order->total:''}}" class="form-control" id="total" name="total" >
    </div>


    <div class="mb-4">
        <label for="comment" class="form-label">Comentario :</label>
        <input type="text"  class="form-control" value="{{ isset($order->comment)?$order->comment:'' }}" class="form-control" id="comment" name="comment" >
    </div>

    <div class="row">
        
        @foreach ($product as $item)

        <div class="card col-2 mx-2" style="width: 15rem;">
            <img src="{{ asset('storage') . '/' . $item->image_product }}" class="card-img-top" alt="...">
            <div class="card-body">
    
                <h5 class="card-title">{{$item->name_product}}</h5>
                <p class="card-text">{{$item->description}}</p>
                <div class="form-check form-switch">
                    <input class="form-check-input" name="permits[]" value="{{$item->id}}" type="checkbox" id="{{$item->id}}">
                    <input type="number" id="typeNumber" name="cantidad[]" class="form-control" />
                    
                </div>
                <h4 class="pt-2 ms-0">${{$item->price}}</h4>
            </div>
        </div> 
    
    @endforeach


    </div>
   





    <button type="submit" class="btn btn-primary">Realizar pedido</button>





</form>


@endsection
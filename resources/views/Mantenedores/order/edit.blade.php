
<form action="{{url('/Mantenedores/order/'.$order->id) }}" method="POST" >

@csrf
{{method_field('PATCH') }}

@include('Mantenedores.order.form')


</form>

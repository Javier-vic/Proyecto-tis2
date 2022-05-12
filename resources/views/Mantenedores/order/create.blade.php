<form action="{{ url('/order')}}" method="POST" entype= "multipart/form-data">
    @csrf
   @include('order.form')



</form>
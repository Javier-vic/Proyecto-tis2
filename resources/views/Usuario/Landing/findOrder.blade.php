@extends('layouts.userNavbar')

@section('content')
<div>@include('Usuario.Landing.modal.view')</div>

<div class="border shadow-lg p-3">
    <div class="text-center">
        <form action="{{route('show.order')}}" method="get">
            @csrf
            <input type="number" class="form-control" id="id" name="id" value="" >
            <button type="" class="border border-danger p-1 px-2">                
                <i class="fa-solid fa-magnifying-glass text-danger btn-find-order"></i>
            </button>
        </form>
    </div>
    <div id="content-order">
        @foreach($order)
            <span>{{$order->name_order}}</span>
        @endforeach
    </div>
</div>

@endsection

@section ('js_after')

<!-- <script>
        const showOrderDetails = () =>{
            var id = document.getElementById("id").value;
            $.ajax({
                type: "GET",
                url: "{{ route('show.order') }}",
                data: {
                    'id': id,
                },
                dataType: "json",
                success: function(response) {
                    resultado = response;
                    alert(id);
                    $('#nameOrderVIEWMODAL').val(resultado[1]);
                    $('#name_order').val(resultado[1][0].name_order);

                    console.log(resultado)

                }
            });
        }
</script> -->
<!-- <script>
        const showOrder = (e) =>{
            e.preventDefault;
            var id = new FormData(e.currentTarget);
            $.ajax({
                type: "GET",
                url: "{{ route('show.order') }}",
                data: {
                    'id': id,
                },
                dataType: "json",
                success: function(response) {
                    $('#content-order').empty();
                    response.order.map(orders=> {
                        $('#content-order').append(                                                      
                            `                                                        
                                <div>                                        
                                    <span>${orders.name_order} </span>                                                                          
                                </div>                                                           
                            `                              
                        )
                    })
                }
            });
        }
</script> -->

@endsection
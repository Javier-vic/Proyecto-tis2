@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')

<form nsubmit="addorderfin(event)" method="POST" enctype="multipart/form-data" id="selectproduct">
    @csrf
  
    <div class="container">
        <input class="form-control" type="text" value="{{$order->id}}" aria-label="readonly input example" readonly>
        <div class="row">
            
            @foreach ($product as $item)
            <div class="card col-2" style="width: 18rem;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">

                    <h5 class="card-title">{{$item->name_product}}</h5>
                    <p class="card-text">{{$item->name_product}}</p>
                    <div class="form-check form-switch">
                        <input class="form-check-input" name="permits[]" value="{{$item->id}}" type="checkbox" id="{{$item->id}}">
                    </div>

                </div>
            </div>
            @endforeach
            
            

        </div>
       
    </div>

    <button type="submit" class="btn btn-primary">Agregar</button>

</form>


@endsection
@section('js_after')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script type="text/javascript">

        const addorderfin = (e) =>{
            e.preventDefault();
            var data = $("#selectproduct").serializeArray();
            $.ajax({
                type: "POST",
                url: "{{route('order.addproduct')}}",
                data: data,
                dataType: "text",
                success: function (response) {
                    Table.ajax.reload();
                   
                }
            });
        }

    </script>
@endsection
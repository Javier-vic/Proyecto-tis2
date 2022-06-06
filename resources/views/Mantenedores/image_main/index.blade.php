@extends('layouts.navbar')

@section('titlePage')
    <h2 class="">Imagenes publicitarias</h2>
@endsection

@section('content')
    <div class="row">
        {{sizeof($images)}}
    </div>
    <form onsubmit="submitImages(event);" id="formSubmitImages">
        <div class="row">
            @foreach ($images as $image)
                
            @endforeach
            @for ($i = 0; $i < 4-sizeof($images); $i++)
                <div class="col-12 col-md-3 my-2">
                    <div class="d-flex my-2 align-content-center">
                        <label for="">Orden:</label>
                        <select name="order-{{$i+1+sizeof($images)}}" class="form-select ms-4  d-flex" id="" >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <input type="file" class="form-control" name="image-{{$i+1+sizeof($images)}}">
                </div>    
            @endfor
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center">
                <button class="btn btn-success">Guardar cambios</button>
            </div>
        </div>
    </form>
@endsection

@section('js_after')
    <script>
        const submitImages = (e) =>{
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            console.log(FormData);
            $.ajax({
                type: "POST",
                url: "{{route('publicity.store')}}",
                data: formData,
                success: function (response) {
                    console.log(response);
                }
            });
        }
    </script>
@endsection


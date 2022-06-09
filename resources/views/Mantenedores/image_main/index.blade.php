@extends('layouts.navbar')

@section('titlePage')
    <h2 class="">Imagenes publicitarias</h2>
@endsection

@section('content')
    <div class="row">
        {{sizeof($images)}}
    </div>
    <form onsubmit="submitImages(event);" method="POST" id="formSubmitImages" enctype="multipart/form-data">
        @csrf
        <div class="row">
            @foreach ($images as $key=>$image)
                <div class="col-12 col-md-12 col-xl-6 my-2">
                    <div class="text-center">
                        <img src="{{ asset('storage') . '/' . $image->route }}" alt="">
                    </div>
                    <div class="d-flex my-2 justify-content-center align-content-center">
                        <label for="" class="d-flex">Orden:</label>
                        <select name="order-{{$key}}" class="form-select w-auto ms-2 d-flex" id="idOrder-{{$key}}">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <input type="file" class="form-control" name="image-{{$key}}">
                </div>  
            @endforeach
            @for ($i = 0; $i < 4-sizeof($images); $i++)
                <div class="col-12 col-md-12 col-lg-6 mt-auto my-2">
                    <div class="d-flex my-2 justify-content-center">
                        <label for="">Orden:</label>
                        <select name="order-{{$i+1+sizeof($images)}}" class="form-select ms-2 w-auto d-flex" id="" >
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
            console.log(e.currentTarget);
            var formData = new FormData(e.currentTarget);
            console.log(formData);
            for(var i = 1; i < 5; i++){
                for(var j = 1; j < 5; j++){
                    if($(`#idOrder-${i}`).val() == $(`#idOrder-${j}`).val() && i!=j ){
                        console.log(`image ${i} tiene mismo orden que iamgen ${j}`);
                        
                    }
                }
            }
            $.ajax({
                type: "POST",
                url: "{{route('publicity.store')}}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);  
                }
            });
            
        }
    </script>
@endsection


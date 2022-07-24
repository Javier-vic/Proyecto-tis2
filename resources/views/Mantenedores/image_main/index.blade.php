@extends('layouts.navbar')

@section('titlePage')
    <h2 class="">Imagenes publicitarias</h2>
@endsection

@section('content')

    <form onsubmit="submitImages(event);" method="POST" id="formSubmitImages" enctype="multipart/form-data">
        @csrf
        <div class="row">
            @foreach ($images as $key=>$image)
                <div class="col-12 col-md-12 col-xl-6 my-2">
                    <div class="text-center">
                        <img src="{{ asset('storage') . '/' . $image->route }}" width="300px" id="idPreImage-{{$key+1}}" class="img-fluid border border-2 rounded border-secondary" alt="">
                        <input type="integer" id="id" name="idImage-{{$key+1}}" value="{{$image->id}}" hidden/>
                    </div>
                    <div class="d-flex my-2 justify-content-center align-content-center">
                        <label for="" class="d-flex">Orden:</label>
                        <select name="order-{{$key+1}}" class="form-select w-auto ms-2 d-flex" id="idOrder-{{$key+1}}">
                            <option value="1" {{$image->order == 1 ? 'selected': ''}}>1</option>
                            <option value="2" {{$image->order == 2 ? 'selected': ''}}>2</option>
                            <option value="3" {{$image->order == 3 ? 'selected': ''}}>3</option>
                            <option value="4" {{$image->order == 4 ? 'selected': ''}}>4</option>
                        </select>
                        <button class="btn btn-danger ms-2" type="button" onclick="deleteImage({{$image->id}})">Eliminar</button>
                    </div>
                    <input type="file" class="form-control" name="image-{{$key+1}}" id="idImage-{{$key+1}}">
                </div>  
            @endforeach
            @for ($i = 0; $i < 4-sizeof($images); $i++)
                <div class="col-12 col-md-12 col-lg-6 mt-auto my-2">
                    <div class="d-flex my-2 justify-content-center">
                        <label for="">Orden:</label>
                        <select name="order-{{$i+1+sizeof($images)}}" class="form-select ms-2 w-auto d-flex" id="idOrder-{{$i+1+sizeof($images)}}" >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <input type="file" class="form-control" name="image-{{$i+1+sizeof($images)}}" id="idImage-{{$i+1+sizeof($images)}}">
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const submitImages = (e) =>{
            e.preventDefault();
            Swal.fire({
            title: '¿Estas seguro de guardar los cambios?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, guardar!',
            cancelButtonText: 'Cancelar',
            }).then((result)=>{
                if(result.isConfirmed){
                    var formData = new FormData(e.target);
                    for(var i = 1; i < 5; i++){
                        for(var j = 1; j < 5; j++){
                            if(($(`#idOrder-${i}`).val() == $(`#idOrder-${j}`).val()) && i!=j){
                                if(($(`#idImage-${i}`)[0].files[0] && $(`#idImage-${j}`)[0].files[0])){
                                    Swal.fire({
                                        title: 'Imagenes tienen el mismo orden!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                    })
                                    console.log('aqi')
                                    return;
                                }
                                if( ($(`#idImage-${i}`)[0].files[0] ||  $(`#idPreImage-${i}`).attr('src')) && ($(`#idImage-${j}`)[0].files[0] || $(`#idPreImage-${j}`).attr('src')) ){
                                    Swal.fire({
                                        title: 'Imagenes tienen el mismo orden!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                    })
                                    console.log(i+" con "+j)
                                    return;
                                }
                                if( ($(`#idImage-${j}`)[0].files[0] ||  $(`#idPreImage-${j}`).attr('src')) && ($(`#idImage-${i}`)[0].files[0] || $(`#idPreImage-${i}`).attr('src')) ){
                                    Swal.fire({
                                        title: 'Imagenes tienen el mismo orden!',
                                        icon: 'warning',
                                        showCancelButton: true,
                                    })
                                    return;   
                                }
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
                            Swal.fire({
                            position: 'bottom-end',
                            icon: 'success',
                            title: 'Cambios guardados.',
                            showConfirmButton: false,
                            timer: 2000,
                            backdrop: false,
                            heightAuto: false,
                            }).then(()=>{
                                location.reload();
                            })
                        }
                    });
                }
            })
        }
        function findByOrder(order){
            var images = @json($images);
            for(var i = 0; i< images.length; i++){
                if(images[i].order == Number(order)){
                    return true;
                }else{
                    return false;
                }
            }
        }
        const deleteImage = (id) => {
            Swal.fire({
            title: '¿Estas seguro de eliminar la imagen?',
            text: 'No se puede revertir',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar',
            }).then((res)=>{
                var url = '{{ route("publicity.destroy", ":id") }}';
                url = url.replace(':id', id);
                if(res.isConfirmed){
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {"_token": "{{ csrf_token() }}"},
                        dataType: "text",
                        success: function (response) {
                            Swal.fire({
                                title:'Borrado!',
                                text:'La imagen ha sido borrada',
                                icon:'success',
                                timer: 3000,
                                }
                            ).then(()=>{
                                location.reload(); 
                            });
                        }
                    });
                }
            })
        }
    </script>
@endsection


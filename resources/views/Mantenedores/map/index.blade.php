@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
    integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
    crossorigin=""/>
@endsection

@section('titlePage')
<h2 class="">Ubicación del local</h2>
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div>
    @include('Mantenedores.map.modal.edit')
</div>

<div>
<span>Distancia de delivery</span>
    <input type="text" id="delivery_distance" name="delivery_distance">
    <select name="unit" id="unit">
    <option value="kilometer">Kilómetros</option>
    <option value="meter">Metros</option>
    </select>
</div>

<div class="h-75">
    <div class="w-100 text-center mb-2"><button onclick="centerMap()" class="btn btn-primary">Centrar mapa</button></div>
    <div class="container h-100">
        <div class="row justify-content-center h-100">
            <div class="col-8" id="map" style="height: 100%; border: solid 1px;"></div>
        </div>
    </div>
</div>
@endsection

@section('js_after')
<script type="text/javascript">
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
   integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
   crossorigin=""></script>
   <script>
       let datosMapa = @json($mapa);
       let {direccion,id,latitud,longitud} = datosMapa
       const AT = 'pk.eyJ1IjoiZmVlbGluZ29vZCIsImEiOiJjbDNreWwzN2YxcWN1M2pxaXYyMmhienFyIn0.W6ChTj4rP0NOsFcvBL-xbg'

       var map = L.map('map').setView([parseFloat(latitud),parseFloat(longitud)], 18);
       map.doubleClickZoom.disable();
       L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution:'<b style="font-size:1rem;">Haz doble click sobre un lugar para cambiar la ubicación del local.</b> ',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: AT,
    }).addTo(map);

    //CREAR LEYENDA

    const centerMap = () => {
        map.setView([latitud, longitud], 18);
    }
    
    var marker = L.marker([parseFloat(latitud), parseFloat(longitud)], {
        title : 'Tienda ramen dashi'
    }).addTo(map);

    marker.bindPopup(`<b>Ramen Dashi</b><br> Estamos ubicados en ${direccion}`).openPopup();
    map.addEventListener('dblclick',function(e){

        let mapaLat=e.latlng.lat;
        let mapaLon=e.latlng.lng;

        $('#editMap').modal('show');
        $('#latitud').val(mapaLat);
        $('#longitud').val(mapaLon);
        $("#formEdit").attr('onSubmit', `editMap(${id},event)`);
     
    })

    const editMap = (id,e) =>{
            e.preventDefault();
            var data = $("#formEdit").serializeArray();
            console.log(data)
            var  url = '{{ route("map.update" , ":map") }}';
            url = url.replace(":map",1)
                $.ajax({
                type: "PUT",
                url: url,
                data: data,
                    success: function(response, jqXHR) {
                        Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Se cambió la ubicación correctamente.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,
                        heightAuto:false,
                    })
                    //LIMPIA INVALIDS
                    $(`#direccion`).removeClass('is-invalid');
                    $("#direccion_error").empty()
                    $('#editMap').modal('hide');
                    location.reload();
                    },
                   error: function( jqXHR, textStatus, errorThrown ) {
                    var text = jqXHR.responseJSON;

                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: "No se pudo cambiar la ubicación.",
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                    //AGREGA INVALIDS
                    if(text){
                    $.each(text.errors, function(key,item){
                    $("#"+key+"_error").append("<span class='text-danger'>"+item+"</span>")
                    $(`#${key}`).addClass('is-invalid');
                    });
                    //
                    }

               }
                
                });
            }


   </script>
@endsection
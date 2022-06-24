@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
    integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
    crossorigin=""/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0-beta.2.rc.2/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.2.3/leaflet.draw.css">
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
    <div class="w-100 text-center mb-2"><button onclick="saveZones(event)" class="btn btn-primary">Guardar zonas</button></div>
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
   <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.2.3/leaflet.draw.js"></script>
   
   <script>

      let datosMapa = @json($mapa);
      let {direccion,id,latitud,longitud} = datosMapa
      const AT = 'pk.eyJ1IjoiZmVlbGluZ29vZCIsImEiOiJjbDNreWwzN2YxcWN1M2pxaXYyMmhienFyIn0.W6ChTj4rP0NOsFcvBL-xbg'

    // Crea el mapa
    var map = L.map('map').setView([parseFloat(latitud),parseFloat(longitud)], 15);
  

    // Inicializa "Featuregroup" para poder ir sumandole capas que son editables ( osea las zonas que se crean)
    var editableLayers = new L.FeatureGroup();
    map.addLayer(editableLayers);

    //Si es que existen zonas las parseamos a un formato valido...
      if(datosMapa.delivery_zones){
      let polygonsSaved = JSON.parse(datosMapa.delivery_zones);
       console.log(polygonsSaved)

       var arrayOfNumbers = []
       polygonsSaved.map(polygon =>{
       var aux
       let arrayAux = []
        //FUNCION PARA PASAR TODOS LOS VALORES DE COORDENADAS DE STRING A INT
        for (let i = 0; i < polygon.length; i++) {
        aux = polygon[i].map(Number);
        
        arrayAux.push(aux.reverse())
        }
        arrayOfNumbers.push(arrayAux)
       })


       //CREA LOS POLIGONOS Y LOS DIBUJA EN EL MAPA
        let polygon;
        arrayOfNumbers.map(polygon=>{
         polygon = L.polygon(polygon, {color: 'red'}).addTo(map);
          editableLayers.addLayer(polygon)
        })
       
      }
    

    map.doubleClickZoom.disable();
    // Set up the OSM layer
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution:'<b style="font-size:1rem;">Haz doble click sobre un lugar para cambiar la ubicación del local.</b> ',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: AT,
    }).addTo(map);
    
  //FUNCION PARA CENTRAR EL MAPA AL CLICKEAR BOTON "CENTRAR MAPA"
    const centerMap = () => {
        map.setView([latitud, longitud], 17);
    }
    // AGREGA EL MARCADOR DÓNDE SE UBICA LA TIENDA + EL TEXTO FLOTANTE
    var marker = L.marker([parseFloat(latitud), parseFloat(longitud)], {
        title : 'Tienda ramen dashi'
    }).addTo(map);
    marker.bindPopup(`<b>Ramen Dashi</b><br> Estamos ubicados en ${direccion}`).openPopup();


      //FUNCIÓN QUE ABRE EL MODAL AL HACER DOBLE CLICK PARA CAMBIAR LA UBICACIÓN
      map.addEventListener('dblclick',function(e){

      let mapaLat=e.latlng.lat;
      let mapaLon=e.latlng.lng;

      $('#editMap').modal('show');
      $('#latitud').val(mapaLat);
      $('#longitud').val(mapaLon);
      $("#formEdit").attr('onSubmit', `editMap(${id},event)`);

      })
  
 

    var drawPluginOptions = {
      position: 'topright',
      draw: {
        polygon: {
          allowIntersection: false, // Restricts shapes to simple polygons
          drawError: {
            color: '#e1e100', // Color the shape will turn when intersects
            message: '<strong>Oh snap!<strong> you can\'t draw that!' // Message that will show when intersect
          },
          shapeOptions: {
            color: '#97009c'
          }
        },
        // disable toolbar item by setting it to false
        polyline: false,
        circle: false, // Turns off this drawing tool
        rectangle: false,
        marker: false,
        },
      edit: {
        featureGroup: editableLayers, //REQUIRED!!
        edit: false,
        remove: true 
        
      }
    };
    var drawControl = new L.Control.Draw(drawPluginOptions);

    //AGREGA COMO LAYER BORRABLE
    map.addControl(drawControl);

//AGREGA LOS POLIGONOS COMO CAPAS ( ASI SE PUEDEN ELIMINAR Y QUEDAN GUARDADOS)

  // editableLayers.addLayer(polygon2)

    // Initialise the draw control and pass it the FeatureGroup of editable layers
      map.on('draw:created', function(e) {
      var type = e.layerType, layer = e.layer;
    if (type === 'marker') {
        layer.bindPopup('A popup!');
      }

      editableLayers.addLayer(layer);

    });
    // 



// create a red polygon from an array of LatLng points
//CREA POLIGONO Y SE LE ASIGNA FUNCION QUE AL CLICKEAR SE PUEDE HACER ALGO
// var latlngs = [[37, -109.05],[41, -109.03],[41, -102.05],[37, -102.04],[38, -105.04]];

// var polygon = L.polygon(latlngs, {color: 'red'}).addTo(map);

// polygon.on("click",function(e){
//     console.log('clickeau')
//     console.log(e)
// })

// zoom the map to the polygon
// map.fitBounds(polygon.getBounds());


      //****************************************************************************************************************
        //GUARDAR LAS ZONAS CREADAS
        // ****************************************************************************************************************
        const saveZones = (e) => {
            
            let url = '{{ route('map.store') }}';
            let polygons = editableLayers.toGeoJSON().features
      
            let coordinates = []
            console.log('poltgonse')
            let valores = polygons.map(singlePolygon =>{
              console.log('sP')
              console.log(singlePolygon)
              coordinates.push(singlePolygon.geometry.coordinates[0])
              })
                $.ajax({
                type: "POST",
                url: url,
                data : {polygons:coordinates},
                dataType: "json",

                success: function(response) {
                   console.log(response)
                   if(response.success){
                    var toastMixin = Swal.mixin({
                    toast: true,
                    position: 'bottom-right',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                toastMixin.fire({
                    title: response.message,
                    icon: 'success'
                });
                   }
    
                },
                error: function(jqXHR, textStatus, errorThrown){
                    let response = jqXHR.responseJSON
                   if(!response.success){
                    var toastMixin = Swal.mixin({
                    toast: true,
                    position: 'bottom-right',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                toastMixin.fire({
                    title: response.message,
                    icon: 'error'
                });
                   }
                   
                }

            });
        }

        //****************************************************************************************************************
        //EDITA LA UBCACION , GUARDA EL NOMBRE NUEVO Y SUS COORDENADAS (LAT Y LONG)
        // ***
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
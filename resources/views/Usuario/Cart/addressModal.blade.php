<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Despacho a domicilio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Dirección </label>
                        <input type="text" class="form-control input-modal" id="address" name="address"
                            aria-describedby="name_product_help" placeholder="Almagro 745, Chillán , Las mariposas">
                        <span class="text-danger createmodal_error" id="address_errorCREATEMODAL"></span>
                    </div>
                   <div id="map" style="height: 600px; width:600px;"></div>
                    <button type="submit" class="btn btn-primary">Crear</button>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>


<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script>

 
   let datosMapa = @json($mapa);
   let {direccion,id,latitud,longitud} = datosMapa
   const AT = 'pk.eyJ1IjoiZmVlbGluZ29vZCIsImEiOiJjbDNreWwzN2YxcWN1M2pxaXYyMmhienFyIn0.W6ChTj4rP0NOsFcvBL-xbg'
 // Crea el mapa
 var map = L.map('map').setView([parseFloat(latitud),parseFloat(longitud)], 15);
 // Automatically defines Leaflet.draw to the specified language

 // Inicializa "Featuregroup" para poder ir sumandole capas que son editables ( osea las zonas que se crean)
 var editableLayers = new L.FeatureGroup();
 map.addLayer(editableLayers);

   //Si es que existen zonas las parseamos a un formato valido...
   if(datosMapa.delivery_zones){
      let polygonsSaved = JSON.parse(datosMapa.delivery_zones);

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
    

 // Set up the OSM layer
 L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
     attribution:'<b style="font-size:1rem;">Haz doble click sobre un lugar para cambiar la ubicación del local.</b> ',
     maxZoom: 18,
     id: 'mapbox/streets-v11',
     tileSize: 512,
     zoomOffset: -1,
     accessToken: AT,
 }).addTo(map);
 

 // AGREGA EL MARCADOR DÓNDE SE UBICA LA TIENDA + EL TEXTO FLOTANTE
 var marker = L.marker([parseFloat(latitud), parseFloat(longitud)], {
     title : 'Tienda ramen dashi'
 }).addTo(map);
 marker.bindPopup(`<b>Ramen Dashi</b><br> Estamos ubicados en ${direccion}`).openPopup();


   //FUNCIÓN QUE ABRE EL MODAL AL HACER DOBLE CLICK PARA CAMBIAR LA UBICACIÓN
 map.doubleClickZoom.disable();
   map.addEventListener('dblclick',function(e){
    console.log('working')
   let mapaLat=e.latlng.lat;
   let mapaLon=e.latlng.lng;

   $('#editMap').modal('show');
   $('#latitud').val(mapaLat);
   $('#longitud').val(mapaLon);
   $("#formEdit").attr('onSubmit', `editMap(${id},event)`);

   })




</script>
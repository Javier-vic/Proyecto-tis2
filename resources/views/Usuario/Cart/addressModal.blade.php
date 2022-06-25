<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Despacho a domicilio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                    <span class="text-danger d-none" id="deliveryError">Esta dirección no cuenta con delivery</span>
                   <div id="map" style="height: 600px; width:100%;" class="border"></div>
                   <p class="text-muted">*Para búsquedas más precisas use el formato: Nombre calle , N° Calle, Ciudad</p>

                    <button type="submit" class="btn btn-primary">Crear</button>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    </div>
</div>


<script src='https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js'></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<script type="text/javascript" src="{{ asset('js/turf.min.js') }}"></script>
<script>
    let datosMapa = @json($mapa);
    let {direccion,id,latitud,longitud} = datosMapa
    const AT = 'pk.eyJ1IjoiZmVlbGluZ29vZCIsImEiOiJjbDNreWwzN2YxcWN1M2pxaXYyMmhienFyIn0.W6ChTj4rP0NOsFcvBL-xbg'
    // Crea el mapa
    mapboxgl.accessToken = AT;
    var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [parseFloat(datosMapa.longitud),parseFloat(datosMapa.latitud) ],
    zoom:15
    });

    const coordinatesGeocoder = function (query) {
// Match anything which looks like
// decimal degrees coordinate pair.
const matches = query.match(
/^[ ]*(?:Lat: )?(-?\d+\.?\d*)[, ]+(?:Lng: )?(-?\d+\.?\d*)[ ]*$/i
);
if (!matches) {
return null;
}
 
function coordinateFeature(lng, lat) {
return {
center: [lng, lat],
geometry: {
type: 'Point',
coordinates: [lng, lat]
},
place_name: 'Lat: ' + lat + ' Lng: ' + lng,
place_type: ['coordinate'],
properties: {},
type: 'Feature'
};
}
 
const coord1 = Number(matches[1]);
const coord2 = Number(matches[2]);
const geocodes = [];
 
if (coord1 < -90 || coord1 > 90) {
// must be lng, lat
geocodes.push(coordinateFeature(coord1, coord2));
}
 
if (coord2 < -90 || coord2 > 90) {
// must be lat, lng
geocodes.push(coordinateFeature(coord2, coord1));
}
 
if (geocodes.length === 0) {
// else could be either lng, lat or lat, lng
geocodes.push(coordinateFeature(coord1, coord2));
geocodes.push(coordinateFeature(coord2, coord1));
}
 
return geocodes;
};

    //Agrega controles al mapa (zoom,rotacion,etc)
    let geocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    mapboxgl: mapboxgl,
    reverseGeocode: true,
    localGeocoder: coordinatesGeocoder,
    keepOpen: false,
    })
    map.addControl(geocoder);

   //Si es que existen zonas las parseamos a un formato valido...
   if(datosMapa.delivery_zones){
      let polygonsSaved = JSON.parse(datosMapa.delivery_zones);
      let polygonsTurf = []

       var arrayOfNumbers = []
       polygonsSaved.map(polygon =>{
       var aux
       let arrayAux = []
       //FUNCION PARA PASAR TODOS LOS VALORES DE COORDENADAS DE STRING A INT
        for (let i = 0; i < polygon.length; i++) {
        aux = polygon[i].map(Number);
        
        arrayAux.push(aux)
        }
        arrayOfNumbers.push(arrayAux)
       })
       

    
       map.on('load', () => {
            //Crea los poligonos
            arrayOfNumbers.map((polygon, index)=>{

            //Agrega los poligonos pasandole las coordenadas
           /* map.addSource(`polygon${index}`, {
            'type': 'geojson',
            'data': {
            'type': 'Feature',
            'geometry': {
            'type': 'Polygon',
            // These coordinates outline Maine.
            'coordinates': [polygon]
            }
            }
            });

            map.addLayer({
                'id': `polygon${index}`,
                'type': 'fill',
                'source': `polygon${index}`, // reference the data source
                'layout': {},
                'paint': {
                'fill-color': '#F10101', // Relleno de color rojo
                'fill-opacity': 0.3
                }
            });

            //Agrega borde de color negro
            map.addLayer({
            'id': `border${index}`,
            'type': 'line',
            'source': `polygon${index}`,
            'layout': {},
            'paint': {
            'line-color': '#000',
            'line-width': 0.1
            }
            });
        */
            //Se crean poligonos con la libreria TURF para luego verificar si el marcador del cliente se encuentra dentro de alguno
            polygonsTurf.push(turf.polygon([polygon], { name: `poly${index}`}));

            })

            
          
         
       
      })

      //Se ejecuta cuando se escribe una dirección y el marcador se agrega al mapa
      geocoder.on('result', function(e) {
        console.log(e)
        let checkPoint = false;
        //Funcion que revisa todos los poligonos existentes y si en alguno el marcador está dentro hace la variable checkPoint verdadera
        polygonsTurf.map(polygon=>{
            let isInside = turf.inside(e.result.center,polygon)
            if(isInside) checkPoint = isInside;
        })
        console.log(checkPoint)

        if(checkPoint){
        let direccion = e.result.place_name;
        $('#address').val(direccion.split(',')[0] )
        $('#deliveryAddress').html(direccion.split(',')[0])
        $('#map').addClass('border-success')
        $('#map').removeClass('border-danger')

        $('#deliveryError').addClass('d-none')
        $('#deliveryError').removeClass('d-block')
        

        }
        else{
        $('#address').val('')

        $('#deliveryError').removeClass('d-none')
        $('#deliveryError').addClass('d-block')

        $('#map').removeClass('border-success')
        $('#map').addClass('border-danger')
        }
       


    })

    //Se ejecuta cuando el usuario clickea el mapa
    map.on('click', (e) => {
        geocoder.query(`${e.lngLat.lat.toString()},${e.lngLat.lng.toString()}`)
        geocoder.setInput(`${e.lngLat.lat.toString()},${e.lngLat.lng.toString()}`)
    });
    
       
      }
    




   //FUNCIÓN QUE ABRE EL MODAL AL HACER DOBLE CLICK PARA CAMBIAR LA UBICACIÓN




</script>

@extends('layouts.userNavbar')

@section('content')
    <style>
        #map {
            width: 600px;
            height: 600px;
        }
    </style>
    <div class="container row">
        <div class="col-md-4 col-xs-12 mb-6">
            <h1 class="mt-5 ">Ubicación</h1>

            <div class="row mt-5">
                <div class="col-md-12" style="margin-left:-100px padding-left: 20px;">
                    <p id="address" class="h5"></p>
                    <p class="h5 mt-4"><i class="fa-solid fa-clock fa-xl me-2"></i> 12:30 a 15:25 - 16:30 a 20:30 </p>
                    <p class="h5 mt-4"><i class="fa-solid fa-calendar fa-xl "
                            style="margin-left: 2px; margin-right: 12px"></i> Lunes a Sábado </p>
                </div>
            </div>
        </div>

        <div class="col my-5 ms-5" id="map">
        </div>
    </div>
@endsection

@section('js_after')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcgeUpk1gzGnzb9t6SiJ6jtca5U-cRA5I&libraries=drawing&callback=initMap">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            initMap();
        });

        // Initialize and add the map
        function initMap() {


            $.ajax({

                type: "GET",
                url: "{{ route('getLocation') }}",
                dataType: "json",
                success: function(response) {

                    resultado = response;
                    console.log(response[0]);

                    // The location of Uluru
                    var latx = parseFloat(response[0].latitud);
                    var lngy = parseFloat(response[0].longitud);
                    const uluru = {
                        lat: latx,
                        lng: lngy
                    };
                    // The map, centered at Uluru
                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 15,
                        center: uluru,


                    });


                    const marker = new google.maps.Marker({
                        position: uluru,
                        map: map,
                    });

                    window.initMap = initMap;

                    $('#address').html(
                        `<i class="fa-solid fa-location-dot fa-xl me-3" style ="margin-left: 3px; margin-right: 10px"></i>${response[0].direccion}`
                        );

                }


            });



        }
    </script>
@endsection

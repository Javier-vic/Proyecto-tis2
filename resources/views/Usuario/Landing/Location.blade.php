@extends('layouts.userNavbar')

@section('content')
<style>
    #map {
  width: 400px;
  height: 300px;
}
</style>
    <div class="container row">
        <div class="col-6 mb-6">
            <h1 class="mt-5">Ubicación</h1>
            <p class="h4 mt-3">Chillan</p>

            <div class="row mt-4">
                <div class="col-1"><i class="fa-solid fa-location-dot fa-3x"></i></div>
                <div class="col-11 ms-0" style="margin-left:-100px padding-left: 20px;">
                    <p style="margin-bottom: 5px">callefalsa 123</p>
                    <p>Chillan, Chile</p>
                </div>
            </div>
        </div>
        <div class="col-6 my-5" id="map" >
        </div>
    </div>
 
    {{-- FOOTER --}}
    <div class="container">
        <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">
            <div class="col mb-3">
                <a href="/" class="d-flex align-items-center mb-3 link-dark text-decoration-none">
                    <img src="https://tolivmarket-production.s3.sa-east-1.amazonaws.com/companies/logos/8a17cb17fcb7d1012e47f83078ee24b603fd0fa1d9628ad486d5cb43bacbb81c.jpg"
                        alt="Ramen dashi" width="200" height="200">
                </a>
            </div>

            <div class="col mb-3">

            </div>

            <div class="col mb-3">
                <h5>Section</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                </ul>
            </div>

            <div class="col mb-3">
                <h5>Section</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                </ul>
            </div>

            <div class="col mb-3">
                <h5>Section</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                </ul>
            </div>
        </footer>
    </div>
    {{-- END FOOTER --}}
@endsection

@section('js_after')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcgeUpk1gzGnzb9t6SiJ6jtca5U-cRA5I&callback=initMap"></script>
   
   <script type="text/javascript">
        $(document).ready(function () {
           
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
                    const uluru = { lat: latx, lng: lngy };
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
                        
                    

                }
                
            
            });     
            
            

        }



    
        
    </script>
      
@endsection


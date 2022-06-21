<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ramendahi</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <style>
        .linkHover:hover {
            color: rgb(254, 0, 0) !important;

        }
        .linkActive{
            color: rgb(254, 0, 0) !important;
        }

        .buttonHover:hover {
            background: rgb(158, 0, 0) !important;
        }
        .buttonHover:focus {
            background: rgb(158, 0, 0) !important;
        }
        .agregarCarrito:hover {
            background: rgb(29, 114, 74) !important;
        }

        .agregarCarrito {
            background: rgb(31, 149, 94) !important;
        }

        .categoriaBackground:hover {
            background: #FFF !important;
            color: #000 !important;
        }

        .categoriaActive {
            outline: 2px solid rgb(255, 255, 255);
        }

        a.morelink {
            text-decoration: none;
            outline: none;
        }

        .morecontent span {
            display: none;
        }

        .comment {
            width: 100%;
            background-color: #ffffff;
            margin: 10px;
        }

        .bgColor {
            background-color: #FD1515;
        }

        .sticky-margin-top {
            top: 1rem !important;
        }
        .sticky-margin-bottom{
            bottom: 1rem !important;
        }
        .paymentMethodHover:hover{
            border: 1px solid #9a9a9a;
        }
        .paymentMethodBorder{
            border: 1px solid #3bda70;
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fs-5">
        <div class="container-lg container-fluid">
            <a class="navbar-brand d-none d-lg-block" href="#"><img
                    src="https://tolivmarket-production.s3.sa-east-1.amazonaws.com/companies/logos/8a17cb17fcb7d1012e47f83078ee24b603fd0fa1d9628ad486d5cb43bacbb81c.jpg"
                    alt="" width="75" height="75"></a>
            <button class="navbar-toggler bg-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <!-- <span class="navbar-toggler-icon"></span> -->
                <i class="fa-solid fa-ellipsis text-white"></i>
            </button>

            {{-- NAVBAR PARA CELULAR --}}
            <ul class="navbar-nav flex-row d-lg-none">
          
                @auth
                <div class="dropdown d-flex ms-3">
                    <button class="btn btn-secondary dropdown-toggle bgColor buttonHover fw-bold" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-circle-user me-2"></i>Mi cuenta
                    </button>
                    <ul class="dropdown-menu position-absolute " aria-labelledby="dropdownMenuButton1" >
                        <li class="nav-item mx-3 mt-3 ">
                            <a class="nav-link fw-bold ropdown-item d-inline d-lg-block linkHover d-flex align-self-center p-0 " aria-current="page" href="{{route('user.profile')}}"><i class="fa-solid fa-address-card me-2 fa-xl align-self-center"></i>Mi perfil</a>
                            <hr>
                        </li>
                        <li class="nav-item mx-3">

                        <a class=" nav-link fw-bold ropdown-item d-inline d-lg-block linkHover d-flex align-self-center p-0 mt-3 mb-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket me-2 align-self-center"></i>Cerrar sesion
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            class="d-none">
                            @csrf
                        </form>
                    </li>

                    </ul>
                  </div>
                @endauth
              @guest
            <li class="nav-item mx-3 shadow bg-white  rounded">
                <a class="nav-link fw-bold px-3 py-3 d-inline d-lg-block linkHover" aria-current="page" href="{{route('login')}}"><i
                        class="fa-solid fa-user me-2"></i>Ingresar</a>
            </li>
              @endguest
            
                <li class="nav-item mx-3 py-1">
                    <a class="nav-link fw-bold px-3  bgColor text-white d-inline d-lg-block buttonHover"
                        aria-current="page" href="/cart" onclick="checkCart(event)"><i class="fa-solid fa-cart-shopping"></i><span class="cartQuantity" ></span></a>

                </li>
            </ul>
            {{-- FIN NAVBAR CELULAR --}}
            {{-- CONTENIDO CENTRAL NAVBAR --}}
            <div class="collapse navbar-collapse justify-content-between shadow bg-white p-2 rounded mt-2"
                id="navbarNav">
                <ul class="navbar-nav p-1 ">
                    <li class="nav-item mx-3 ">
                        <a class="nav-link fw-bold linkHover {{ request()->is('/') ? ' linkActive' : '' }}" aria-current="page" href="/"><i
                                class="fa-solid fa-utensils me-2"></i>Menú</a>
                    </li>
                    <li class="nav-item mx-3 ">
                        <a class="nav-link fw-bold linkHover" aria-current="page" href="#"><i
                                class="fa-solid fa-house-chimney me-2"></i>Local</a>
                    </li>
                    <li class="nav-item mx-3 ">
                        <a class="nav-link fw-bold linkHover" aria-current="page" href="{{route('home')}}"><i class="fa-solid fa-chart-line me-2"></i>Administración</a>
                    </li>
                </ul>

            </div>
            {{-- FIN CONTENIDO CENTARL --}}
            {{-- NAVBAR PARA DESKTOP --}}
            <ul class="navbar-nav flex-row d-lg-flex d-none">        
                @auth
                <div class="dropdown d-flex ms-3">
                    <button class="btn btn-secondary dropdown-toggle bgColor buttonHover fw-bold fs-5 border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-circle-user me-2 fa-xl"></i> Mi cuenta
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li class="nav-item mx-3">
                            <a class="nav-link fw-bold ropdown-item d-inline d-lg-block linkHover d-flex align-self-center p-0 mt-3" aria-current="page" href="{{route('user.profile')}}"><i class="fa-solid fa-address-card me-2 fa-xl"></i>Mi perfil</a>
                            <hr>
                        </li>
                        <li class="nav-item mx-3">

                        <a class=" nav-link fw-bold ropdown-item d-inline d-lg-block linkHover d-flex align-self-center p-0 mt-3 mb-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket me-2"></i>Cerrar sesion
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            class="d-none">
                            @csrf
                        </form>
                    </li>

                    </ul>
                  </div>
          
                @endauth
              @guest
              <li class="nav-item mx-3 shadow bg-white  rounded">
                <a class="nav-link fw-bold px-3 py-3 d-inline d-lg-block linkHover" aria-current="page" href="{{route('login')}}"><i
                        class="fa-solid fa-user me-2"></i>Ingresar</a>
            </li>
              @endguest
            
                <li class="nav-item mx-3 ">
                    <div>
                        <a class="nav-link fw-bold px-4 py-3 bgColor text-white d-inline d-lg-block buttonHover rounded rounded-5"
                            aria-current="page" href="/cart" onclick="checkCart(event)"><i class="fa-solid fa-cart-shopping"></i><span class="cartQuantity" ></span></a>
                    </div>
                </li>
            </ul>
            {{-- FIN NAVBAR DESKTOP --}}
        </div>
    </nav>
    <div class="container-lg container-fluid">@yield('content')</div>
    <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top container mx-auto">
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
</body>
<script src="{{ asset('js/app.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('js_after')

<script>
const checkCart = (e) =>{
    e.preventDefault()
    
    let cartItem = localStorage.getItem('cart');
    cart = JSON.parse(cartItem);
    
    if(cart.length > 0){
        window.location.href = '/cart'
    }
    else{
        var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
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
            title: 'El carrito se encuentra vacío',
            icon: 'error'
        });
    }
}
const cartQuantity = () =>{
            var cart = localStorage.getItem('cart');
            cart = JSON.parse(cart);
            $('.cartQuantity').empty()
            $('.cartQuantity').append(`<span class="ms-2">${cart.length}</span>`)
            
        }
</script>
</html>

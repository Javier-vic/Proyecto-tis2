<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ramendashi</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .linkHover:hover {
            color: rgb(254, 0, 0) !important;

        }

        .linkActive {
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

        .sticky-margin-bottom {
            bottom: 1rem !important;
        }

        .paymentMethodHover:hover {
            border: 1px solid #9a9a9a;
        }

        .paymentMethodBorder {
            border: 1px solid #3bda70;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fs-5">
        <div class="container-lg container-fluid">
            <a class="navbar-brand d-none d-lg-block" href="/"><img
                    src="{{ asset('storage/files/Logo.png') }}"
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
                        <button class="btn btn-secondary dropdown-toggle bgColor buttonHover fw-bold" type="button"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-user me-2"></i>Mi cuenta
                        </button>
                        <ul class="dropdown-menu position-absolute " aria-labelledby="dropdownMenuButton1">
                            <li class="nav-item mx-3 mt-3 ">
                                <a class="nav-link fw-bold ropdown-item d-inline d-lg-block linkHover d-flex align-self-center p-0 "
                                    aria-current="page" href="{{ route('user.profile') }}"><i
                                        class="fa-solid fa-address-card me-2 fa-xl align-self-center"></i>Mi perfil</a>
                                <hr>
                            </li>
                            <li class="nav-item mx-3">
                                <a class=" nav-link fw-bold ropdown-item d-inline d-lg-block linkHover d-flex align-self-center p-0 mt-3 mb-3"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket me-2 align-self-center"></i>Cerrar sesion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                    </div>
                @endauth
                @guest
                    <li class="nav-item mx-3 shadow bg-white  rounded">
                        <a class="nav-link fw-bold px-3 py-3 d-inline d-lg-block linkHover" aria-current="page"
                            href="{{ route('login') }}"><i class="fa-solid fa-user me-2"></i>Ingresar</a>
                    </li>
                @endguest

                <li class="nav-item mx-3 py-1">
                    <a class="nav-link fw-bold px-3  bgColor text-white d-inline d-lg-block buttonHover"
                        aria-current="page" href="/landing/cart" onclick="checkCart(event)"><i
                            class="fa-solid fa-cart-shopping"></i><span class="cartQuantity"></span></a>
                </li>
            </ul>
            {{-- FIN NAVBAR CELULAR --}}
            {{-- CONTENIDO CENTRAL NAVBAR --}}
            <div class="collapse navbar-collapse justify-content-between shadow bg-white p-2 rounded mt-2"
                id="navbarNav">
                <ul class="navbar-nav p-1 ">
                    <li class="nav-item mx-3 ">
                        <a class="nav-link fw-bold linkHover {{ request()->is('/') ? ' linkActive' : '' }}"
                            aria-current="page" href="/"><i class="fa-solid fa-utensils me-2"></i>Menú</a>
                    </li>
                    <li class="nav-item mx-3 ">
                        <a class="nav-link fw-bold linkHover" aria-current="page" href="{{route('location')}}">
                            <i class="fa-solid fa-house-chimney me-2"></i>Local
                        </a>
                    </li>
                    <li class="nav-item mx-3 ">
                        <a class="nav-link fw-bold linkHover" aria-current="page" href="{{ route('order.find') }}">
                        <i class="fa-solid fa-truck-fast me-2"></i>Estado de mi pedido
                        </a>
                    </li>
                    @if (auth()->user())
                        <li class="nav-item mx-3 ">
                            <a class="nav-link fw-bold linkHover" aria-current="page"
                                href="{{ route('order.history') }}">
                                <i class="fa-solid fa-receipt me-2"></i>Mis pedidos
                            </a>
                        </li>
                    @endif
                    @auth
                        @if (auth()->user()->id_role != 2)
                            <li class="nav-item mx-3 ">
                                <a class="nav-link fw-bold linkHover" aria-current="page" href="{{ route('home') }}"><i
                                        class="fa-solid fa-chart-line me-2"></i>Funcionarios</a>
                            </li>
                        @endif
                    @endauth


                </ul>

            </div>
            {{-- FIN CONTENIDO CENTARL --}}
            {{-- NAVBAR PARA DESKTOP --}}
            <ul class="navbar-nav flex-row d-lg-flex d-none">
                @auth
                    <div class="dropdown d-flex ms-3">
                        <button class="btn btn-secondary dropdown-toggle bgColor buttonHover fw-bold fs-5 border-0"
                            type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-user me-2 fa-xl"></i> Mi cuenta
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="nav-item mx-3">
                                <a class="nav-link fw-bold ropdown-item d-inline d-lg-block linkHover d-flex align-self-center p-0 mt-3"
                                    aria-current="page" href="{{ route('user.profile') }}"><i
                                        class="fa-solid fa-address-card me-2 fa-xl"></i>Mi perfil</a>
                                <hr>
                            </li>
                            <li class="nav-item mx-3">

                                <a class=" nav-link fw-bold ropdown-item d-inline d-lg-block linkHover d-flex align-self-center p-0 mt-3 mb-3"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i>Cerrar sesion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                    </div>

                @endauth
                @guest
                    <li class="nav-item mx-3 shadow bg-white  rounded">
                        <a class="nav-link fw-bold px-3 py-3 d-inline d-lg-block linkHover" aria-current="page"
                            href="{{ route('login') }}"><i class="fa-solid fa-user me-2"></i>Ingresar</a>
                    </li>
                @endguest

                <li class="nav-item mx-3 ">
                    <div>
                        <a class="nav-link fw-bold px-4 py-3 bgColor text-white d-inline d-lg-block buttonHover rounded rounded-5"
                            aria-current="page" href="{{ route('user.cart') }}" onclick="checkCart(event)"><i
                                class="fa-solid fa-cart-shopping"></i><span class="cartQuantity"></span></a>
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
                <img src="{{ asset('storage/files/Logo.png') }}"
                    alt="Ramen dashi" width="200" height="200">
            </a>
        </div>

        <div class="col mb-3">

        </div>
        <div class="col mb-3">
            {{--
            <h5>Section</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
            </ul>
            --}}
        </div>
        <div class="col mb-3">
            <h5 class="fw-bold">Mi cuenta</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="/login" class="nav-link p-0 text-muted">Ingresar</a></li>
                <li class="nav-item mb-2"><a href="/user" class="nav-link p-0 text-muted">Regístrate</a></li>
                <li class="nav-item mb-2"><a href="/password/reset" class="nav-link p-0 text-muted">Recuperar contraseña</a></li>
            </ul>
        </div>

        <div class="col mb-3">
            <h5 class="fw-bold">Contacto</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="https://goo.gl/maps/eLq4QGrxErDtgjUm8" target="_blank" class="nav-link p-0 text-muted">Purén 596, Chillán</a></li>
                <li class="nav-item mb-2 d-flex">
                    <a href="https://www.facebook.com/ramen.dashi.cl" class="nav-link p-0 text-muted" target="_blank"><i class="ri-facebook-circle-fill fs-1"></i></a>
                    <a href="https://www.instagram.com/ramen.dashi" target="_blank" class="nav-link p-0 text-muted ms-2"><i class="ri-instagram-fill fs-1"></i></a>
                    <a href="https://wa.me/56937785214" target="_blank" class="nav-link p-0 text-muted ms-2"><i class="ri-whatsapp-fill fs-1"></i></a>
                </li>
            </ul>
        </div>
    </footer>
</body>
<script src="{{ asset('js/app.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('js_after')

<script>
    const checkCart = (e) => {
        e.preventDefault()

        let cartItem = localStorage.getItem('cart');
        cart = JSON.parse(cartItem);

        if (cart.length > 0) {
            window.location.href = '/landing/cart'
        } else {
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
    const cartQuantity = () => {
        var cart = localStorage.getItem('cart');
        cart = JSON.parse(cart);
        $('.cartQuantity').empty()
        $('.cartQuantity').append(`<span class="ms-2">${cart.length}</span>`)

    }
</script>

</html>

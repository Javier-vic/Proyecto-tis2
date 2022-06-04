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

        .buttonHover:hover {
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
            background-color: #f0f0f0;
            margin: 10px;
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fs-5">
        <div class="container-lg container-fluid">
            <a class="navbar-brand d-none d-lg-block" href="#"><img
                    src="https://tolivmarket-production.s3.sa-east-1.amazonaws.com/companies/logos/8a17cb17fcb7d1012e47f83078ee24b603fd0fa1d9628ad486d5cb43bacbb81c.jpg"
                    alt="" width="75" height="75"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between bg-secondary p-2 bg-opacity-10 rounded "
                id="navbarNav">
                <ul class="navbar-nav p-1 ">
                    <li class="nav-item mx-3 ">
                        <a class="nav-link fw-bold linkHover" aria-current="page" href="#"><i
                                class="fa-solid fa-utensils me-2"></i>Menú</a>
                    </li>
                    <li class="nav-item mx-3 ">
                        <a class="nav-link fw-bold linkHover" aria-current="page" href="#"><i
                                class="fa-solid fa-house-chimney me-2"></i>Local</a>
                    </li>
                </ul>

            </div>
            <ul class="navbar-nav flex-row ">
                <li class="nav-item mx-3">
                    <a class="nav-link fw-bold px-3 d-inline d-lg-block linkHover" aria-current="page" href="#"><i
                            class="fa-solid fa-user me-2"></i>Ingresar</a>
                </li>
                <li class="nav-item mx-3 ">
                    <a class="nav-link fw-bold px-3  bg-danger text-white d-inline d-lg-block buttonHover"
                        aria-current="page" href="#"><i class="fa-solid fa-cart-shopping"></i></a>

                </li>
            </ul>

        </div>
    </nav>
    <div class="container-lg container-fluid">@yield('content')</div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
@yield('js_after')

</html>

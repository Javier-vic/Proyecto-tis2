<!DOCTYPE html>
<html lang="es">
@php
    use App\Http\Controllers\RoleController;    
@endphp
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    @yield('css_extra')
</head>
@if (RoleController::havePermits(auth()->user()->id_role,1))
    
@endif
<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>{{auth()->user()->name}}</h3>
            </div>

            <ul class="list-unstyled ">
                @if (RoleController::havePermits(auth()->user()->id_role,2))
                    <li class="">
                        <a href="#" class="my-3"><i class="me-3 fa-solid fa-box-open"></i>Insumos</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,1))
                    <li>
                        <a href="#" class="my-3" ><i class="me-3 fa-solid fa-envelope"></i>Publicidad</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,3))
                    <li>
                        <a href="#" class="my-3"><i class="me-3 fa-solid fa-sack-dollar"></i>Ventas</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,1))    
                    <li>
                        <a href="{{route('product.index')}}" ><i class="me-3 fa-solid fa-list-ul"></i>Productos</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,4))
                    <li>
                        <a href="#" class="my-3"><i class="me-3 fa-solid fa-truck"></i>Delivery</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,5))
                    <li>
                        <a href="#" class="my-3"><i class="me-3 fa-solid fa-people-group"></i>Trabajadores</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,7))
                    <li>
                        <a href="{{route('roles.index')}}" class="my-3"><i class="me-3 fa-solid fa-people-group"></i>Roles</a>
                    </li>
                @endif
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-toggle-color">
                        <i class="fas fa-align-left"></i>
                    </button>
                 

    
                </div>
            </nav>

            @yield('content')

        </div>
    </div>
</body>

<script src="{{ asset('js/app.js') }}"></script>
@yield('js_after')

<script>
    $(document).ready(function() {
        $("#sidebarCollapse").on("click", function() {
            $("#sidebar").toggleClass("active");
        });
    });
</script>

</html>

<!DOCTYPE html>
<html lang="es">
@php
    use App\Http\Controllers\RoleController;    
@endphp
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Ramen Dashi</title>

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
                    <li>
                        <a href="#submenuSupply" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle mt-3{{ request()->is('supply','category_supply') ? ' active' : '' }}" ><i class="me-3 fa-solid fa-box-open"></i>Insumos <i class="fa-solid fa-caret-down "></i></a>    
                        <ul class="collapse list-unstyled" id="submenuSupply">
                            <li>
                                <a href="{{route('supply.index')}}" >Listado insumos</a>

                            </li>
                            <li>
                                <a href="{{route('category_supply.index')}}">Categorías</a>
                            </li>
        
                        </ul>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,1))
                    <li>
                        <a href="{{route('publicity.index')}}" class="my-3 {{ request()->is('publicity','publicityorder/*') ? ' active' : '' }}" ><i class="me-3 fa-solid fa-envelope"></i>Publicidad</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,3))
                    <li>
                        <a href="{{route('order.index')}}" class="my-3 {{ request()->is('order','order/*') ? ' active' : '' }}"><i class="me-3 fa-solid fa-sack-dollar"></i>Ventas</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,6))
                    <li>
                        <a href="{{route('asist.index')}}" class="my-3 {{ request()->is('asist','asist/*') ? ' active' : '' }}"><i class="me-3 fa-solid fa-business-time "></i>Asistencia</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,7))    
                    <li>
                        <a href="#submenuCategoryProducts" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle mt-3 {{ request()->is('product','category_product') ? ' active' : '' }}" ><i class="me-3 fa-solid fa-list-ul"></i>Productos <i class="fa-solid fa-caret-down "></i></a>    
                        <ul class="collapse list-unstyled" id="submenuCategoryProducts">
                            <li>
                                <a href="{{route('product.index')}}" >Listado productos</a>

                            </li>
                            <li>
                                <a href="{{route('category_product.index')}}">Categorías</a>
                            </li>
        
                        </ul>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,4))
                    <li>
                        <a href="#" class="my-3" hidden><i class="me-3 fa-solid fa-truck"></i>Delivery</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,5))
                    <li>
                        <a href="#submenuTrabajadores" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle mt-3{{ request()->is('worker','roles') ? ' active' : '' }}" ><i class="me-3 fa-solid fa-people-group"></i>Trabajadores <i class="fa-solid fa-caret-down "></i></a>    
                        <ul class="collapse list-unstyled" id="submenuTrabajadores">
                            <li>
                                <a href="{{route('worker.index')}}" >Listado de trabajadores</a>

                            </li>
                            @if (RoleController::havePermits(auth()->user()->id_role,8))
                                <li>
                                    <a href="{{route('roles.index')}}" >Roles</a>
                                </li>
                            @endif
        
                        </ul>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,9))    
                    <li>
                        <a href="{{route('coupon.index')}}" class="my-3 {{ request()->is('coupon') ? ' active' : '' }}"><i class="me-3 fa-solid fa-tag"></i>Cupones</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role,10))
                    <li>
                        <a href="{{route('map.index')}}" class="my-3 {{ request()->is('map') ? ' active' : '' }}"><i class="me-3 fa-solid fa-location-dot"></i>Local</a>
                    </li>
                @endif
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light row">
                <div class="col d-flex justify-content-between">
                    <div col-3  >
                        <button type="button" id="sidebarCollapse" class="btn btn-toggle-color">
                            <i class="fas fa-align-left text-white"></i>
                        </button>
                    </div>  
                    <div class="d-none d-sm-block col text-center">@yield('titlePage')</div>
                    <!-- Notificaciones -->
                    <div class="dropdown mx-3 text-center col-lg-1">
                        <button type="button" class="btn btn-light position-relative border dropdown-toggle" id="Notificaciones" data-bs-toggle="dropdown" aria-expanded="false"> 
                            <i class="fa-solid fa-bell fs-3"></i>                        
                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">New alerts</span>
                            </span>                          
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="Notificaciones">
                        
 
                        

                            <li>
                                <i class="fa-solid fa-circle-exclamation text-danger fs-3"></i>
                                <div class="d-inline-block">
                                    <span class="text-danger">Insumo en cero</span>
                                </div>
                            </li>
                            <li>
                                <i class="fa-solid fa-triangle-exclamation text-warning fs-3"></i>
                                <div class="d-inline-block">
                                    <span class="text-warning">Insumo en cero</span>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <a class="btn btn-danger align-self-center   w-auto " href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar sesion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                        class="d-none">
                        @csrf
                    </form>
                </div>
            </nav>
            @yield('content')
        </div>
    </div>
</body>

<script src="{{ asset('js/app.js') }}"></script>

@yield('js_after')

<script>
    
        $("#sidebarCollapse").on("click", function() {
            $("#sidebar").toggleClass("active");
        });


</script>

</html>

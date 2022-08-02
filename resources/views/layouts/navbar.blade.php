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
@if (RoleController::havePermits(auth()->user()->id_role, 1))
@endif

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header d-flex justify-content-between">
                <h3 class="m-0 p-0">{{ auth()->user()->name }}</h3>
                <a href="{{ route('landing.index') }}" class="m-0 p-0" style="height:50px;width:50px;"><img
                        src="{{ asset('storage/files/Logo.png') }}" alt="" class="img-fluid "></a>
            </div>

            <ul class="list-unstyled ">

                <li>
                    <a href="{{ route('home') }}" class="my-3 {{ request()->is('home', 'home/*') ? ' active' : '' }}"><i
                            class="me-3 fa-solid fa-chart-line"></i></i>Dashboard</a>
                </li>
                @if (RoleController::havePermits(auth()->user()->id_role, 2))
                    <li>
                        <a href="#submenuSupply" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle mt-3{{ request()->is('supply', 'category_supply', 'supply/*') ? ' active' : '' }}"><i
                                class="me-3 fa-solid fa-box-open"></i>Insumos <i
                                class="fa-solid fa-caret-down "></i></a>
                        <ul class="collapse list-unstyled" id="submenuSupply">
                            <li>
                                <a href="{{ route('supply.index') }}">Listado insumos</a>

                            </li>
                            <li>
                                <a href="{{ route('category_supply.index') }}">Categorías</a>
                            </li>

                        </ul>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role, 1))
                    <li>
                        <a href="{{ route('publicity.index') }}"
                            class="my-3 {{ request()->is('publicity', 'publicityorder/*') ? ' active' : '' }}"><i
                                class="me-3 fa-solid fa-envelope"></i>Publicidad</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role, 3))
                    <li>
                        <a href="#submenuOrders" data-bs-toggle="collapse" aria-expanded="false"
                            class="mt-3 dropdown-toggle {{ request()->is('order', 'order/*') ? ' active' : '' }}">
                            <i class="me-3 fa-solid fa-sack-dollar"></i>Ventas <i class="fa-solid fa-caret-down"></i>
                        </a>
                        <ul class="collapse list-unstyled" id="submenuOrders">
                            <li><a href="{{ route('order.index') }}">Listado de ventas</a></li>
                            <li><a href="{{ route('pendingOrdersView') }}">Ventas pendientes</a></li>
                            <li><a href="{{ route('readyOrdersView') }}">Ventas listas</a></li>
                        </ul>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role, 6))
                    <li>
                        <a href="{{ route('asist.index') }}"
                            class="my-3 {{ request()->is('asist', 'asist/*') ? ' active' : '' }}"><i
                                class="me-3 fa-solid fa-business-time "></i>Asistencia</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role, 7))
                    <li>
                        <a href="#submenuCategoryProducts" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle mt-3 {{ request()->is('product', 'category_product') ? ' active' : '' }}"><i
                                class="me-3 fa-solid fa-list-ul"></i>Productos <i
                                class="fa-solid fa-caret-down "></i></a>
                        <ul class="collapse list-unstyled" id="submenuCategoryProducts">
                            <li><a href="{{ route('product.index') }}">Listado productos</a></li>
                            <li><a href="{{ route('category_product.index') }}">Categorías</a></li>
                        </ul>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role, 4))
                    <li>
                        <a href="#" class="my-3" hidden><i class="me-3 fa-solid fa-truck"></i>Delivery</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role, 5))
                    <li>
                        <a href="#submenuTrabajadores" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle mt-3{{ request()->is('worker', 'roles') ? ' active' : '' }}"><i
                                class="me-3 fa-solid fa-people-group"></i>Trabajadores <i
                                class="fa-solid fa-caret-down "></i></a>
                        <ul class="collapse list-unstyled" id="submenuTrabajadores">
                            <li>
                                <a href="{{ route('worker.index') }}">Listado de trabajadores</a>

                            </li>
                            @if (RoleController::havePermits(auth()->user()->id_role, 8))
                                <li>
                                    <a href="{{ route('roles.index') }}">Roles</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role, 9))
                    <li>
                        <a href="{{ route('coupon.index') }}"
                            class="my-3 {{ request()->is('coupon') ? ' active' : '' }}"><i
                                class="me-3 fa-solid fa-tag"></i>Cupones</a>
                    </li>
                @endif
                @if (RoleController::havePermits(auth()->user()->id_role, 10))
                    <li>

                    </li>
                    <li>
                        <a href="#subMenuMap" data-bs-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle mt-3 {{ request()->is('map', 'map/*') ? ' active' : '' }}"><i
                                class="me-3 fa-solid fa-location-dot"></i>Local <i
                                class="fa-solid fa-caret-down "></i></a>
                        <ul class="collapse list-unstyled" id="subMenuMap">
                            <a href="{{ route('map.index') }}">Ubicación</a>
                            <li><a href="{{ route('map.status') }}">Horarios atención</a></li>
                        </ul>
                    </li>
                @endif

            </ul>
        </nav>
        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light row">
                <div class="col d-flex justify-content-between">
                    <div col-3>
                        <button type="button" id="sidebarCollapse" class="btn btn-toggle-color">
                            <i class="fas fa-align-left text-white"></i>
                        </button>
                    </div>
                    <div class="d-none d-sm-block col text-center">@yield('titlePage')</div>

                    <!-- Notificaciones -->
                    <div class="dropdown mx-3 text-center col-lg-1">
                        <button type="button" class="btn btn-light position-relative border dropdown-toggle"
                            id="Notificaciones" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-bell fs-3"></i>
                            <span
                                class="badge-notification position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light badge rounded-pill fs-6">
                                <div class="" id="countsupplies"></div>
                            </span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="Notificaciones">
                            <div id="missing_supply"></div>
                            <div id="critical_supply"></div>
                        </ul>
                    </div>

                    <a class="btn btn-danger align-self-center   w-auto " href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar sesion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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

<script>
    if (@json(RoleController::havePermits(auth()->user()->id_role, 2))) {
        //supply
        $.ajax({
                    type: "GET",
                    url: "{{ route('supplyNotification') }}",
                    data: "json",
                    success: function(response) {
                            if (response.countSupplies[0].countsupplies == 0) {
                                $(".badge-notification").addClass('d-none')
                            }
                            $('#countsupplies').text(response.countSupplies[0].countsupplies);
                            $('#critical_supply').empty();
                            response.criticalSupplies.map(supplies => {
                                        $('#critical_supply').append(
                                                `

    if (@json(RoleController::havePermits(auth()->user()->id_role, 2))) {
        $.ajax({
            type: "GET",
            url: "{{ route('supplyNotification') }}",
            data: "json",
            success: function(response) {
                if (response.countSupplies[0].countsupplies == 0) {
                    $(".badge-notification").addClass('d-none')
                }
                $('#countsupplies').text(response.countSupplies[0].countsupplies);
                $('#critical_supply').empty();
                response.criticalSupplies.map(supplies => {
                    $('#critical_supply').append(
                        ` >>>
                                                >>>
                                                >
                                                Stashed changes <
                                                li class = "dropdown-item" >
                                                <
                                                i class =
                                                "fa-solid fa-triangle-exclamation text-warning fs-3 d-inline-block" > <
                                                /i> <
                                                div class = "d-inline-block" >
                                                <
                                                a href = "/supply" >
                                                <
                                                span class = "text-warning" > $ {
                                                    supplies.name_supply
                                                }
                                                en cantidad critica < /span> < /
                                                a > <
                                                /div> < /
                                                li >

                                                `

                    )
                })
                $('#missing_supply').empty();
                response.missingSupplies.map(supplies => {
                    $('#missing_supply').append(
                        ` <
                                                li class = "dropdown-item" >
                                                <
                                                i class =
                                                "d-inline-block fa-solid fa-circle-exclamation text-danger fs-3" > <
                                                /i> <
                                                div class = "d-inline-block" >
                                                <
                                                a href = "/supply" >
                                                <
                                                span class = "text-danger aa" > $ {
                                                    supplies.name_supply
                                                }
                                                en cero < /span> < /
                                                a > <
                                                /div> < /
                                                li >
                                                `

                    )
                })
            }
        });
    }
</script>

</html>

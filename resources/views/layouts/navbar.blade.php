<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>RamenDashi</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    @yield('css_extra')




</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Nombre admin</h3>
            </div>

            <ul class="list-unstyled ">
                <li class="">
                    <a href="#" class="my-3"><i class="me-3 fa-solid fa-box-open"></i>Insumos</a>
                </li>
                <li>
                    <a href="#" class="my-3" ><i class="me-3 fa-solid fa-envelope"></i>Publicidad</a>
                </li>
                <li>
                    <a href="#" class="my-3"><i class="me-3 fa-solid fa-sack-dollar"></i>Ventas</a>
                </li>
                <li>
                    <a href="#submenuCategoryProducts" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="me-3 fa-solid fa-list-ul"></i>Productos</a>    
                    <ul class="collapse list-unstyled" id="submenuCategoryProducts">
                        <li>
                            <a href="{{route('product.index')}}" >Listado productos</a>

                        </li>
                        <li>
                            <a href="{{route('category_product.index')}}">Categorías</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="my-3"><i class="me-3 fa-solid fa-truck"></i>Delivery</a>
                </li>
                <li>
                    <a href="#" class="my-3"><i class="me-3 fa-solid fa-people-group"></i>Trabajadores</a>
                </li>
              
                <li>
                    <a href="#pageSubmenu2" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu2">
                        <li>
                            <a href="#">Page 1</a>
                        </li>
                        <li>
                            <a href="#">Page 2</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li>
                    </ul>
                </li>

        
     
            </ul>


        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-toggle-color">
                        <i class="fas fa-align-left text-white"></i>
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

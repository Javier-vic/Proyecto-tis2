@extends('layouts.userNavbar')

@section('content')
    <div>
        <div id="carouselExampleIndicators" class="carousel slide bg-dark" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($imagesMain as $key => $image)
                    @if ($key == 0)
                        <button type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide-to="{{ $key }}" class="active" aria-current="true"
                            aria-label="Slide {{ $key }}"></button>
                    @else
                        <button type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide-to="{{ $key }}" aria-current="true"
                            aria-label="Slide {{ $key }}"></button>
                    @endif
                @endforeach
            </div>
            <div class="carousel-inner object-fit-cover " style="max-width: 100%; max-height:600px;">
                <div class="carousel-inner object-fit-cover " style="max-width: 100%; max-height:600px;">
                    @foreach ($imagesMain as $key => $image)
                        @if ($key == 0)
                            <div class="carousel-item active" data-bs-interval="3000">
                                <img src="{{ asset('storage') . '/' . $image->route }}" class="d-block w-100"
                                    alt="..." style="width: 100%; height:100%; max-height:600px;">
                            </div>
                        @else
                            <div class="carousel-item " data-bs-interval="3000">
                                <img src="{{ asset('storage') . '/' . $image->route }}" class="d-block w-100"
                                    alt="..." style="width: 100%; height:100%; max-height:600px;">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="mt-5 p-0">
        <div class="input-group ">
            <span class="btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" name="search" id="search" onkeyup="searchFilter(event)" class="form-control"
                placeholder="Ingrese el nombre de algún producto...">
        </div>
    </div>
    <div class="d-flex mt-2">
        <div class="col-12 col-md-8 col-xl-9 me-5 ">
            <div>

                <div>
                    <div id="productsContainer">
                        {{-- CATEGORÍAS DE LOS PRODUCTOS --}}
                        <div
                            class=" bgColor p-2 d-flex py-3 rounded rounded-4 overflow-auto sticky-top align-items-center ">
                            {{-- AGREGA LOS MÁS VENDIDOS AL NAVBAR ( EN CASO DE EXISTIR ) --}}
                            @if (sizeof($bestSellers) > 0)
                                <div class="text-white masvendidoIndicator">
                                    <a href="#{{ str_replace(' ', '', 'masVendido') }}"
                                        id="{{ str_replace(' ', '', 'masVendido') }}Navbar"
                                        class="text-decoration-none text-white categoriaBackground py-1 px-3 rounded-pill mx-1 "
                                        style="white-space: nowrap">{{ 'Más vendidos' }}</a>
                                </div>
                            @endif
                            @foreach ($category_products as $category_product)
                                @if (in_array($category_product->name, $categoryAvailableNames))
                                    <div class="text-white {{ strtolower($category_product->name) }}Indicator">
                                        <a href="#{{ str_replace(' ', '', $category_product->name) }}"
                                            id="{{ str_replace(' ', '', $category_product->name) }}Navbar"
                                            class="text-decoration-none text-white categoriaBackground py-1 px-3 rounded-pill mx-1 "
                                            style="white-space: nowrap">{{ $category_product->name }}</a>
                                    </div>
                                @else
                                    <div class="text-white">
                                        <a class="text-decoration-none text-white categoriaBackground py-1 px-3 rounded-pill mx-1 text-decoration-line-through user-select-none"
                                            style="white-space: nowrap;cursor: pointer;">{{ $category_product->name }}</a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        {{-- MÁS VENDIDOS --}}
                        {{-- MÁS VENDIDOS --}}
                        @if (sizeof($bestSellers) > 0)
                            <div>
                                <h2 id="{{ str_replace(' ', '', 'masVendido') }}"
                                    class="mb-5 invisible intersectionObserver masvendidoIndicator">a
                                </h2>
                                <h2 id="" class="mb-4 masvendidoIndicator">Más vendidos</h2>
                                <div class="my-2 row ">
                                    @foreach ($bestSellers as $bestSeller)
                                        <div class="col-12 col-sm-6  col-xl-4 mb-3 p-1 masvendidoIndicator">
                                            <div class="bg-image hover-overlay ripple text-center"
                                                data-mdb-ripple-color="light">
                                                @if ($bestSeller->stock > 0)
                                                    <img src="{{ asset('storage') . '/' . $bestSeller->image_product }}"
                                                        class="img-fluid rounded object-fit-cover "
                                                        style="height: 239px;object-fit: cover;" />
                                                @else
                                                    <img src="{{ asset('storage') . '/' . $bestSeller->image_product }}"
                                                        class="img-fluid rounded object-fit-cover opacity-50"
                                                        style="height: 239px;object-fit: cover;" />
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between position-relative bg-white rounded px-2 pt-1 shadow border mb-3"
                                                    style="margin-top:-30px;">
                                                    <h5 class="card-title font-weight-bold">
                                                        <a>{{ $bestSeller->name_product }}</a>
                                                    </h5>
                                                    <p class="mb-2 text-success font-weight-bold">$
                                                        {{ $bestSeller->price }}</p>
                                                </div>
                                                <p class="card-text comment more" style="min-height: 70px;">
                                                    {{ $bestSeller->description }}
                                                </p>
                                                @if ($bestSeller->stock > 0)
                                                    <a onclick="saveInCart({{ $bestSeller->id }})"
                                                        class="btn w-100 bg-success text-white text-decoration-none agregarCarrito"><i
                                                            class="fa-solid fa-plus me-1"></i>
                                                        Agregar al carrito</a>
                                                @else
                                                    <a
                                                        class="btn w-100 bg-secondary text-white text-decoration-none disabled"><i
                                                            class="fa-solid fa-x me-1"></i>
                                                        PRODUCTO AGOTADO</a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr class="masvendidoIndicator">
                            </div>
                        @endif
                        {{-- PRODUCTOS --}}
                        @foreach ($categoryAvailable as $category)
                            <h2 id="{{ str_replace(' ', '', $category->name) }}"
                                class="mb-5 invisible intersectionObserver {{ strtolower($category->name) }}Indicator">
                                a
                            </h2>
                            <div>
                                <h2 class="categoryName mb-4 {{ strtolower($category->name) }}Indicator"
                                    id="{{ $category->name }}Nombre">
                                    {{ $category->name }}
                                </h2>
                                <section>
                                    <div class="my-2 row ">
                                        @foreach ($productAvailable as $product)
                                            @if ($product->category_id == $category->id)
                                                <div
                                                    class="col-12 col-sm-6  col-xl-4 mb-3 p-1 {{ strtolower($product->name_product) }}">
                                                    <div class="bg-image hover-overlay ripple text-center"
                                                        data-mdb-ripple-color="light">
                                                        @if ($product->stock > 0)
                                                            <img src="{{ asset('storage') . '/' . $product->image_product }}"
                                                                class="img-fluid rounded object-fit-cover "
                                                                style="height: 239px;object-fit: cover;" />
                                                        @else
                                                            <img src="{{ asset('storage') . '/' . $product->image_product }}"
                                                                class="img-fluid rounded object-fit-cover opacity-50"
                                                                style="height: 239px;object-fit: cover;" />
                                                        @endif
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between position-relative bg-white rounded px-2 pt-1 shadow border mb-3"
                                                            style="margin-top:-30px;">
                                                            <h5 class="card-title font-weight-bold">
                                                                <a
                                                                    class="productsNames text-dark text-decoration-none ">{{ $product->name_product }}</a>
                                                            </h5>
                                                            <p class="mb-2 text-success font-weight-bold">$
                                                                {{ $product->price }}</p>
                                                        </div>
                                                        <p class="card-text comment more" style="min-height: 70px;">
                                                            {{ $product->description }}
                                                        </p>
                                                        @if ($product->stock > 0)
                                                            <a onclick="saveInCart({{ $product->id }})"
                                                                class="btn w-100 bg-success text-white text-decoration-none agregarCarrito"><i
                                                                    class="fa-solid fa-plus me-1"></i>
                                                                Agregar al carrito</a>
                                                        @else
                                                            <a
                                                                class="btn w-100 bg-secondary text-white text-decoration-none disabled"><i
                                                                    class="fa-solid fa-x me-1"></i>
                                                                PRODUCTO AGOTADO</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </section>
                                <hr class="{{ strtolower($category->name) }}Indicator">
                            </div>
                        @endforeach
                    </div>
                    <div class=" d-md-none text-end sticky-margin-bottom" style="position: sticky;bottom: 0; ">
                        <a href="/cart" onclick="checkCart(event)"
                            class="btn bgColor text-white align-left shadow rounded-circle py-4 px-4 ">
                            <h4 class="m-0"><i class="fa-solid fa-basket-shopping "></i><span
                                    class="cartQuantity"></span></h4>
                        </a>
                    </div>
                    {{-- FIN PRODUCTOS --}}
                </div>
            </div>

        </div>

        {{-- TÚ PEDIDO --}}
        {{-- <div class="border border-danger border-3 py-3 px-1 align-self-start sticky-top d-none d-xl-block"> --}}
        <div class=" py-3 px-1 align-self-start sticky-top d-none d-md-block rounded sticky-margin-top shadow"
            style="width: -webkit-fill-available; z-index:0;">
            <div class="row text-center py-2 px-2 m-0 mb-3 " id="continuePayment">


            </div>
            <div class="rounded text-center">
                <h5 class="text-dark  mx-auto">Tu pedido</h5>
                <hr class="bg-dark">
            </div>
            {{-- CONTENIDO CÚANDO SE ENCUENTRA VACÍO --}}

            {{-- END CONTENIDO VACÍO --}}
            {{-- PRODUCTOS AGREGADOS --}}
            <div id="cart" class="py-4" style="overflow-y: auto; max-height:600px;">
                <div class="text-white mx-3 px-2">
                    <img src="https://cdn.picpng.com/fork/silverware-plate-fork-spoon-52667.png" alt=""
                        class="img-fluid opacity-50 mb-2" width="500" height="350">
                    <p class="text-muted m-0">Aún no has seleccionado ningún producto.</p>
                    <p class="text-muted m-0">Selecciona alguno y comienza a disfrutar !</p>
                </div>
                {{-- OBJETO DE EJEMPLO EN EL CARRO DE COMPRAS --}}
                {{-- <div class="mx-3 px-2">
                    <div class="d-flex justify-content-between mb-3 flex-column flex-lg-row">
                        <h4 class="text-dark ">Korukushi</h4>
                        <div class="d-flex gap-2 align-items-center ">
                            <a href="#"><i class="fa-solid fa-plus"></i></a>
                            <span>1</span>
                            <a href="#"><i class="fa-solid fa-minus text-danger"></i></a>
                        </div>
                    </div>
                    <p class="text-muted ">Pescado chino, arroz , korugumi , limón y sal.</p>
                    <div class="text-end">
                        <p class="text-success fs-5 ">$ 2500</p>
                    </div>
                    <hr>
                </div> --}}
            </div>


        </div>
    </div>
    {{--  --}}
    {{-- END TÚ PEDIDO --}}
    </div>

@endsection

@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if (localStorage.getItem('cart').length > 0) return;
            else {
                localStorage.setItem('cart', JSON.stringify([]));
            }
        });
        const categoryAvailable = @json($categoryAvailable);
        const productsAvailable = @json($productAvailable);
        const bestSellers = @json($bestSellers);
        const searchFilter = (e) => {
            input = e.target.value
            filter = input.toLowerCase();
            listOfNames = $('.productsNames')

            let listOfCategorys = []


            //Esconder a más vendidos en caso que haya una busqueda
            if (input.length > 0) {
                $('.masvendidoIndicator').addClass('d-none')
            } else {
                $('.masvendidoIndicator').removeClass('d-none')

            }

            categoryAvailable.map(category => {
                listOfCategorys.push(category.name.toLowerCase())
            })
            for (let i = 0; i < listOfNames.length; i++) {
                name = listOfNames[i].innerText.toLowerCase()
                if (name.indexOf(filter) > -1) {

                    listOfCategorys.map(category => {
                        $(`.${category}Indicator`).removeClass('d-none')
                    })
                    $(`.${name}`).removeClass('d-none')
                    productsAvailable.map(product => {
                        if (product.name_product.toLowerCase() === name) {
                            if (listOfCategorys.includes(product.category.toLowerCase())) {
                                const index = listOfCategorys.indexOf(product.category.toLowerCase());
                                if (index > -1) {
                                    listOfCategorys.splice(index,
                                        1);
                                }
                            }
                        }
                    })
                    listOfCategorys.map(category => {
                        $(`.${category}Indicator`).addClass('d-none')
                    })

                } else {
                    $(`.${name}`).addClass('d-none')
                    listOfCategorys.map(category => {
                        $(`.${category}Indicator`).addClass('d-none')
                    })

                }

            }





        }

        const deleteInCart = (id) => {
            var cart = localStorage.getItem('cart');
            cart = JSON.parse(cart);
            cart.map(e => {
                if (e.id == id) {
                    e.cantidad--;
                    if (e.cantidad == 0) {
                        cart = cart.filter((el) => el.id != e.id);
                    }
                }
            })
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
        const renderCart = () => {
            var cart = localStorage.getItem('cart');
            if (cart.length <= 0) return;
            else cart = JSON.parse(cart);

            if (cart.length <= 0) {
                $("#cart").empty();
                // LE PONE NÚMERO AL LADO DEL ICONO DEL CARRITO CON LA CANTIDAD DE PRODUCTOS
                cartQuantity()

                //////////////////////////////////////////////// 
                $('#cart').append(
                    `
                <div id="cart" class="py-4">
                    <div class="text-white mx-3 px-2">
                        <img src="https://cdn.picpng.com/fork/silverware-plate-fork-spoon-52667.png" alt=""
                            class="img-fluid opacity-50 mb-2" height="350">
                        <p class="text-muted m-0">Aún no has seleccionado ningún producto.</p>
                        <p class="text-muted m-0">Selecciona alguno y comienza a disfrutar !</p>
                    </div>`
                )
            } else {
                $("#cart").empty();
                // LE PONE NÚMERO AL LADO DEL ICONO DEL CARRITO CON LA CANTIDAD DE PRODUCTOS
                cartQuantity()

                //////////////////////////////////////////////// 
                cart = cart.map(e => {
                    $("#cart").append(
                        $('<div>', {
                            class: 'mx-3 px-2',
                        }).append(
                            //
                            $('<div>', {
                                class: 'd-flex justify-content-between mb-3  flex-column'
                            }).append(
                                $('<h4>', {
                                    text: `${e.name_product}`,
                                    class: 'text-dark'
                                }),
                                $('<div>', {
                                    class: 'd-flex gap-2 align-items-center'
                                }).append(
                                    $('<a>', {
                                        style: 'color: #0d6efd; cursor: pointer;',
                                        onclick: `saveInCart(${e.id})`
                                    }).append(
                                        $('<i>', {
                                            class: 'fa-solid fa-circle-plus fa-xl text-success'
                                        })
                                    ),
                                    $('<span>', {
                                        text: `${e.cantidad}`
                                    }),
                                    $('<a>', {
                                        style: 'cursor: pointer;',
                                        onclick: `deleteInCart(${e.id})`
                                    }).append(
                                        $('<i>', {
                                            class: 'fa-solid fa-circle-minus text-danger fa-xl'
                                        })
                                    )
                                )
                            ),
                            //
                            $('<p>', {
                                class: 'text-muted',
                                text: `${e.description}`
                            }),
                            //
                            $('<div>', {
                                class: 'text-end'
                            }).append(
                                $('<p>', {
                                    class: 'text-success fs-5',
                                    text: `$${(e.price*e.cantidad).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`
                                })
                            ),
                            $('<hr>')
                        )
                    );
                })
            }
            cartTotal()
        }
        const saveInCart = (id) => {
            var product;
            productsAvailable.map(e => {
                (e.id == id) ? product = e: null;
            })
            let cart = localStorage.getItem('cart');
            if (cart) {
                cart = JSON.parse(cart);
                var flag;
                cart.map(e => {
                    if (e.id == id) {
                        flag = e;
                        e.cantidad++;
                        if (e.cantidad > e.stock) {
                            e.cantidad--;
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
                                title: 'No hay más stock de ' + e.name_product,
                                icon: 'error'
                            });

                        } else {
                            localStorage.setItem('cart', JSON.stringify(cart));
                            renderCart();
                        }

                    }
                })
                if (!flag) {
                    delete product.image_product;
                    delete product.category;
                    cart = cart.concat({
                        ...product,
                        cantidad: 1
                    })
                    localStorage.setItem('cart', JSON.stringify(cart));
                    renderCart();
                }
            } else {
                delete product.image_product;
                delete product.category;
                product = [{
                    ...product,
                    cantidad: 1
                }]
                localStorage.setItem('cart', JSON.stringify(product));
                renderCart();
            }

        }
        const cartTotal = () => {
            var cart = localStorage.getItem('cart');
            var total = 0;
            products = JSON.parse(cart);
            products.map(product => {
                total += product.cantidad * product.price;

            })

            $('#continuePayment').empty()
            $('#continuePayment').append(
                `<a onclick="checkCart(event)" href="/cart" class="btn bgColor text-white buttonHover m-0 text-start d-flex justify-content-between">Ir a pagar<span class="text-white">$ ${total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</span></a>`
            )
        }


        $(document).ready(function() {
            renderCart();
            var showChar = 130;
            var ellipsestext = "...";
            var moretext = "ver más";
            var lesstext = "ver menos";
            $('.more').each(function() {
                var content = $(this).html();
                if (content.length - 100 > showChar) {

                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar - 1, content.length - showChar);

                    var html = c + '<span class="moreellipses">' + ellipsestext +
                        '&nbsp;</span><span class="morecontent"><span>' + h +
                        '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                    $(this).html(html);
                }

            });

            $(".morelink").click(function() {
                if ($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });
        });

        const categorias = Array.from(document.querySelectorAll('.intersectionObserver'))
        if (categorias) {
            var actualActivo;
            var options = {
                root: null,
                rootMargin: '0px 0px -90%',
            }
            const observer = new IntersectionObserver(entries => {
                if (entries[0].target.id != actualActivo) {
                    $('.categoriaActive').removeClass('categoriaActive')
                    actualActivo = entries[0].target.id;
                    $(`#${entries[0].target.id}Navbar`).addClass('categoriaActive')
                }
            }, options);

            categorias.map(categoria => {
                observer.observe(categoria)
            })
        }
    </script>
@endsection

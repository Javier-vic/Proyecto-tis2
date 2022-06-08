@extends('layouts.userNavbar')

@section('content')
    <div>
        <div id="carouselExampleIndicators" class="carousel slide bg-dark" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                    aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner object-fit-cover w-100">
                <div class="carousel-item active" data-bs-interval="3000">
                    <img src="https://dummyimage.com/1024x768/000/fff" class="d-block w-100" alt="..."
                        style="width: 640px; height:500px;">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="https://dummyimage.com/1024x768/000/fff" class="d-block w-100" alt="..."
                        style="width: 640px; height:500px;">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="https://dummyimage.com/1024x768/000/fff" class="d-block w-100" alt="..."
                        style="width: 640px; height:500px;">
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="https://dummyimage.com/1024x768/000/fff" class="d-block w-100" alt="..."
                        style="width: 640px; height:500px;">
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

    <div class="d-flex mt-5">
        <div class="col-12 col-md-8 col-xl-9 me-5 ">
            <div>
                <div class=" bgColor p-2 d-flex py-3 rounded rounded-4 overflow-auto sticky-top align-items-center ">
                    @foreach ($category_products as $category_product)
                        @if (in_array($category_product->name, $categoryAvailableNames))
                            <div class="text-white">
                                <a href="#{{ str_replace(' ','',$category_product->name) }}"
                                    id="{{ str_replace(' ','',$category_product->name) }}Navbar"
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
                <div>
                    {{-- PRODUCTOS --}}
                    @foreach ($categoryAvailable as $category)
                        <h2 id="{{ str_replace(' ','',$category->name) }}" class="mb-5 invisible intersectionObserver">a</h2>
                        <div>
                            <h2 class="categoryName" id="{{ $category->name }}Nombre">{{ $category->name }}</h2>
                            <section>
                                <div class="my-2 row ">
                                    @foreach ($productAvailable as $product)
                                        @if ($product->category_id == $category->id)
                                            <div class="col-12 col-sm-6  col-xl-4 mb-3 p-1 ">
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
                                                            <a>{{ $product->name_product }}</a>
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
                            <hr>

                        </div>
                    @endforeach
                    <div class="text-center d-md-none  sticky-margin-bottom" style="position: sticky;bottom: 0;">
                        <button class="btn btn-danger w-50 py-4  shadow "><h4 class="m-0"><i class="fa-solid fa-basket-shopping me-2"></i>Ver mi pedido</h4></button>
                    </div>
                    {{-- FIN PRODUCTOS --}}
                </div>
            </div>

        </div>

        {{-- TÚ PEDIDO --}}
        {{-- <div class="border border-danger border-3 py-3 px-1 align-self-start sticky-top d-none d-xl-block"> --}}
        <div class="border border-danger border-3 py-3 px-1 align-self-start sticky-top d-none d-md-block rounded sticky-margin-top"
            style="width: -webkit-fill-available;">
            <div class="rounded text-center">
                <h5 class="text-dark  mx-auto">Tu pedido</h5>
                <hr class="bg-dark">
            </div>
            {{-- CONTENIDO CÚANDO SE ENCUENTRA VACÍO --}}

            {{-- END CONTENIDO VACÍO --}}
            {{-- PRODUCTOS AGREGADOS --}}
            <div id="cart" class="py-4">
                <div class="text-white mx-3 px-2">
                    <img src="https://www.papajohns.cl/static/media/ic_cart_empty.1de2c93e.svg" alt=""
                        class="img-fluid" width="500" height="350">
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
    {{-- FOOTER --}}
    <div class="container">
  
    </div>
    {{-- END FOOTER --}}
@endsection

@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        const productsAvailable = @json($productAvailable);

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
            cart = JSON.parse(cart);
            $("#cart").empty();
            console.log(cart.length)
            if (cart.length === 0) {
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
                // LE PONE NÚMERO AL LADO DEL ICONO DEL CARRITO CON LA CANTIDAD DE PRODUCTOS
                $('#cartQuantity').empty()
                $('#cartQuantity').append(`<span class="ms-2">${cart.length}</span>`)

                $('#cartQuantity2').empty()
                $('#cartQuantity2').append(`<span class="ms-2">${cart.length}</span>`)
                //////////////////////////////////////////////// 
                cart = cart.map(e => {
                    $("#cart").append(
                        $('<div>', {
                            class: 'mx-3 px-2',
                        }).append(
                            //
                            $('<div>', {
                                class: 'd-flex justify-content-between mb-3 flex-column flex-lg-row '
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
                                            class: 'fa-solid fa-plus'
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
                                            class: 'fa-solid fa-minus text-danger'
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
                                    class: 'text-sucess fs-5',
                                    text: `$${e.price*e.cantidad}`
                                })
                            ),
                            $('<hr>')
                        )
                    );
                })
            }

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
                        if (e.cantidad > e.stock ) {
                        e.cantidad--;
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'error',
                            title: `No hay más unidades de ${e.name_product}`,
                            showConfirmButton: false,
                            timer: 2000,
                            backdrop: false
                    })
                
                    }
                    else{
                        localStorage.setItem('cart', JSON.stringify(cart));
                    renderCart();
                    }
                       
                    }
                })
                if (!flag) {
                    delete product.image_product;
                    delete product.category;
                    delete product.category_id;
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
                delete product.category_id;
                product = [{
                    ...product,
                    cantidad: 1
                }]
                localStorage.setItem('cart', JSON.stringify(product));
                renderCart();
            }

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
    </script>
    <script type="text/javascript">
        const categorias = Array.from(document.querySelectorAll('.intersectionObserver'))
        console.log(categorias)
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

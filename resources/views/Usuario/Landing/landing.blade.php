@extends('layouts.userNavbar')

@section('content')
    <div>
        <div id="carouselExampleIndicators" class="carousel slide bg-dark" data-bs-ride="true">
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
                <div class="carousel-item active">
                    <img src="https://dummyimage.com/1024x768/000/fff" class="d-block w-100" alt="..."
                        style="width: 640px; height:500px;">
                </div>
                <div class="carousel-item">
                    <img src="https://dummyimage.com/1024x768/000/fff" class="d-block w-100" alt="..."
                        style="width: 640px; height:500px;">
                </div>
                <div class="carousel-item">
                    <img src="https://dummyimage.com/1024x768/000/fff" class="d-block w-100" alt="..."
                        style="width: 640px; height:500px;">
                </div>
                <div class="carousel-item">
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
        <div class="col-9  me-5 ">
            <div>
                <div class=" bg-danger p-2 d-flex py-3 rounded overflow-auto sticky-top align-items-center">
                    @foreach ($category_products as $category_product)
                        @if (in_array($category_product->name, $categoryAvailableNames))
                            <div class="text-white">
                                <a href="#{{ $category_product->name }}"
                                    class="text-decoration-none text-white categoriaBackground py-1 px-3 rounded-pill mx-1 "
                                    style="white-space: nowrap">{{ $category_product->name }}</a>
                            </div>
                        @else
                            <div class="text-white">
                                <a href="#{{ $category_product->name }}"
                                    class="text-decoration-none text-white categoriaBackground py-1 px-3 rounded-pill mx-1 text-decoration-line-through"
                                    style="white-space: nowrap">{{ $category_product->name }}</a>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div>
                    {{-- PRODUCTOS --}}
                    @foreach ($categoryAvailable as $category)
                        <h2 id="{{ $category->name }}" class="mb-5 invisible">a</h2>
                        <div>
                            <h2>{{ $category->name }}</h2>
                            <section>
                                <div class="my-2 row ">
                                    @foreach ($productAvailable as $product)
                                        @if ($product->category_id == $category->id)
                                            <div class=" col-12 col-md-6 col-xl-4 mb-3 p-1 ">
                                                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                                    <img src="{{ asset('storage') . '/' . $product->image_product }}"
                                                        class="img-fluid rounded" />
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between position-relative bg-white rounded px-2 pt-1  shadow border mb-3"
                                                        style="margin-top:-30px;">
                                                        <h5 class="card-title font-weight-bold">
                                                            <a>{{ $product->name_product }}</a>
                                                        </h5>
                                                        <p class="mb-2 text-success font-weight-bold">$
                                                            {{ $product->price }}</p>
                                                    </div>
                                                    <p class="card-text comment more" style="min-height: 50px;">
                                                        {{ $product->description }}
                                                    </p>
                                                    <a href="#"
                                                        class="btn w-100 bg-success text-white text-decoration-none agregarCarrito"><i
                                                            class="fa-solid fa-plus me-1"></i>
                                                        Agregar al carrito</a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                </secti>

                        </div>
                    @endforeach
                    {{-- FIN PRODUCTOS --}}
                </div>
            </div>

        </div>

        {{-- TÚ PEDIDO --}}
        <div class="border border-danger border-3 py-3 px-1 align-self-start sticky-top">
            <div class="rounded text-center">
                <h5 class="text-dark  mx-auto">Tu pedido</h5>
                <hr class="bg-dark">
            </div>
            {{-- CONTENIDO CÚANDO SE ENCUENTRA VACÍO --}}
            {{-- <div class="text-white mx-3 px-2">
                <img src="https://www.papajohns.cl/static/media/ic_cart_empty.1de2c93e.svg" alt="" class="img-fluid"
                    width="500" height="350">
                <p class="text-muted m-0">Aún no has seleccionado ningún producto.</p>
                <p class="text-muted m-0">Selecciona alguno y comienza a disfrutar !</p>
            </div> --}}
            {{-- END CONTENIDO VACÍO --}}
            {{-- PRODUCTOS AGREGADOS --}}
            <div>
                <div class="mx-3 px-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="text-dark ">Korukushi</h4>
                        <div class="d-flex gap-2 align-items-center">
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
                </div>
                <div class="mx-3 px-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="text-dark ">Korukushi</h4>
                        <div class="d-flex gap-2 align-items-center">
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
                </div>
            </div>


        </div>
    </div>
    {{--  --}}
    {{-- END TÚ PEDIDO --}}
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
    <script type="text/javascript">
        $(document).ready(function() {
            var showChar = 130;
            var ellipsestext = "...";
            var moretext = "ver más";
            var lesstext = "ver menos";
            $('.more').each(function() {
                var content = $(this).html();
                console.log(content.length)
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
@endsection

@extends('layouts.userNavbar')

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css"
        type="text/css">
    <style>
        .marker {
            background-image: url(https://www.svgrepo.com/show/362123/map-marker.svg);
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

        .mapboxgl-popup {
            max-width: 200px;
        }

        .mapboxgl-popup-content {
            text-align: center;
            font-family: 'Open Sans', sans-serif;
        }
    </style>
</head>
@section('content')
    <form onsubmit="createOrder(event)" method="POST" enctype="multipart/form-data" id="createOrder"
        class="container-fluid">
        @csrf
        <div>@include('Usuario.Cart.addressModal')</div>

        <div class="row gap-3">
            {{-- DATOS DE COMPRA --}}
            <div class="bg-white shadow p-3 mt-5 col-12 col-md-8">
                <h2 class="">Datos de compra</h2>
                <hr>
                <div class="">
                    <div class="d-flex mb-4">
                        <div class="w-100">
                            <label for="" class="form-label"><i class="fa-solid fa-user me-2"></i>Nombre</label>
                            <input type="text" class="form-control input-modal" id="name_order" name="name_order"
                                aria-describedby="name_help" placeholder="Juan Perez" onkeyup="checkInput(event)"
                                @if (auth()->user()) value="{{ auth()->user()->name }}" readonly @endif>
                            <span class="text-danger createmodal_error" id="name_order_error"></span>
                        </div>

                    </div>
                    <div class="d-flex gap-4 mb-4">
                        <div class="w-100">
                            <label for="" class="form-label"><i class="fa-solid fa-envelope me-2"></i>Correo
                                electrónico </label>
                            <input type="text" class="form-control input-modal" id="mail" name="mail"
                                aria-describedby="mail_help" placeholder="juanperez@gmail.com" onkeyup="checkInput(event)"
                                @if (auth()->user()) value="{{ auth()->user()->email }}" readonly @endif>
                            <span class="text-danger createmodal_error" id="mail_error"></span>
                        </div>
                        <div class="w-100">
                            <label for="" class="form-label"><i class="fa-solid fa-phone me-2"></i>Teléfono </label>
                            <div class=" input-group">
                                <span class="input-group-text">+56</span>
                                <input type="text" class="form-control input-modal" id="number" name="number"
                                    aria-describedby="number_help" placeholder="912312312" onkeyup="checkInput(event)"
                                    @if (auth()->user()) value="{{ auth()->user()->phone }}" readonly @endif>
                            </div>
                            <span class="text-danger createmodal_error" id="number_error"></span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label"><i class="fa-solid fa-comment me-2"></i>Comentarios
                        </label>
                        <textarea name="comment" id="comment" rows="2" class="w-100 form-control input-modal"
                            placeholder="Comentarios acerca del pedido..."></textarea>
                        <span class="text-danger createmodal_error" id="comment_error"></span>

                    </div>
                    <div class="form-check form-switch ">
                        <input class="form-check-input" type="checkbox" id="termsAndConditions">
                        <label class="form-check-label" for="termsAndConditions">Acepto los <a href="">términos</a> y
                            <a href="">condiciones</a></label>
                    </div>

                </div>
            </div>
            {{--  --}}
            {{-- TIPO DE ENVÍO --}}
            <div class="bg-white shadow p-3 mt-5 col ">
                <h3 class="m-0">Tipo de envío</h3>
                <hr>
                <div class="d-flex flex-column justify-content-between">
                    <div class="form-check w-100 ms-3 mb-4 d-flex">
                        <input class="form-check-input fs-4" type="radio" name="delivery" id="sucursal"
                            value="Retira en local">
                        <label class="form-check-label align-self-center ms-2" for="sucursal">
                            <h4 class="m-0 ms-2"><i class="fa-solid fa-house me-2"></i>Retiro en sucursal</h4>
                        </label>
                    </div>
                    <div class="form-check w-100 align-center ms-3 d-flex">
                        <input class="form-check-input fs-4" type="radio" name="delivery" id="delivery">
                        <label class="form-check-label align-self-center ms-2" for="delivery">
                            <h4 class="m-0 ms-2"><i class="fa-solid fa-person-biking me-2"></i>Despacho a domicilio</h4>
                        </label>
                    </div>
                    <span class="text-danger createmodal_error" id="address_error"></span>
                    <input type="text" name="address" id="address" hidden>
                    <div>
                        <input type="text" name="pick_up" id="pick_up" hidden>
                    </div>
                    <div id="deliveryType" class="mt-5">

                    </div>
                </div>
                <input type="number" name="delivery_price" id="delivery_price" hidden>

            </div>
        </div>
        <div class="row gap-3 ">
            <div class="bg-white shadow p-3 mt-5 col">
                <h3 class="m-0">Tú pedido</h3>
                <hr>
                <div class="px-4" id="cartContainer" style="overflow-y: scroll; height:500px;">

                    {{-- PLANTILLA DE UN PRODUCTO DEL CARRITO --}}
                    <!-- {{-- <div class="d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between mb-3 flex-column flex-lg-row">
                        <h4 class="text-dark ">Korukushi</h4>
                        <div class="d-flex gap-2 align-items-center ">
                            <a href="#"><i class="fa-solid fa-circle-plus fa-xl text-success"></i></a>
                            <h4 class="m-0">1</h4>
                            <a href="#"><i class="fa-solid fa-circle-minus text-danger fa-xl "></i></a>
                        </div>
                    </div>
                    <p class="text-muted ">Pescado chino, arroz , korugumi , limón y sal.</p>
                    <div class="text-end">
                        <p class="text-success fs-5 ">$ 2500</p>
                    </div>
                </div> --}} -->

                </div>

            </div>
            <div class="bg-white shadow p-3 mt-5 col-md-6">
                <div class="h-50">
                    <h3 class="m-0">Método de pago</h3c>
                        <hr>
                        <div id="payment_methodContainer" class="mb-3">
                            <a class="check_payment_method btn shadow w-100 d-flex justify-content-between align-items-center hover paymentMethodHover mb-2"
                                onclick="paymentMethod(event)" id="efectivo_method">
                                <label class="" for="efectivo_method">Efectivo</label>
                                <img class=" img-fluid" style="width:50px;height:50px;"
                                    src="{{ asset('storage/images/cashicon.svg') }}" alt="Efectivo">
                            </a>
                            <a class="check_payment_method btn shadow w-100 d-flex justify-content-between align-items-center hover paymentMethodHover"
                                onclick="paymentMethod(event)" id="prepago_method">
                                <label class="" for="prepago_method">Prepago</label>
                                <img class=" img-fluid"
                                    style="width:50px;height:50px;"src="{{ asset('storage/images/cardicon.svg') }}"
                                    alt="Efectivo">
                            </a>
                        </div>
                        <input type="text" hidden id="paymentMethod" name="payment_method">
                        <span class="text-danger createmodal_error " id="payment_method_error"></span>
                </div>
                <div class="h-50">
                    <div class="h-50">
                        <h3 class="m-0">Resumen pedido</h3>
                        <hr>
                        <div class="" id="subtotal">
                            <h5>Subtotal: <span id="totalCart"></span> </h5>
                            <div class="m-0 p-0" id="deliveryPriceContainer"></div>
                        </div>
                        <hr>
                        <button class="btn bgColor text-white buttonHover">Confirmar pedido</button>
                    </div>

                    @auth
                        <div class="mt-5 h-50">
                            <span>Cupón</span>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control" id="coupon" name="coupon"
                                    aria-describedby="mail_help" value="">
                                <button class="btn bgColor text-white buttonHover"
                                    onclick="checkCoupon(event)">Verificar</button>
                            </div>
                            <span class="text-muted" id="couponDescription"></span>
                        </div>
                    @endauth
                    @guest
                        <input type="text" hidden class="form-control" id="coupon" name="coupon"
                            aria-describedby="mail_help" value="">
                        <div class="mt-5  card-body shadow">
                            <h5>¿Tienes un cupón de descuento? <a href="/login">Inicia sesión para utilizarlo</a></h5>

                        </div>
                    @endguest

                </div>

            </div>
        </div>
    </form>

    {{--  --}}
@endsection

@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if (localStorage.getItem('cart')) {
                if (localStorage.getItem('cart').length > 0) fullfillCart();
            } else {
                localStorage.setItem('cart', JSON.stringify([]));
                window.location.href = "/";
            }


            //REVISA CUAL RADIO ESTÁ SELECCIONADO ( DELIVERY O RETIRO EN SUCURSAL)
            $('input[type=radio][name=delivery]').change(function() {
                if (this.id === 'sucursal') {
                    $('#deliveryType').empty()
                    $('#deliveryType').append(`
                <div>
                    <p class="m-0 fs-3">Ubicación sucursal</p>
                    <p class="m-0 fs-4"><i class="fa-solid fa-location-dot me-2"></i>Purén #596, Chillán</p>
                </div>
                `)
                    $('#address').val('Retira en sucursal');
                    $('#pick_up').val('no');
                    $('#delivery_price').val('')
                    $('#deliveryPriceContainer').empty()
                    cartTotal()

                } else if (this.id === 'delivery') {
                    if (!datosMapa.delivery_zones || datosMapa.delivery_zones === '') {
                        $('#address').val('');
                        $('#deliveryType').empty()
                        $('#deliveryType').append(
                            '<span class="text-danger fs-5">No hay delivery de momento</span>')
                    } else {
                        $('#address').val('');
                        $('#deliveryType').empty()
                        $('#pick_up').val('si');
                        $('#deliveryType').append(`
                <h2 id="deliveryAddress" class="m-0 p-0"></h2>
                    <button class="btn bgColor text-white buttonHover" onclick="addAddress(event)" data-bs-toggle="modal" data-bs-target="#addAddressModal">Seleccionar Ubicación</button>
                `)


                    }

                }
            });

        });



        function fullfillCart() {
            $("#cartContainer").empty();
            let productos = JSON.parse(localStorage.getItem('cart'));

            if (productos.length <= 0) {
                window.location.href = "/";
            }
            // LE PONE NÚMERO AL LADO DEL ICONO DEL CARRITO CON LA CANTIDAD DE PRODUCTOS
            cartQuantity()
            //////////////////////////////////////////////// 

            productos.map(product => {
                $('#cartContainer').append(`
           <div class="d-flex flex-column justify-content-between px-3">
                <div class="d-flex justify-content-between mb-3 flex-column flex-lg-row">
                    <h4 class="text-dark ">${product.name_product}</h4>
                    <div class="d-flex gap-2 align-items-center ">
                        <a onclick="saveInCart(${product.id})"><i class="fa-solid fa-circle-plus fa-xl text-success"></i></a>
                        <h4 class="m-0">${product.cantidad}</h4>
                        <a  onclick="deleteInCart(${product.id})" ><i class="fa-solid fa-circle-minus text-danger fa-xl"></i></a>
                    </div>
                </div>
                <p class="text-muted ">${product.description}</p>
                <div class="d-flex" justify-content-between>
                    <div class=" w-100">
                        <span>Precio unitario </span><p class="text-success fs-5 ">$ ${(product.price).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</p>
                    </div>
                    <div class="text-end w-100">
                        <span>Total </span><p class="text-success fs-5 ">$ ${(product.price * product.cantidad).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</p>
                    </div>
                </div>
            </div>
            <span id="product${product.id}_error"></span>
            <hr>
           `)

            })
            cartTotal();
        }

        const cartTotal = () => {
            var cart = localStorage.getItem('cart');
            var total = 0;
            products = JSON.parse(cart);
            products.map(product => {
                total += product.cantidad * product.price;
            })

            if (parseInt($('#delivery_price').val()) > 0) {
                total += parseInt($('#delivery_price').val())
            }


            $('#totalCart').empty()
            $('#totalCart').append(`<span>$ ${total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</span>`)
        }

        const deleteInCart = (id) => {

            var cart = localStorage.getItem('cart');
            cart = JSON.parse(cart);
            cart.map(e => {
                if (e.id == id) {
                    if (e.cantidad == 1) {
                        Swal.fire({
                            title: '¿Estás seguro de eliminar este producto?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, eliminar!',
                            cancelButtonText: 'Cancelar',
                        }).then(result => {
                            if (result.isConfirmed) {
                                cart = cart.filter((el) => el.id != e.id);
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
                                        toast.addEventListener('mouseleave', Swal
                                            .resumeTimer)
                                    }
                                });
                                toastMixin.fire({
                                    title: 'Se eliminó ' + e.name_product,
                                    icon: 'success'
                                });
                                localStorage.setItem('cart', JSON.stringify(cart));
                                cartTotal()
                                fullfillCart();
                            }

                        })

                    } else {
                        e.cantidad--
                        localStorage.setItem('cart', JSON.stringify(cart));
                        fullfillCart();
                    }
                }
            })

        }

        const saveInCart = (id) => {

            var cart = localStorage.getItem('cart');
            cart = JSON.parse(cart);
            cart.map(e => {
                if (e.id == id) {
                    e.cantidad++;
                    if (e.cantidad > e.stock) {
                        e.cantidad--;
                        var toastMixin = Swal.mixin({
                            toast: true,
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
                    }
                }
            })
            localStorage.setItem('cart', JSON.stringify(cart));
            fullfillCart();
        }


        //DEFINE EL MÉTODO DE PAGO 
        const paymentMethod = (e) => {
            $('.paymentMethodBorder').removeClass('paymentMethodBorder')
            e.preventDefault()
            $('#paymentMethod').attr('value', e.target.innerText)
            $(`#${e.target.id}`).addClass('paymentMethodBorder')


        }
        // ****************************************************************************************************************
        //CREAR ORDEN
        // ****************************************************************************************************************
        const createOrder = (e) => {
            e.preventDefault();
            let cart = localStorage.getItem('cart');

            let formData = new FormData(e.currentTarget);
            formData.append('cantidad', cart);
            let url = '{{ route('landing.store') }}';
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response, jqXHR) {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Se creó la orden correctamente.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,
                        heightAuto: false,
                    })
                    // //QUITA LAS CLASES Y ELEMENTOS DE INVALID
                    // $("input-modal").removeClass('is-invalid');
                    // $("input-modal").removeClass('is-valid');
                    // $(".createmodal_error").empty()
                    // //////////////////////////////////////                    

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var text = jqXHR.responseJSON;
                    //LIMPIA LAS CLASES Y ELEMENTOS DE INVALID
                    $(".createmodal_error").empty()
                    $(".input-modal").addClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    //////////////////////////////////////////
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: text.message,
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                    // AGREGA LAS CLASES Y ELEMENTOS DE INVALID
                    if (text) {
                        $.each(text.errors, function(key, item) {
                            $("#" + key + "_error").append("<span class='text-danger'>" +
                                item + "</span>")
                            $(`#${key}`).addClass('is-invalid');
                        });

                        ////////////////////////////////////
                        //DESPLIEGA QUE NO HAY SUFICIENTE STOCK PARA CADA PRODUCTO 
                        if (!text.stock) {
                            let cart = localStorage.getItem('cart');
                            cart = JSON.parse(cart);
                            (cart)

                            $.each(text.errors, function(key, item) {
                                $(`#product${item[0]}_error`).empty()
                                $("#product" + item[0] + "_error").append(
                                    "<span class='text-danger'> No hay stock suficiente para este producto tienes " +
                                    item[1] + " unidades extra aproximadamente</span>")
                                cart.map(product => {
                                    if (product.id === item[0]) {
                                        product.stock = product.cantidad - item[1]
                                    }
                                })
                                localStorage.setItem('cart', JSON.stringify(cart));

                            });


                        }

                    }


                }

            });
        }

        const checkInput = (e) => {
            if (e.target.value) {
                $(`#${e.target.id}_error`).empty()
                $("#" + e.target.id).removeClass('is-invalid')
                $("#" + e.target.id).addClass('is-valid')

            } else {
                $(`#${e.target.id}_error`).empty()
                $("#" + e.target.id).removeClass('is-valid')
                $("#" + e.target.id).addClass('is-invalid')
                $("#" + e.target.id + "_error").append("<span class='text-danger'>" + 'Este campo es obligatorio' +
                    "</span>")
            }
        }

        const checkCoupon = (e) => {
            e.preventDefault()
            let code = $('#coupon').val()
            let url = '{{ route('landing.check.coupon') }}';
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    code: code
                },
                dataType: "json",
                success: function(response, jqXHR) {
                    var text = response;
                    (text)
                    var toastMixin = Swal.mixin({
                        toast: true,
                        icon: 'success',
                        title: text.correct,
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
                        title: text.correct,
                        icon: 'success'
                    });
                    if (text) {
                        $('#coupon').removeClass('is-invalid')
                        $('#coupon').addClass('is-valid')
                        $('#coupon').val(code);
                        $('#couponDescription').append(
                            `<span class="text-muted">*El cupón aplicará un ${text.couponPercentage}% de dcto al total de tu compra (incluyendo precio del delivery).</span>`
                        )
                    }


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var text = jqXHR.responseJSON;

                    var toastMixin = Swal.mixin({
                        toast: true,
                        icon: 'error',
                        title: text.message,
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
                        title: text.errors,
                        icon: 'error'
                    });
                    // AGREGA LAS CLASES Y ELEMENTOS DE INVALID
                    if (text) {
                        $('#coupon').removeClass('is-valid')
                        $('#coupon').addClass('is-invalid')
                        $('#couponDescription').empty()

                    }

                }

            });

        }


        const addAddress = (e) => {
            e.preventDefault()
            // $('#addAddressModal').on('shown.bs.modal', function() {
            // map.invalidateSize();
            // });
            // $('#addAddressModal').modal('show');


        }
    </script>
@endsection

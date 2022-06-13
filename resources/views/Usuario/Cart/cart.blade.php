@extends('layouts.userNavbar')

@section('content')
<form onsubmit="createOrder(event)" method="POST" enctype="multipart/form-data" id="createOrder">
    @csrf
    <div class="row gap-3">
        {{-- DATOS DE COMPRA --}}
            <div class="bg-white shadow p-3 mt-5 col col-8">
                <h2 class="">Datos de compra</h2>
                <hr>
                <div class="">
                    <div class="d-flex mb-4">
                        <div class="w-100">
                            <label for="" class="form-label"><i class="fa-solid fa-user me-2"></i>Nombre</label>
                            <input type="text" class="form-control input-modal" id="name_order" name="name_order"
                                aria-describedby="name_help" placeholder="Juan Perez" onkeyup="checkInput(event)">
                            <span class="text-danger createmodal_error" id="name_order_error"></span>
                        </div>
    
                    </div>
                    <div class="d-flex gap-4 mb-4">
                        <div class="w-100">
                            <label for="" class="form-label"><i class="fa-solid fa-envelope me-2"></i>Correo electrónico </label>
                            <input type="text" class="form-control input-modal" id="mail" name="mail"
                                aria-describedby="mail_help" placeholder="juanperez@gmail.com" onkeyup="checkInput(event)">
                            <span class="text-danger createmodal_error" id="mail_error"></span>
                        </div>
                        <div class="w-100">
                            <label for="" class="form-label"><i class="fa-solid fa-phone me-2"></i>Teléfono </label>
                            <div class=" input-group">
                            <span class="input-group-text">+56</span>
                            <input type="text" class="form-control input-modal" id="number" name="number"
                                aria-describedby="number_help" placeholder="912312312" onkeyup="checkInput(event)">
                        </div>
                            <span class="text-danger createmodal_error" id="number_error"></span>
                        </div>
                    </div>
                    <div class="form-check form-switch ">
                        <input class="form-check-input" type="checkbox" id="termsAndConditions">
                        <label class="form-check-label" for="termsAndConditions">Acepto los <a href="">términos</a> y <a href="">condiciones</a></label>
                      </div>
                </div>
    
            </div>
            {{--  --}}
        {{-- TIPO DE ENVÍO --}}
        <div class="bg-white shadow p-3 mt-5 col ">
            <h3 class="m-0">Tipo de envío</h3>
            <hr>
            <div class="d-flex flex-column justify-content-between">
                <div class="form-check w-100">
                    <input class="form-check-input fs-5" type="radio" name="delivery" id="sucursal" value="Retira en local">
                    <label class="form-check-label" for="sucursal">
                        <h4 class="m-0 ms-2" ><i class="fa-solid fa-house me-2"></i>Retiro en sucursal</h4>
                    </label>
                </div>
                <div class="form-check w-100 align-center">
                    <input class="form-check-input fs-5" type="radio" name="delivery" id="delivery" >
                    <label class="form-check-label" for="delivery">
                        <h4 class="m-0 ms-2"><i class="fa-solid fa-person-biking me-2"></i>Despacho a domicilio</h4>
                </label>
                </div>
                <span class="text-danger createmodal_error" id="address_error"></span>
                <input type="text" name="address" id="address" hidden>
                <input type="text" name="pick_up" id="pick_up" hidden>
                <div id="deliveryType" class="mt-5"></div>   
            </div>  
            

        </div>
    </div>
    <div class="row gap-3">
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
        <div class="bg-white shadow p-3 mt-5 col">
            <div class="h-50">
                <h3 class="m-0">Método de pago</h3c>
                <hr>
                <div id="payment_methodContainer" class="mb-3">
                    <a class="check_payment_method btn shadow w-100 d-flex justify-content-between align-items-center hover paymentMethodHover mb-2" onclick="paymentMethod(event)" id="efectivo_method">
                        <label class="" for="efectivo_method">Efectivo</label>
                         <img class=" img-fluid" style="width:50px;height:50px;" src="{{asset("storage/images/cashicon.svg")}}" alt="Efectivo">
                    </a>
                    <a class="check_payment_method btn shadow w-100 d-flex justify-content-between align-items-center hover paymentMethodHover" onclick="paymentMethod(event)" id="prepago_method">
                        <label class="" for="prepago_method">Prepago</label>
                         <img class=" img-fluid" style="width:50px;height:50px;"src="{{asset("storage/images/cardicon.svg")}}" alt="Efectivo">
                    </a>
                </div>
                <input type="text" hidden id="paymentMethod" name="payment_method">
                <span class="text-danger createmodal_error " id="payment_method_error"></span>
            </div>
            <div class="h-50">
                <h3 class="m-0">Resumen pedido</h3>
                <hr>
                <div class="" >
                  <h5>Subtotal: <span id="totalCart"></span> </h5>
                  <hr>
                </div>
            <button class="btn bgColor text-white buttonHover">Confirmar pedido</button>
        </div>
    
        </div>
    </div>
</form>

{{--  --}}
@endsection

@section('js_after')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
  
    $( document ).ready(function() {
        if(localStorage.getItem('cart')){
            if(localStorage.getItem('cart').length > 0) fullfillCart();
        }
        else  {
            localStorage.setItem('cart', JSON.stringify([]));
            window.location.href = "/";}


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
                console.log('SUCURSAL')
            }
            else if (this.id === 'delivery') {
                $('#deliveryType').empty()

            }
        });
        
    });
    

    function fullfillCart(){
        $("#cartContainer").empty();
        let productos = JSON.parse(localStorage.getItem('cart'));
        console.log(productos)
        if(productos.length <= 0){
            window.location.href = "/"; 
        }  
        // LE PONE NÚMERO AL LADO DEL ICONO DEL CARRITO CON LA CANTIDAD DE PRODUCTOS
        $('#cartQuantity').empty()
        $('#cartQuantity').append(`<span class="ms-2">${productos.length}</span>`)

        $('#cartQuantity2').empty()
        $('#cartQuantity2').append(`<span class="ms-2">${productos.length}</span>`)
        //////////////////////////////////////////////// 

        productos.map(product=>{
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
            <hr>
           `)
           
        })
        
        cartTotal();
    }

    const cartTotal = () =>{
        var cart = localStorage.getItem('cart');
        var total=0;
        products = JSON.parse(cart);
        products.map(product=>{
            total += product.cantidad * product.price ;
            
        })
        $('#totalCart').empty()
        $('#totalCart').append(`<span>$ ${total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</span>`)
    }

    const deleteInCart = (id) => {
        console.log('borrar')
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
            }).then(result=>{
                if(result.isConfirmed){
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
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                toastMixin.fire({
                    title: 'Se eliminó '+ e.name_product,
                    icon: 'success'
                });                  
                    localStorage.setItem('cart', JSON.stringify(cart));
                    cartTotal()
                    fullfillCart();
                }
               
            })
                    
            }
            else{
                e.cantidad--
                localStorage.setItem('cart', JSON.stringify(cart));
                fullfillCart();
            }
        }
        })
       
        }

    const saveInCart = (id) => {
        console.log('agregar')
        var cart = localStorage.getItem('cart');
        cart = JSON.parse(cart);
        cart.map(e => {
            if (e.id == id) {
                e.cantidad++;
                if (e.cantidad > e.stock ) {
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
                    title: 'No hay más stock de '+ e.name_product,
                    icon: 'error'
                });
                }
            }
        })
        localStorage.setItem('cart', JSON.stringify(cart));
        fullfillCart();
    }

      
        //DEFINE EL MÉTODO DE PAGO 
        const paymentMethod = (e) =>{
            $('.paymentMethodBorder').removeClass('paymentMethodBorder')
            e.preventDefault()
           $('#paymentMethod').attr('value',e.target.innerText)
           $(`#${e.target.id}`).addClass('paymentMethodBorder')

           console.log(e.target.id)
        }
        // ****************************************************************************************************************
        //CREAR ORDEN
        // ****************************************************************************************************************
        const createOrder = (e) => {
            e.preventDefault();
            let cart = localStorage.getItem('cart');
            
            let formData = new FormData(e.currentTarget);
            formData.append('cantidad',cart);
            let url = '{{ route('landing.store') }}';
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response, jqXHR) {
                    console.log(response)
                    console.log(jqXHR)
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Se ingresó el producto correctamente.',
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
                    console.log(text)
                    //LIMPIA LAS CLASES Y ELEMENTOS DE INVALID
                    $(".createmodal_error").empty()
                    $(".input-modal").addClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    //////////////////////////////////////////
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: "No se pudo realizar el ingreso del producto.",
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
                    }
                    ////////////////////////////////////

                }

            });
        }

        const checkInput = (e) =>{
            console.log(e.target.value)
            if(e.target.value){
            $(`#${e.target.id}_error`).empty()
            $("#" + e.target.id).removeClass('is-invalid')
            $("#" + e.target.id).addClass('is-valid')
              
            }
            else{
            $(`#${e.target.id}_error`).empty()
                $("#" + e.target.id).removeClass('is-valid')
                $("#" + e.target.id).addClass('is-invalid')
                $("#" + e.target.id + "_error").append("<span class='text-danger'>" + 'Este campo es obligatorio' + "</span>")
            }
        }

    
</script>
@endsection
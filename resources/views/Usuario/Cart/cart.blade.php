@extends('layouts.userNavbar')

@section('content')
<div class="row gap-3">
    {{-- DATOS DE COMPRA --}}
        <div class="bg-white shadow p-3 mt-5 col col-8">
            <h2 class="">Datos de compra</h2>
            <hr>
            <div class="">
                <div class="d-flex gap-4 mb-4">
                    <div class="w-100">
                        <label for="" class="form-label"><i class="fa-solid fa-user me-2"></i>Nombre </label>
                        <input type="text" class="form-control input-modal" id="name" name="name"
                            aria-describedby="name_help" placeholder="Juan">
                        <span class="text-danger createmodal_error" id="name_error"></span>
                    </div>
                    <div class="w-100">
                        <label for="" class="form-label">Apellido </label>
                        <input type="text" class="form-control input-modal" id="lastname" lastname="lastname"
                            aria-describedby="lastname_help" placeholder="Perez">
                        <span class="text-danger createmodal_error" id="lastname_error"></span>
                    </div>
                </div>
                <div class="d-flex gap-4 mb-4">
                    <div class="w-100">
                        <label for="" class="form-label"><i class="fa-solid fa-envelope me-2"></i>Correo electrónico </label>
                        <input type="text" class="form-control input-modal" id="mail" mail="mail"
                            aria-describedby="mail_help" placeholder="juanperez@gmail.com">
                        <span class="text-danger createmodal_error" id="mail_error"></span>
                    </div>
                    <div class="w-100">
                        <label for="" class="form-label"><i class="fa-solid fa-phone me-2"></i>Teléfono </label>
                        <div class=" input-group">
                        <span class="input-group-text">+56</span>
                        <input type="text" class="form-control input-modal" id="number" number="number"
                            aria-describedby="number_help" placeholder="912312312">
                        <span class="text-danger createmodal_error" id="number_error"></span>
                    </div>
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
            <input class="form-check-input fs-5" type="radio" name="delivery" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">
                <h4 class="m-0 ms-2" ><i class="fa-solid fa-house me-2"></i>Retiro en sucursal</h4>
            </label>
        </div>
            <div class="form-check w-100 align-center">
                <input class="form-check-input fs-5" type="radio" name="delivery" id="flexRadioDefault2" checked>
                <label class="form-check-label" for="flexRadioDefault2">
                    <h4 class="m-0 ms-2"><i class="fa-solid fa-person-biking me-2"></i>Despacho a domicilio</h4>
            </label>
</div>
        </div>
    
    </div>
</div>
<div class="row gap-3">
    <div class="bg-white shadow p-3 mt-5 col">
        <h3 class="m-0">Tú pedido</h3>
        <hr>
        <div class="" id="cartContainer" style="overflow-y: scroll; height:500px;">
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
        <h3 class="m-0">Resumen pedido</h3>
        <hr>
        <div class="" >
          <h5>Subtotal: <span id="totalCart"></span> </h5>
          <hr>
          <a class="btn bgColor text-white buttonHover">Confirmar pedido</a>
        </div>
    
    </div>
</div>

{{--  --}}
@endsection

@section('js_after')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
        fullfillCart()
    });
    

    function fullfillCart(){
        $("#cartContainer").empty();
        let productos = JSON.parse(localStorage.getItem('cart'));
        if(productos.length === 0)  window.location.href = "/";
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
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: `Se eliminó ${e.name_product}`,
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })                    
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
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: `No hay más unidades de ${e.name_product}`,
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                }
            }
        })
        localStorage.setItem('cart', JSON.stringify(cart));
        fullfillCart();
    }
    
</script>
@endsection
@extends('layouts.app')

@section('content')
        <div class="row justify-content-center m-0 p-0 overflow-hidden">
            <div class="backgroundRegister col-md-4 d-none d-md-block m-0 p-0"></div>
            <div class="col-md-8 col-8 align-self-center m-0 p-0">
                <h3 class="text-center fw-bold mb-5">Registro</h3>
                        <form method="POST" onsubmit="createUser(event)" enctype="multipart/form-data" class="m-0 p-0">
                            @csrf
                            <div class="row mb-3">                                
                                <div class="col-md-6 mx-auto">
                                    <label for="name" class="">{{ __('Nombre') }}</label>
                                    <input id="name" type="text" class="form-control input-modal"
                                        name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                                     <span class="text-danger createmodal_error" id="name_error"></span>
                                        

                                </div>
                            </div>

                            <div class="row mb-3">                            
                                <div class="col-md-6 mx-auto">
                                    <label for="email"
                                    class="">{{ __('Correo electrónico') }}</label>
                                    <input id="email" type="text" class="form-control input-modal"
                                        name="email" value="{{ old('email') }}"  autocomplete="email">
                                        <span class="text-danger createmodal_error" id="email_error"></span>

                                </div>
                            </div>

                            <div class="row mb-3">                            
                                <div class="col-md-6 mx-auto ">
                                    <label for="email"
                                    class="">{{ __('Dirección') }}</label>
                                    <input id="address" type="text" class="form-control input-modal"
                                        name="address" value="{{ old('address') }}"  autocomplete="address">
                                        <span class="text-danger createmodal_error" id="address_error"></span>

                                </div>
                            </div>

                            <div class="row mb-3">  
                                                   
                                <div class="col-md-6 mx-auto">
                                    <label for="phone"
                                    class="">{{ __('Número') }}</label> 
                                    <div class="input-group ">
                                        <span class="input-group-text" id="basic-addon1">+56</span>
                                        <input id="phone" type="text" class="form-control input-modal"
                                            name="phone" value="{{ old('phone') }}"  autocomplete="phone" aria-describedby="basic-addon1">

                                    </div>
                                    <span class="text-danger createmodal_error" id="phone_error"></span>
                                </div>
                            </div>

                            <div class="row mb-3">                              
                                <div class="col-md-6 mx-auto">
                                    <label for="password"
                                    class="">{{ __('Contraseña') }}</label>
                                    <div class="d-flex">
                                        <input id="password" type="password"
                                            class="form-control input-modal" name="password"
                                             autocomplete="new-password">
                                                                    <button onclick="showPasword(event)" id="showPasswordBtn" class="me-2 btn"><i class="fa-solid fa-eye-slash fa-xl"></i></button>
                                    </div>

                                         <span class="text-danger createmodal_error" id="password_error"></span>

                                </div>
                            </div>

                            <div class="row mb-3">                                
                                <div class="col-md-6 mx-auto">
                                    <label for="password-confirm"
                                    class="">{{ __('Confirmar contraseña') }}</label>
                                    <input id="password-confirm" type="password" class="form-control "
                                        name="password_confirmation"  autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 mx-auto">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ __('Registrar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
            </div>
        </div>

        @section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
         // ****************************************************************************************************************
        //CREAR USUARIO
        // ****************************************************************************************************************
        const createUser = (e) => {
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            var url = '{{ route('user.store') }}';
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response, jqXHR) {
                    window.location.replace("http://127.0.0.1:8000/login");

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
                        title: "Ocurrió un error",
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                    //AGREGA LAS CLASES Y ELEMENTOS DE INVALID
                    if (text) {
                        $.each(text.errors, function(key, item) {
                            $("#" + key + "_error").append("<span class='text-danger'>" +
                                item + "</span>")
                            $(`#${key}`).addClass('is-invalid');
                        });
                    }
                    //////////////////////////////////////

                }

            });
        }

        const showPasword = (e) =>{
    e.preventDefault()
    let inputType = $('#password').attr('type');
    if(inputType === 'password'){
        $('#password').attr('type','text');
        $('#password-confirm').attr('type','text');
        $('#showPasswordBtn').empty()
        $('#showPasswordBtn').append('<i class="fa-solid fa-eye fa-xl"></i>')
    } 
    else {
        $('#password').attr('type','password');
        $('#password-confirm').attr('type','password');
        $('#showPasswordBtn').empty()
        $('#showPasswordBtn').append('<i class="fa-solid fa-eye-slash fa-xl"></i>')
    } 
   
}
        
        </script>
        @endsection
   
@endsection

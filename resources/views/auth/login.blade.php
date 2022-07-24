@extends('layouts.app')
@section('content')
        <div class="row justify-content-center m-0 p-0 gx-0 gy-0 overflow-hidden">
            <div class="col-lg-6 backgroundLogin d-none d-lg-block p-0 m-0" ></div>
            <div class="col-lg-6 col-8 align-self-center m-0 p-0 order-1" >
                <div class="w-100 text-center"><img style="width: 200px;height:200px;" class="mx-auto" src="{{ asset('storage/files/Logo.png') }}" alt=""></div>
                <div class="">
                    <div class="row justify-content-center" >
                        <form method="POST" action="{{route('login')}}" class="m-0 p-0" id="login">
                            @csrf

                            <div class="mb-3">
                                <div class="col-lg-6 mx-auto ">
                                    <label for="email"
                                    class="form-label mx-auto">{{ __('Correo electrónico') }}</label>
                                    <input id="email" type="text" class="form-control input-modal loginFail {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>
                                        <span class="text-danger createmodal_error" id="email_error"></span>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="">                        
                                <div class="col-lg-6 mx-auto">
                                    <label for="password"
                                    class="form-label mx-auto">{{ __('Contraseña') }}</label>
                                    <input id="password" type="password"
                                        class="form-control input-modal loginFail {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                         autocomplete="current-password">
                                         @error('password')
                                         <span class="invalid-feedback" role="alert">
                                             <strong>{{ $message }}</strong>
                                         </span>
                                     @enderror
                                           
                                        </span>
                          
                                </div>
                            </div>
                                <div class="col-lg-6 mx-auto text-start">
                                    <a class="btn btn-link text-start m-0 p-0 mb-3" href="{{ route('password.request') }}">
                                        {{ __('Olvidaste tu contraseña?') }}
                                    </a>
                                </div>
                            {{-- <div class="row mb-3">
                                                        <div class="col-md-6 offset-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                                <label class="form-check-label" for="remember">
                                                                    {{ __('Recordar') }}
                                                                </label>
                                                            </div>
                                                        </div>
                             </div>  --}}

                            <div class=" mb-0 mx-auto">
                                <div class="col-lg-6 text-start-md text-center mx-auto">
                                    <button type="submit" class="btn btn-danger text-white px-5 py-1 w-100">
                                        {{ __('Entrar') }}
                                    </button>
                                 
                                </div>
                                <div class="col-md-6 text-start-md text-center mx-auto w-100">
                                        <div class="btn p-0 mt-2 w-100" >
                                            No eres miembro ?
                                            <a class=""
                                                href="{{ route('user.index') }}">{{ __('Registrate ahora') }}</a>
                                        </div>
                                        <div class="flex items-center justify-end mt-5 mb-5">
                                            <a href="{{ route('login.google') }}" class="text-decoration-none border border-primary rounded px-3 py-2">
                                                <img src="{{asset("storage/images/googleLogo.svg")}}" class="me-2">
                                                <span class=" ">Iniciar sesión con Google</span>
                                            </a>
                                        </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @section('js_after')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
             // ****************************************************************************************************************
            //CREAR USUARIO
            // ****************************************************************************************************************
            const checkUser = (e) => {
                e.preventDefault();
                var data = $("#login").serializeArray();
                console.log(data)
                var url = '{{ route('user.login') }}';
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    cache: false,
     
                    success: function(response, jqXHR) {
                        console.log(response.redirect)
                        window.location.replace(`${response.redirect}`);
    
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        var text = jqXHR.responseJSON;
                        console.log(text)
                        //LIMPIA LAS CLASES Y ELEMENTOS DE INVALID
                        $(".createmodal_error").empty()
                        $(".loginFail").empty()
                        $(".input-modal").removeClass('is-invalid')
                        //////////////////////////////////////////
                        // var toastMixin = Swal.mixin({
                        //     toast: true,
                        //     position: 'bottom-right',
                        //     showConfirmButton: false,
                        //     timer: 3000,
                        //     timerProgressBar: true,
                        //     didOpen: (toast) => {
                        //     toast.addEventListener('mouseenter', Swal.stopTimer)
                        //     toast.addEventListener('mouseleave', Swal.resumeTimer)
                        //     }
                        // });
                        // toastMixin.fire({
                        //     title: 'Ocurrió un error',
                        //     icon: 'error'
                        // });
                        //AGREGA LAS CLASES Y ELEMENTOS DE INVALID
                        if (text) {
                            $.each(text.errors, function(key, item) {
                                $("#" + key + "_error").append("<span class='text-danger'>" +
                                    item + "</span>")
                                $(`#${key}`).addClass('is-invalid');

                                $(`.${key}`).addClass('is-invalid');
                                $(`.${key}`).append("<span class='text-danger'>" +
                                    item + "</span>")
                            });
                        }
                        //////////////////////////////////////
    
                    }
    
                });
            }
            </script>
            @endsection
    
@endsection


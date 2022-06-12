@extends('layouts.app')
@section('content')
        <div class="row justify-content-center m-0 p-0 gx-0 gy-0 overflow-hidden">
            <div class="col-lg-6 backgroundLogin d-none d-lg-block p-0 m-0" ></div>
            <div class="col-lg-6 align-self-center m-0 p-0 order-1" >
                <div class="w-100 text-center"><img style="width: 200px;height:200px;" class="mx-auto" src="https://tolivmarket-production.s3.sa-east-1.amazonaws.com/companies/logos/8a17cb17fcb7d1012e47f83078ee24b603fd0fa1d9628ad486d5cb43bacbb81c.jpg" alt=""></div>
                <div class="">
                    <div class="row justify-content-center" >
                        <form method="POST" action="{{ route('login') }}" class="m-0 p-0">
                            @csrf

                            <div class="mb-3">
                                <div class="col-lg-6 mx-auto ">
                                    <label for="email"
                                    class="form-label mx-auto">{{ __('Correo electrónico') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                                <div class="col-lg-6 mx-auto text-start">
                                    <a class="btn btn-link text-start m-0 p-0 mb-3" href="#">
                                        {{ __('Olvidaste tu contraseña?') }}
                                    </a>
                                </div>
                            <!-- <div class="row mb-3">
                                                        <div class="col-md-6 offset-md-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                                <label class="form-check-label" for="remember">
                                                                    {{ __('Recordar') }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div> -->

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
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

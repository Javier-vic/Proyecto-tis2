@extends('layouts.app')

@section('content')
<div class="row justify-content-center m-0 p-0 overflow-hidden">
    <div class="backgroundRegister col-md-4 d-none d-md-block m-0 p-0"></div>
    <div class="col-md-8 col-8 align-self-center m-0 p-0">
        <h3 class="text-center fw-bold mb-5">Recuperar contraseña</h3>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="row mb-3">
                <label for="email"
                    class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                <div class="col-md-6">
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ $email ?? old('email') }}"  autocomplete="email"
                        autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="password"
                    class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror" name="password"
                         autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="password-confirm"
                    class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contraseña') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control"
                        name="password_confirmation"  autocomplete="new-password">
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Cambiar contraseña') }}
                    </button>
                </div>
            </div>
        </form>
        @if(Session::get('status')!=null)
            <div class="alert alert-primary d-flex align-items-center mx-auto my-4" style="width:fit-content;" role="alert">
                <div>
                    {{Session::get('status')}}
                </div>
          </div>
        @endif
    </div>
</div>
@endsection

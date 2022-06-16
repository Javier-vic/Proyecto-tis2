@extends('layouts.userNavbar')

@section('content')
        <form action="{{route('user.update, ['user'=>$userData->id]')}}" method="POST" enctype="multipart/form-data" id="formEdit">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="" class="form-label">Nombre </label>
                <input type="text" class="form-control input-modal" id="name" name="name"
                    aria-describedby="name_help" value="{{$userData->name}}">
                <span class="text-danger createmodal_error" id="name_product_error"></span>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Email </label>
                <input type="text" class="form-control input-modal" id="email" name="email"
                    aria-describedby="email_help" value="{{$userData->email}}">
                <span class="text-danger createmodal_error" id="email_error"></span>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Dirección</label>
                <input type="text" class="form-control input-modal" id="address" name="address"
                    aria-describedby="address_help" value="{{$userData->address}}">
                <span class="text-danger createmodal_error" id="address_error"></span>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Numero </label>
                <input type="text" class="form-control input-modal" id="phone" name="phone"
                    aria-describedby="phone_help" value="{{$userData->phone}}">
                <span class="text-danger createmodal_error" id="phone_error"></span>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="passwordCheckbox">
                <label class="form-check-label" for="passwordCheckbox">
                  ¿Deseas cambiar tu contraseña? 
                </label>
            </div>

            <div id="passwordContainer">
                <div class="mb-3">
                    <label for="" class="form-label">Nueva contraseña </label>
                    <input type="password" class="form-control input-modal" id="password" name="password"
                        aria-describedby="password_help" >
                    <span class="text-danger createmodal_error" id="password_error"></span>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Confirmar contraseña </label>
                    <input type="password" class="form-control input-modal" id="passwordConfirm" name="passwordConfirm"
                        aria-describedby="passwordConfirm_help" >
                    <span class="text-danger createmodal_error" id="passwordConfirm_error"></span>
                </div>
            </div>
            <button type="submit" class="btn bgColor buttonHover text-white mt-5">Guardar</button>
        </form>


@endsection

@section('js_after')
<script type="text/javascript">

$( document ).ready(function() {
    cartQuantity()

        
});


</script>
@endsection
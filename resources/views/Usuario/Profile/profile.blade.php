@extends('layouts.userNavbar')

@section('content')
    <div class="card-body bg-white rounded p-5 shadow mt-3">
        <form onsubmit="editProfile(event)" enctype="multipart/form-data" id="formEdit">
            @csrf
            @method('PATCH')
            <meta name="csrf-token" content="{{ csrf_token() }}" />
            <div class="mb-4">
                <label for="" class="form-label">Nombre </label>
                <input type="text" class="form-control input-modal" id="name" name="name"
                    aria-describedby="name_help" value="{{ $userData->name }}" placeholder="Juan Elías Perez Monsalves">
                <span class="text-danger createmodal_error" id="name_product_error"></span>
            </div>
            <div class="mb-4">
                <label for="" class="form-label">Email </label>
                <input type="text" class="form-control input-modal" id="email" name="email"
                    aria-describedby="email_help" value="{{ $userData->email }}" placeholder="juanperez@gmail.com">
                <span class="text-danger createmodal_error" id="email_error"></span>
            </div>
            <div class="mb-4">
                <label for="" class="form-label">Dirección</label>

                <input type="text" class="form-control input-modal" id="address" name="address"
                    aria-describedby="address_help" value="{{ $userData->address }}"
                    placeholder="Calle colón #341, Chillán">
                <p class="text-muted">*Entre más detalles de tu dirección tales cómo n° de calle, sector , etc , será mejor
                    para la satisfactoria entrega de tú compra</p>
                <span class="text-danger createmodal_error" id="address_error"></span>
            </div>
            <div class="mb-4">
                <label for="" class="form-label">Numero </label>
                <div class="input-group">
                    <span class="input-group-text">+56</span>
                    <input type="text" class="form-control input-modal" id="phone" name="phone"
                        aria-describedby="phone_help" value="{{ $userData->phone }}">
                </div>
                <span class="text-danger createmodal_error" id="phone_error"></span>
            </div>
            <div class="form-check">
                <input class="form-check-input checkbox_check" type="checkbox" value="" id="passwordCheckbox"
                    onclick="checkboxStatus()">
                <label class="form-check-label" for="passwordCheckbox">
                    ¿Deseas cambiar tu contraseña?
                </label>
            </div>
            <div id="passwordContainer" class="d-none">
                <div class="mb-4">
                    <label for="" class="form-label">Nueva contraseña </label>
                    <div class="d-flex">
                        <input type="password" class="form-control input-modal" id="password" name="password"
                            aria-describedby="password_help" value="empty">
                        <button onclick="showPasword(event)" id="showPasswordBtn" class="me-2 btn"><i
                                class="fa-solid fa-eye-slash fa-xl"></i></button>
                    </div>
                    <span class="text-danger createmodal_error" id="password_error"></span>

                </div>
                <div class="mb-4">
                    <label for="" class="form-label">Confirmar contraseña </label>
                    <input type="password" class="form-control input-modal" id="passwordConfirm" name="passwordConfirm"
                        aria-describedby="passwordConfirm_help" value="empty">
                    <span class="text-danger createmodal_error" id="passwordConfirm_error"></span>
                </div>
            </div>
            <button type="submit" class="btn bgColor buttonHover text-white mt-5">Guardar</button>
        </form>
    </div>
@endsection

@section('js_after')
    <script type="text/javascript">
        $(document).ready(function() {
            cartQuantity()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (localStorage.getItem("success")) {
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: 'El perfil se actualizó correctamente',
                    showConfirmButton: false,
                    timer: 2000,
                    backdrop: false
                })
                localStorage.removeItem("success")
            }
        });

        const editProfile = (e) => {
            e.preventDefault();
            // var data = $("#formEdit").serializeArray();
            var formData = new FormData(e.currentTarget);
            formData.append('_method', 'patch');
            const userData = @json($userData);
            var url = '{{ route('user.update.profile', ':user') }}';
            url = url.replace(':user', userData.id);
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    localStorage.setItem("success", 'Actualización correcta');
                    location.reload()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var text = jqXHR.responseJSON;
                    //LIMPIA LAS CLASES Y ELEMENTOS INVALID  
                    $(".createmodal_error").empty()
                    $(".input-modal").addClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    //////////////////////////////////////////////
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: text.message,
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                    //AGREGA CLASES Y ELEMENTOS INVALID  
                    if (text.errors) {
                        $.each(text.errors, function(key, item) {
                            $("#" + key + "_error").append(
                                "<span class='text-danger'>" + item + "</span>")
                            $(`#${key}`).addClass('is-invalid');
                        });
                    }
                    //////////////////////////////////////////////
                }

            })
        }

        const checkboxStatus = () => {
            if ($('#passwordCheckbox').is(':checked')) {
                $('#passwordContainer').removeClass('d-none')
                $('#password').val('')
                $('#passwordConfirm').val('')

            } else {
                $('#passwordContainer').addClass('d-none')
                $('#password').val('empty')
                $('#passwordConfirm').val('empty')


            }
        }

        const showPasword = (e) => {
            e.preventDefault()
            let inputType = $('#password').attr('type');
            if (inputType === 'password') {
                $('#password').attr('type', 'text');
                $('#passwordConfirm').attr('type', 'text');
                $('#showPasswordBtn').empty()
                $('#showPasswordBtn').append('<i class="fa-solid fa-eye fa-xl"></i>')
            } else {
                $('#password').attr('type', 'password');
                $('#passwordConfirm').attr('type', 'password');
                $('#showPasswordBtn').empty()
                $('#showPasswordBtn').append('<i class="fa-solid fa-eye-slash fa-xl"></i>')
            }

        }
    </script>
@endsection

@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection
@section('titlePage')
    <h2 class="">Horarios de atención</h2>
@endsection

@section('content')
    <div>
        <div>@include('Mantenedores.local_status.modal.create')</div>
    </div>
    <div>
        <button class="btn btn-primary" onclick="toggleModal(event)">Cambiar horarios</button>
    </div>
    <div class="row mt-5 text-center">
        @foreach ($localStatus as $data)
            <div class="col">
                <h2>Apertura de la página</h2>
                <h1 id="localOpening">{{ $data->opening }} hrs.</h1>
            </div>
            <div class="col">
                <h2>Cierre de la página</h2>
                <h1 id="localClosing">{{ $data->closing }} hrs.</h1>
            </div>
            {{-- <div>La tienda se encuentra abierta por <span id="localHours"></span></div> --}}
        @endforeach
    </div>
@endsection

@section('js_after')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {


        })
        const toggleModal = (e) => {
            e.preventDefault();
            $('#localStatus').modal('show');
        }
        ////////////////////////////////////
        //FLATPICKR//////////////////////////////////////
        let opening = $("#opening").flatpickr({
                noCalendar: true,
                enableTime: true,
                dateFormat: 'H:i',

            }

        );

        let closing = $("#closing").flatpickr({
            noCalendar: true,
            enableTime: true,
            dateFormat: 'H:i',
        });
        //////////////////////////////////////
        //*                               +//
        //////////////////////////////////////

        //IDIOMA PARA FLATPICKR//////////////////////////////////////
        function locale() {
            return {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                },
                months: {
                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                    longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                        'Octubre', 'Noviembre', 'Diciembre'
                    ],
                }
            };
        }
        //


        //FUNCIÓN PARA MODIFICAR HORARIOS
        const modifyStatus = (e) => {
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            var url = '{{ route('map.saveStatus') }}';


            Swal.fire({
                title: '¿Los horarios de atención están correctos?',
                text: `Horario apertura : ${formData.get('opening')} | Horario Cierre : ${formData.get('closing')}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, modificar!',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response, jqXHR) {
                            console.log(response)
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'success',
                                title: 'Se modificó el horario correctamente.',
                                showConfirmButton: false,
                                timer: 2000,
                                backdrop: false,
                                heightAuto: false,
                            })

                            let opening = formData.get('opening');
                            let closing = formData.get('closing');
                            $('#localOpening').empty()
                            $('#localOpening').append(opening)
                            $('#localClosing').empty()
                            $('#localClosing').append(closing)
                            $('#localStatus').modal('hide');



                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            var text = jqXHR.responseJSON;
                            $(".createmodal_error").empty()
                            $(".input-modal").addClass('is-valid')
                            $(".input-modal").removeClass('is-invalid')
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'error',
                                title: "No se pudo modificar el horario.",
                                showConfirmButton: false,
                                timer: 2000,
                                backdrop: false
                            })
                            //AGREGA LAS CLASES Y ELEMENTOS DE INVALID
                            if (text) {
                                $.each(text.errors, function(key, item) {
                                    $("#" + key + "_errorCREATEMODAL").append(
                                        "<span class='text-danger'>" +
                                        item + "</span>")
                                    $(`#${key}`).addClass('is-invalid');
                                    $(`.${key}`).addClass('is-invalid');
                                });
                            }
                            //////////////////////////////////////

                        }
                    });
                }

            })


        }
        //////////////////////////////////////
    </script>
@endsection

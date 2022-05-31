@extends('layouts.navbar')
@section('css_extra')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

{{-- OCULTA LAS FLECHAS DE LOS INPUT NUMBER --}}
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
{{--  --}}
@endsection

@section('content')
<div id="number">0</div>

<button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#agregarCupon">
    Crear cupón
</button>
    <div>@include('Mantenedores.coupon.modal.create')</div>
    <div class="block-content block-content-full block-content-sm bg-body-dark mb-2">
        <input type="text" id="search" class="form-control form-control-alt" autocomplete="off" placeholder="Buscar...">
    </div>
    <table id="myTable" class="responsive display nowrap" style="width: 100%;">
        <thead class="bg-secondary text-white">
            <tr class="text-center">
                <th class="py-2" style="width:10%">Descuento</th>
                <th class="py-2" style="width:10%">Caduca</th>
                <th class="py-2" style="width:10%">Emitido</th>
                <th class="py-2" style="width:10%">Cantidad</th>
                <th class="py-2" style="width:10%">Acciones</th>
            </tr>
        </thead>
    </table>
      
@endsection

@section('js_after')
    <script   script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
    
<script type="text/javascript">
            //CREACIÓN DATATABLE
            var table = $("#myTable").DataTable({
                bProcessing: true,
                bStateSave: true,
                deferRender: true,
                responsive: true,
                processing: true,
                searching: true,
                language: {
                    url: "{{ asset('js/language.json') }}"
                },

                ajax: {
                    url: "{{ route('coupon.index') }}",
                    type: 'GET',
                },
                // language: {
                //     url: "{{ asset('js/plugins/datatables/spanish.json') }}",
                // },
                dom: "<'row d-flex justify-content-between'<'col-sm-12 col-md-4 d-none d-md-block'l><'col-sm-12 col-md-3 text-right'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4 d-none d-md-block'i><'col-sm-12 col-md-7'p>>",

                columns: [
                    {
                        data: 'percentage',
                        name: 'percentage'
                    },
                    {
                        data: 'caducity',
                        name: 'caducity',
                        render(data, type, row, meta) {
                            return moment(data).locale('es').format('LL');
                        }
                    },
                    {
                        data: 'emited',
                        name: 'emited',
                        render(data, type, row, meta) {
                            return moment(data).locale('es').format('LL');
                        }
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false, 
                        searchable: false

                    },
                ],
                initComplete: function(settings, json) {

                    document.getElementById("number").innerHTML = table.data().count();
                },
                select: true
            });

    //FUNCIÓN PARA LA BARRA DE BUSQUEDA
    $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });

    //FUNCIÓN PARA CREAR CUPÓN
    const createCoupon = (e) => {
        e.preventDefault();
        var formData = new FormData(e.currentTarget);
            var  url = '{{ route("coupon.store") }}';
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
                        title: 'Se creó el cupón correctamente.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,
                        heightAuto:false,
                    })
                    table.ajax.reload();
                    $('#agregarCupon').modal('hide');  
 
                    },
                   error: function( jqXHR, textStatus, errorThrown ) {
                    var text = jqXHR.responseJSON;
                    console.log(text)
                    $(".createmodal_error").empty()
                    $(".input-modal").addClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: "No se pudo crear el nuevo cupón.",
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                    //AGREGA LAS CLASES Y ELEMENTOS DE INVALID
                    if(text){
                    $.each(text.errors, function(key,item){
                    $("#"+key+"_errorCREATEMODAL").append("<span class='text-danger'>"+item+"</span>")
                    $(`#${key}`).addClass('is-invalid');
                    $(`.${key}`).addClass('is-invalid');
                    });
                    }
                    //////////////////////////////////////

               }
            });
    }
     //////////////////////////////////////
     //ELIMINAR UN CUPÓN
     const deleteCoupon = (id) =>{
        Swal.fire({
            title: '¿Estás seguro de eliminar este cupón?',
            text: "No se puede revertir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Borrar!',
            cancelButtonText: 'Cancelar',
            }).then((result)=>{
            url = '{{ route("coupon.destroy", ":coupon") }}';
            url = url.replace(':coupon', id);
            if(result.isConfirmed){
                $.ajax({
                type: "DELETE",
                url: url,
                error: function( jqXHR, textStatus, errorThrown ) {
                   var text = jqXHR.responseText;
                   Swal.fire({
                       position: 'bottom-end',
                       icon: 'error',
                       title: text,
                       showConfirmButton: false,
                       timer: 2000,
                       backdrop: false
                   })
               },
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                    success: function(response) {
                        Swal.fire(
                                'Borrado!',
                                'El cupón ha sido eliminado.',
                                'success'
                            )
                        table.ajax.reload();

         

                    }
                });
            }
         
            })

     } 
     ////////////////////////////////////
    //FLATPICKR//////////////////////////////////////
   let emited = $("#emited").flatpickr({
        altInput: true,
        altFormat: 'j F, Y',
        dateFormat: 'd-m-Y',
        defaultDate: 'today',
        minDate : 'today',
        locale: locale(), //IDIOMA
        onChange: function(selectedDates, dateStr, instance) {
            caducity.set('minDate', dateStr);
            $(".caducity").removeClass('is-valid')

        },
    }
        
    );

   let caducity= $("#caducity").flatpickr({
        altInput: true,
        altFormat: 'j F, Y',
        dateFormat: 'd-m-Y',
        defaultDate: 'today',
        locale: locale(), //IDIOMA
        minDate : 'today',
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
          longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        }};
    }
    //

    // ****************************************************************************************************************
    //LIMPIA LOS INPUTS AL CERRAR UN MODAL
    // ****************************************************************************************************************
        $('#agregarCupon').on('hidden.bs.modal', function () {
            $(".input-modal").removeClass('is-invalid');
            $(".input-modal").removeClass('is-valid');
            $(".input-modal").val('');
            $(".createmodal_error").empty()
        })
</script>


@endsection
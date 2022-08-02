@extends('layouts.navbar')

@section('css_extra')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('titlePage')
<h2 class="">Trabajadores registrados</h2>
@endsection

@section('content')
    <table class="table" id="myTable" style="width: 100%">
        {!! Form::token() !!}
        <thead class="thead bg-secondary text-white">
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Fecha de incoporacion</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
    <div>
        @include('Mantenedores.worker.modal.modalCreate')
    </div>
    <div>
        @include('Mantenedores.worker.modal.modalEdit')
    </div>
    <div>
        @include('Mantenedores.worker.modal.modalAsist')
    </div>
@endsection

@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script   script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script>
        const Table = $("#myTable").DataTable({
            processing: true,
            serverSide: true,
            language: {
                    url: "{{ asset('js/language.json') }}"
            },
            ajax:{
                    url: "{{ route('datatable.workers') }}",
                    type: 'GET',
            },
            columnDefs:[
                {className:'text-center', targets:'_all'},
                
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                        text: 'Agregar trabajador',
                        className: 'btn btn-primary mb-2',
                        action: function ( e, dt, node, config ) {
                            $('#agregarTrabajador').modal('show');

                        },
                        init: function(api, node, config) {
                           $(node).removeClass('dt-button')
                        }
                    },
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0,1,2,3]
                        },
                        titleAttr: 'Exportar a PDF',
                        className: 'btn btn-danger mb-2',
                        text: '<i class="fa fa-file-excel"></i> PDF',
                        init: function(api, node, config) {
                           $(node).removeClass('dt-button')
                        }
                    },
                    {
                        extend: 'excel',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: [0,1,2,3]
                        },
                        titleAttr: 'Exportar a PDF',
                        className: 'btn btn-success mb-2',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        init: function(api, node, config) {
                           $(node).removeClass('dt-button')
                        }
                    }
                ],
                
            columns:[
                {data:'name',name:'name'},
                {data:'email',name:'email'},
                {data:'name_role',name:'name_role'},
                {data:'created_at',name:'created_at',render(data){ return moment(data).locale('es').format('LL');}},
                {data:'action',name:'action',orderable:false,searchable:true}
            ],
        }); 
        const saveWorker = (e) => {
            e.preventDefault();
            var data = $("#postForm").serializeArray();
            $.ajax({
                type: "POST",
                url: "{{route('worker.store')}}",
                data: data,
                dataType: "text",
                success: function (response) {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: response,
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,
                        heightAuto:false,
                    })
                    $(".input-modal").removeClass('is-invalid');
                    $(".input-modal").removeClass('is-valid');
                    $('#postForm')[0].reset();
                    $(".createmodal_error").empty()
                    $('#agregarTrabajador').modal('hide');
                    Table.ajax.reload();
                },
                error: (jqXHR) => {
                    $(".createmodal_error").empty();
                    $(".input-modal").addClass('is-valid');
                    $(".input-modal").removeClass('is-invalid');
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: "No se pudo realizar el ingreso del producto.",
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    });
                    var errors = JSON.parse(jqXHR.responseText).errors;
                    $.map(errors, function (e,key) {
                        $(`#${key}_errorCREATEMODAL`).text(e);
                        $(`#${key}`).addClass('is-invalid');
                    });
                }
            });
        }
        const editWorker = (id) =>{
            $.ajax({
                type: "GET",
                url: "{{route('worker.getWorker')}}",
                data: {id: id},
                dataType: "json",
                success: function (response) {
                    $("#nameEdit").val(response[0].name);
                    $("#emailEdit").val(response[0].email);
                    $("#phoneEdit").val(response[0].phone);
                    $("#addressEdit").val(response[0].address);
                    $(`#editSelectRole${response[0].id_role}`).attr("selected",'selected');
                    $("#editTrabajador").modal('show');
                    $("#editForm").attr('onSubmit', `submitEdit(${id},event)`);
                }
            });
        }
        const submitEdit = (id,event) => {
            event.preventDefault();
            var data = $("#editForm").serializeArray();
            var url = '{{ route("worker.update", ":id") }}';
            url = url.replace(':id', id);
            $.ajax({
                type: "PUT",
                url: url,
                data: data,
                dataType: "text",
                success: function (response) {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: response,
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,
                        heightAuto:false,
                    })
                    Table.ajax.reload();
                    $(".input-modal").removeClass('is-invalid');
                    $(".input-modal").removeClass('is-valid');
                    $('#editForm')[0].reset();
                    $(".createmodal_error").empty()
                    $('#agregarTrabajador').modal('hide');
                    $("#editTrabajador").modal('hide');
                },
                error: (jqXHR) => {
                    $(".createmodal_error").empty();
                    $(".input-modal").addClass('is-valid');
                    $(".input-modal").removeClass('is-invalid');
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: "No se pudo realizar el ingreso del producto.",
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    });
                    var errors = JSON.parse(jqXHR.responseText).errors;
                    $.map(errors, function (e,key) {
                        $(`#${key}_errorEDITMODAL`).text(e);
                        $(`#${key}Edit`).addClass('is-invalid');
                    });
                }
            });
        }
        const deleteWorker = (id) =>{
            Swal.fire({
            title: '¿Estas seguro de eliminar al trabajador?',
            text: "No se puede revertir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Borrar!',
            cancelButtonText: 'Cancelar',
            }).then((res)=>{
                if(res.isConfirmed){
                    var url = '{{ route("worker.destroy", ":id") }}';
                    url = url.replace(':id', id);
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {"_token": "{{ csrf_token() }}"},
                        dataType: "text",
                        success: function (response) {
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'success',
                                title: response,
                                showConfirmButton: false,
                                timer: 2000,
                                backdrop: false,
                                heightAuto:false,
                            })
                            Table.ajax.reload();   
                        }
                    });
                }
            })
        }
        const asistByWorker = (id) => {
            $('#asistWorkerModal').modal('show');
            $('#submitAsistForm').attr('onSubmit', `submitAsistByWorker(${id},event)`);
        }
        const submitAsistByWorker = (id,e) => {
            e.preventDefault();
            var data = $('#submitAsistForm').serializeArray();
            var url = '{{ route("Asist.ByWorker", ":id") }}';
            url = url.replace(':id', id);
            $.ajax({
                type: "GET",
                url: url,
                data: data,
                dataType: "JSON",
                success: function (response) {
                    console.log(response)
                    Swal.fire({
                        title: `Horas trabajadas de: ${response.name_worker}`,
                        text: `${response[0].horas_trabajadas} horas.`,
                        footer: `Durante el mes de ${moment(response.date).locale('es').format("MMMM YYYY")}`
                    })
                }
            });
        }
    </script>
@endsection
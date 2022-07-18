@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection

@section('titlePage')
    <h2>Listado de insumos</h2>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div class="d-flex  justify-content-center">
        <a class="btn btn-success" href="{{ route('supply.import') }}"><i
                class="fa-solid fa-file-excel text-white me-2 "></i>Importar excel</a>
    </div>

    <table class="table" id="myTable" style="width: 100%">
        {!! Form::token() !!}

        <thead class="thead bg-secondary text-white">
            <tr>
                <th>Nombre de insumo</th>
                <th>Unidad de medida</th>
                <th>Cantidad</th>
                <th>Cantidad crítica</th>
                <th>Categoria</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <div class="">
            @include('Mantenedores.supply.modal.create')
        </div>
        <div class="">
            @include('Mantenedores.supply.modal.edit')
        </div>

    </table>
@endsection

@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
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
            dom: 'Bfrtip',
            ajax: {
                url: "{{ route('supply.index') }}",
                type: 'GET',
            },
            buttons: [{
                    text: 'Agregar insumo',
                    className: 'btn btn-primary mb-2',
                    action: function(e, dt, node, config) {
                        $('#agregarInsumo').modal('show');

                    }
                },
                {
                    extend: 'pdf',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1]
                    },
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger mb-2',
                    text: '<i class="fa fa-file-excel"></i> PDF'

                },
                {
                    extend: 'excel',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    exportOptions: {
                        columns: [0, 1]
                    },
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-success mb-2',
                    text: '<i class="fa fa-file-excel"></i> Excel'

                }

            ],
            columns: [{
                    data: 'name_supply',
                    name: 'name_supply'
                },
                {
                    data: 'unit_meassurement',
                    name: 'unit_meassurement'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'critical_quantity',
                    name: 'critical_quantity'
                },
                {
                    data: 'name_category',
                    name: 'name_category'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                }
            ],
            initComplete: function(settings, json) {
                $('.dt-button').removeClass('dt-button')
                // document.getElementById("number").innerHTML = table.data().count();
            },
            select: true
        });

        // ****************************************************************************************************************
        //MODAL DE CREAR
        // ****************************************************************************************************************   
        const addSupply = (e) => {
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            $.ajax({
                type: "POST",
                url: "{{ route('supply.store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response, jqXHR) {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: response,
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,
                        heightAuto: false,
                    })
                    //LIMPIA LAS CLASES Y ELEMENTOS DE INVALID
                    $(".createmodal_error").empty()
                    $(".input-modal").removeClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    //////////////////////////////////////////
                    $('#idname').val('');
                    table.ajax.reload();
                    $("#agregarInsumo").modal("hide");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var text = jqXHR.responseJSON
                    //LIMPIA LAS CLASES Y ELEMENTOS DE INVALID
                    $(".createmodal_error").empty()
                    $(".input-modal").addClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    //////////////////////////////////////////
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: 'No se pudo ingresar el nuevo insumo.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                    //AGREGA LAS CLASES Y ELEMENTOS DE INVALID
                    if (text) {
                        $.each(text.errors, function(key, item) {
                            $("#" + key + "_errorCREATEMODAL").append("<span class='text-danger'>" +
                                item + "</span>")
                            $(`#${key}`).addClass('is-invalid');
                        });
                    }
                    //////////////////////////////////////
                }
            });
        }

        const deleteSupply = (id) => {
            Swal.fire({
                title: '¿Estás seguro de eliminar este insumo?',
                text: "No se puede revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Borrar!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                url = '{{ route('supply.destroy', ':supply') }}';
                url = url.replace(':supply', id);
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        error: function(jqXHR, textStatus, errorThrown) {
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
                                'El insumo ha sido eliminado.',
                                'success'
                            )

                            table.ajax.reload();
                        }
                    });
                }

            })
        }

        const editSupply = (id) => {
            var url = '{{ route('supply.edit', ':supply') }}';
            url = url.replace(':supply', id)
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    let resultado = response[0][0];
                    $('#name_supplyEdit').val(resultado.name_supply);
                    $('#unit_meassurementEdit').val(resultado.unit_meassurement);
                    $('#quantityEdit').val(resultado.quantity);
                    $('#critical_quantityEdit').val(resultado.critical_quantity);
                    $('#id_category_suppliesEdit').val(resultado.id_category_supplies);

                    $("#formEdit").attr('onSubmit', `editSupplySubmit(${id},event)`);
                    $('#editSupply').modal('show');
                }

            });
        }

        const editSupplySubmit = (id, e) => {
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            formData.append('_method', 'put');
            var url = '{{ route('supply.update', ':supply') }}';
            url = url.replace(':supply', id);
            Swal.fire({
                title: '¿Estás seguro de editar este insumo?',
                text: "No se puede revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, editar!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            table.ajax.reload();
                            Swal.fire(
                                'Editado!',
                                'El insumo ha sido editado.',
                                'success'
                            )
                            $('#editSupply').modal('hide');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            var text = jqXHR.responseJSON;
                            //AGREGA CLASE DE VALID Y ELIMINA LAS DE INVALID
                            $(".editmodal_error").empty()
                            $(".input-modal").addClass('is-valid')
                            $(".input-modal").removeClass('is-invalid')
                            /////////////////////////////////////////////
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'error',
                                title: 'No se pudo editar el insumo.',
                                showConfirmButton: false,
                                timer: 2000,
                                backdrop: false
                            })
                            //AGREGA CLASES Y ELEMENTOS INVALID
                            if (text) {
                                $.each(text.errors, function(key, item) {
                                    $("#" + key + "_errorEDITMODAL").append(
                                        "<span class='text-danger'>" + item + "</span>")
                                    $(`#${key}Edit`).addClass('is-invalid');
                                });
                            }
                            //////////////////////////////
                        }
                    })
                }
            })
        }

        // ****************************************************************************************************************
        // ****************************************************************************************************************
        //LIMPIA LOS INPUTS AL CERRAR UN MODAL
        // ****************************************************************************************************************
        $('#agregarInsumo').on('hidden.bs.modal', function() {
            $(".input-modal").removeClass('is-invalid');
            $(".input-modal").removeClass('is-valid');
            $(".input-modal").val('');
            $(".createmodal_error").empty()
        })

        $('#editSupply').on('hidden.bs.modal', function() {
            $(".input-modal").removeClass('is-invalid');
            $(".input-modal").removeClass('is-valid');
            $(".input-modal").val('');
            $(".editmodal_error").empty()
        })

        // ****************************************************************************************************************
    </script>
@endsection

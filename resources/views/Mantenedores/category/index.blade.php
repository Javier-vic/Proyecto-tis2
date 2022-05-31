@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('titlePage')
    <h2 class="">Categorías de los productos</h2>
@endsection
@section('content')
    <div class="w-100 text-center">
        <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#agregarCategoria">
            Agregar categoría
        </button>
    </div>

    <!-- <div id="number"></div> -->

    <div>
        @include('Mantenedores.category.modal.create')
    </div>
    <div>
        @include('Mantenedores.category.modal.edit')
    </div>

    <table id="myTable" class="responsive display nowrap" style="width: 100%;">
        <thead class="bg-secondary text-white">
            <tr class="text-center">
                <th class="py-2" style="width:10%">Nombre</th>
                <th class="py-2" style="width:10%">Acciones</th>
            </tr>
        </thead>
    </table>
@endsection
@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>


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

            ajax: {
                url: "{{ route('category_product.index') }}",
                type: 'GET',
            },
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false

                },
            ],
            // initComplete: function(settings, json) {

            //     document.getElementById("number").innerHTML = table.data().count();
            // },
            select: true
        });

        $('#search').on('keyup', function() {
            table.search(this.value).draw();
        });







        // ****************************************************************************************************************
        //MODAL DE CREAR
        // ****************************************************************************************************************

        const createCategory = (e) => {
            e.preventDefault();
            var data = $("#formCreate").serializeArray();
            var url = '{{ route('category_product.store') }}';
            $.ajax({
                type: "POST",
                url: url,
                error: function(jqXHR, textStatus, errorThrown) {
                    var text = jqXHR.responseJSON;
                    $(".createmodal_error").empty()
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: 'No se pudo realizar el ingreso de la categoría.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })

                    //AGREGA CLASES Y ELEMENTOS INVALID  
                    if (text) {
                        $.each(text.errors, function(key, item) {
                            $("#" + key + "_errorCREATEMODAL").append("<span class='text-danger'>" +
                                item + "</span>")
                            $(`#${key}CREATEMODAL`).addClass('is-invalid');
                        });
                    }
                    //
                },
                data: data,
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
                    //QUITA LAS CLASES Y ELEMENTOS DE INVALID
                    $(`#nameCREATEMODAL`).removeClass('is-invalid');
                    $(".createmodal_error").empty()
                    //
                    $('#nameCREATEMODAL').val('');
                    table.ajax.reload();
                    $('#agregarCategoria').modal('hide');
                    // document.getElementById("number").innerHTML = table.data().count()+1;
                }

            });
        }
        // ****************************************************************************************************************
        //ENVÍA EDITAR CATEGORÍA
        // ****************************************************************************************************************

        const editCategorySubmit = (id, e) => {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro de editar esta categoría?',
                text: "No se puede revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, editar!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                var url = '{{ route('category_product.update', ':category_product') }}';
                url = url.replace(':category_product', id);
                if (result.isConfirmed) {
                    $.ajax({
                        type: "PUT",
                        url: url,
                        error: function(jqXHR, textStatus, errorThrown) {
                            var text = jqXHR.responseJSON;
                            $(".editmodal_error").empty()
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'error',
                                title: 'No se pudo editar la categoría.',
                                showConfirmButton: false,
                                timer: 2000,
                                backdrop: false
                            })
                            if (text) {
                                //AGREGA CLASES Y ELEMENTOS INVALID  
                                $.each(text.errors, function(key, item) {
                                    $("#" + key + "_errorEDITMODAL").append(
                                        "<span class='text-danger'>" + item + "</span>")
                                    $(`#${key}EDITMODAL`).addClass('is-invalid');

                                });
                                //
                            }

                        },
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "name": $('#nameEDITMODAL').val(),
                        },
                        success: function(response) {
                            table.ajax.reload();
                            //QUITA LAS CLASES Y ELEMENTOS DE INVALID
                            $(`#nameEDITMODAL`).removeClass('is-invalid');
                            $(".editmodal_error").empty()
                            //
                            Swal.fire(
                                'Editado!',
                                'La categoría ha sido editada.',
                                'success'
                            )
                            $('#editCategoria').modal('hide');
                        }

                    })


                    // $('#editCategoria').modal('hide');
                    // $('#stockEDITMODAL').val(resultado.stock)
                }
            });
        }

        // ****************************************************************************************************************


        // ****************************************************************************************************************
        // RELLENA EL MODAL DE EDITAR
        // ****************************************************************************************************************

        const editCategory = (id) => {

            $.ajax({
                type: "GET",
                url: "{{ route('category.product.modal.edit') }}",
                data: {
                    'id': id,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    let resultado = response[0][0];
                    $('#nameEDITMODAL').val(resultado.name);
                    $("#formEdit").attr('onSubmit', `editCategorySubmit(${id},event)`);
                    $('#editCategoria').modal('show');
                    // $('#stockEDITMODAL').val(resultado.stock)
                }

            });
        };

        // ****************************************************************************************************************
        //ELIMINAR UNA CATEGORÍA
        // ****************************************************************************************************************
        const deleteCategory = (id) => {
            Swal.fire({
                title: '¿Estás seguro de eliminar esta categoría?',
                text: "No se puede revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Borrar!',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                url = '{{ route('category_product.destroy', ':category_product') }}';
                url = url.replace(':category_product', id);
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire(
                                'Borrado!',
                                'La categoría ha sido borrada.',
                                'success'
                            )
                            // document.getElementById("number").innerHTML = table.data().count()-1;
                            table.ajax.reload();
                            // $('#editCategoria').modal('hide');
                            // $('#stockEDITMODAL').val(resultado.stock)

                        }
                    });
                }

            })
        }

        // ****************************************************************************************************************
        //LIMPIA LOS ERRORES DE LOS INPUTS EN LOS MODALES
        // ****************************************************************************************************************
        $('#agregarCategoria').on('hidden.bs.modal', function() {
            $(`#nameCREATEMODAL`).removeClass('is-invalid');
            $(".createmodal_error").empty()
        })

        $('#editCategoria').on('hidden.bs.modal', function() {
            $(`#nameEDITMODAL`).removeClass('is-invalid');
            $(".editmodal_error").empty()
        })
        //
        // ****************************************************************************************************************
    </script>
@endsection

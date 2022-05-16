@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarProducto">
        Agregar producto
    </button>
    {{-- <a role="button" class="btn btn-success mr-auto" href="{{ route('product.create') }}">
        <i class="fa fa-fw fa-plus mr-2"></i> Crear producto
    </a> --}}
    <div id="number"></div>
    <div id="valorIdPrueba" value="{{ $idActual }}">ID ACTUAL : {{ $idActual }}</div>
    @include('Mantenedores.product.modal.create')
    @include('Mantenedores.product.modal.show')
    @include('Mantenedores.product.modal.edit')

    <div class="block-content block-content-full block-content-sm bg-body-dark">
        <input type="text" id="search" class="form-control form-control-alt" autocomplete="off" placeholder="Buscar...">
    </div>
    <table id="myTable" class="display" style="width: 100%;">
        <thead class="bg-primary text-white">
            <tr class="text-center">
                <th class="py-2">ID</th>
                <th class="py-2">Stock</th>
                <th class="py-2">Nombre producto</th>
                <th class="py-2" style="width: 50px;">Acciones</th>
            </tr>
        </thead>
    </table>
@endsection
@section('js_after')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
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
                    url: "{{ route('product.index') }}",
                    type: 'GET',
                },
                // language: {
                //     url: "{{ asset('js/plugins/datatables/spanish.json') }}",
                // },
                dom: "<'row d-flex justify-content-between'<'col-sm-12 col-md-4 d-none d-md-block'l><'col-sm-12 col-md-3 text-right'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4 d-none d-md-block'i><'col-sm-12 col-md-7'p>>",

                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false,
                        searchable: false
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'name_product',
                        name: 'name_product'
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
            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });
            console.log(@json($idActual))


            //RELLENA EL MODAL DE VER DETALLES
            $(document).on("click", ".btn-view-producto", function() {
                valor_IDproducto = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('product.view') }}",
                    data: {
                        'id': valor_IDproducto,

                    },
                    dataType: "json",
                    success: function(response) {
                        var resultado = response[0][0];
                        $('#mostrarImagen').empty();
                        var url = '{{ asset('storage') . '/' . ':urlImagen' }}';
                        url = url.replace(':urlImagen', resultado.image_product);

                        $('#verProducto').modal('show');
                        $('#verProductoLabel').html(`${resultado.name_product}`)

                        $('#mostrarImagen').append($('<img>', {
                            src: url,
                            class: 'img-fluid'
                        }))

                        // $('#name_productVIEWMODAL').val(resultado.name_product) NOMBRE DEL PRODUCTO
                        $('#stockVIEWMODAL').val(resultado.stock)
                        $('#descriptionVIEWMODAL').val(resultado.description)
                        $('#category').val(resultado.category)
                    }
                });
            });
            //RELLENA EL MODAL DE EDITAR
            $(document).on("click", ".btn-edit-producto", function() {
                valor_IDproducto = $(this).val();


                console.log(valor_IDproducto);
                $.ajax({
                    type: "GET",
                    url: "{{ route('product.modal.edit') }}",
                    data: {
                        'id': valor_IDproducto,

                    },
                    dataType: "json",
                    success: function(response) {
                        var resultado = response[0][0];
                        $('#mostrarImagenEDITMODAL').empty();
                        console.log(resultado.category)
                        var url = '{{ asset('storage') . '/' . ':urlImagen' }}';
                        url = url.replace(':urlImagen', resultado.image_product);

                        $('#editProducto').modal('show');
                        $('#editProductoLabel').html(`${resultado.name_product}`)

                        $('#mostrarImagenEDITMODAL').append($('<img>', {
                            src: url,
                            class: 'img-fluid'
                        }))

                        $('#name_productEDITMODAL').val(resultado.name_product)
                        $('#stockEDITMODAL').val(resultado.stock)
                        $('#descriptionEDITMODAL').val(resultado.description)
                        $('#categoryEDITMODAL').val(resultado.category)
                        $('#idEDITMODAL').val(valor_IDproducto)
                        $('#urlImagen').val(resultado.image_product)
                        $('#valorIdPrueba').html(valor_IDproducto);
                        $('#valorIdPrueba').val(valor_IDproducto);

                    }
                });
            });
            // ****************************************************************************************************************

        })
    </script>
@endsection

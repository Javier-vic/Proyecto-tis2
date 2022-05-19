@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarCategoria">
        Agregar categoría
    </button>

    <div id="number"></div>
    @include('Mantenedores.category.modal.create')
    @include('Mantenedores.category.modal.edit')

    <div class="block-content block-content-full block-content-sm bg-body-dark">
        <input type="text" id="search" class="form-control form-control-alt" autocomplete="off" placeholder="Buscar...">
    </div>
    <table id="myTable" class="responsive display nowrap" style="width: 100%;">
        <thead class="bg-primary text-white">
            <tr class="text-center">
                <th class="py-2" style="width:10%">Nombre</th>
                <th class="py-2" style="width:10%">Acciones</th>
            </tr>
        </thead>
    </table>
@endsection
@section('js_after')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>

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
                    url: "{{ route('category_product.index') }}",
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
                initComplete: function(settings, json) {

                    document.getElementById("number").innerHTML = table.data().count();
                },
                select: true
            });

            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });



           // ****************************************************************************************************************
                //RELLENA EL MODAL DE EDITAR
            $(document).on("click", ".btn-edit-categoria", function() {
            valor_IDproducto = $(this).val();
            console.log(valor_IDproducto)
                $.ajax({
                type: "GET",
                url: "{{ route('category.product.modal.edit') }}",
                data: {
                    'id': valor_IDproducto,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                    success: function(response) {
                    console.log(response);
                        let resultado = response[0][0];
                 
                    $('#nameEDITMODAL').val(resultado.name);
                    $('#btnEDITMODAL').val(resultado.id);
                    $('#editCategoria').modal('show');
                    // $('#stockEDITMODAL').val(resultado.stock)

                    }
                });
            });
           // ****************************************************************************************************************
           //ENVÍA EL MODAL DE EDITAR
           $(document).on("click", ".btn-edit-categoria-enviar", function() {
            console.log('Valor del edit:',$(this).val())
            url = '{{ route("category_product.update", ":category_product") }}';
            url = url.replace(':category_product', $(this).val());
                $.ajax({
                type: "PUT",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                    success: function(response) {
                    console.log('SE ACTUALIZÓ');
                    console.log(response);
                    let resultado = response[0][0];
                    // $('#editCategoria').modal('hide');
  
                    
                    // $('#stockEDITMODAL').val(resultado.stock)

                    }
                });
            });

        });
        
    </script>
@endsection


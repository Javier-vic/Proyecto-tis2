@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div>
        @include('sweetalert::alert')
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarInsumo"> Agregar nuevo insumo</button>
    <table class="table" id="myTable" style="width: 100%">
    {!! Form::token() !!}

        <thead class="thead bg-secondary text-white">
            <tr>
                <th>#</th>
                <th>name_supply</th>
                <th>unit_meassurement</th>
                <th>quantity</th>
                <th>name_category</th>
                <th>acciones</th>
            </tr>
        </thead>

        <div class="">
            @include('Mantenedores.supply.modal.create')
        </div>
        <div class="">
            <!-- include('Mantenedores.supply.modal.edit') -->
        </div>

    </table>
@endsection

@section('js_after')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>

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
                    url: "{{ route('supply.index') }}",
                    type: 'GET',
                },
                dom: "<'row d-flex justify-content-between'<'col-sm-12 col-md-4 d-none d-md-block'l><'col-sm-12 col-md-3 text-right'B>>" +
                    "<'row '<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4 d-none d-md-block 'i><'col-sm-12 col-md-7'p>>",
                columns:[
                    {data:'id',name:'id'},
                    {data:'name_supply',name:'name_supply'},
                    {data:'unit_meassurement',name:'unit_meassurement'},
                    {data:'quantity',name:'quantity'},
                    {data:'id_category_supplies',name:'id_category_supplies'},
                    {data:'action',name:'action',orderable:false,searchable:true}
                ],
                select: true
        });

        const addSupply = (e) =>{
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            $.ajax({
                type: "POST",
                url: "{{route('supply.store')}}",
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
                        heightAuto:false,
                    })
                    $('#idname').val('');
                    Table.ajax.reload();
                    $("#agregarCategoriaInsumo").modal("hide");                   
                },
                error: function( jqXHR, textStatus, errorThrown ){                 
                    var text = jqXHR.responseText;
                    console.log(text)
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: text,
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                }
            });
        }
    </script>

@endsection
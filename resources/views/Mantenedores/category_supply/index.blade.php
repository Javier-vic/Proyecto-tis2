@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('content')
    <div>
        @include('sweetalert::alert')
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarCategoriaInsumo"> Agregar nueva categoria</button>
    <table class="table" id="myTable" style="width: 100%">
    {!! Form::token() !!}

        <thead class="thead">
            <tr>
                <th>#</th>
                <th>name_category</th>
                <th>acciones</th>
            </tr>
        </thead>
        
        

    </table>

    <div class="">
        @include('Mantenedores.category_supply.Modal.ModalCreate')
    </div>
    <div class="">
        <!-- include('Mantenedores.category_supply.modalViewPermits') -->
    </div>
    <div class="">
        @include('Mantenedores.category_supply.Modal.ModalEdit')
    </div>
@endsection

@section('js_after')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        const Table = $("#myTable").DataTable({
            processing: true,
            serverSide: true,
            language: {
                    url: "{{ asset('js/language.json') }}"
                },
            ajax:{
                    url: "{{ route('dataTable.CategorySupply') }}",
                    type: 'GET',
            },
            columns:[
                {data:'id',name:'id'},
                {data:'name_category',name:'name_category'},
                {data:'action',name:'action',orderable:false,searchable:true},
            ]
        });

        const capitalize = (s) => {
            if (typeof s !== 'string') return ''
            return s.charAt(0).toUpperCase() + s.slice(1)
        }

        const addCategorySupply = (e) =>{
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            // var data = $("#postForm").serializeArray();
            $.ajax({
                type: "POST",
                url: "{{route('category_supply.store')}}",
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
                    // $('#editCategoria').modal('hide');
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

        const editCategorySupply = (id) => {
            $.ajax({
                type: "GET",
                url: "{{route('permits.roles')}}",
                data: {'id': id,"_token": "{{ csrf_token() }}"},
                dataType: "json",
                success: (res) =>{
                    //console.log(json($permits));
                    //console.log(res);
                    $("#editName").val('');
                    $("#editName").val(`${res[0][0].name_role}`);
                    $("#editPermits").empty();
                    json($permits).map(e=>{
                        var check = false;
                        res[1].map(el=>{
                            (el.id==e.id) ? check=true: null;
                        })
                        $("#editPermits").append(
                        $($('<div>',{
                            class: 'form-check form-switch'
                        })).append(
                        $('<input>',{
                            class:'form-check-input',
                            name:'permits[]',
                            value:`${e.id}`,
                            type:'checkbox',
                            id:`${e.id}`,
                            checked: check
                        }))
                        .append($('<label>',{
                            class:'form-check-label',
                            for:'flexSwitchCheckDefault',
                            text:`${capitalize(e.tipe_permit)}`
                        }))
                        )
                    })
                    $("#editForm").attr('onSubmit', `submitEdit(${id},event)`);
                    $('#editRole').modal('show');
                }
            })
        }
        const submitEdit = (id,e) => {
            e.preventDefault();
            var url = '{{ route("roles.update", ":id") }}';
            url = url.replace(':id', id);
            var data = $("#editForm").serializeArray();
            console.log(data)
            $.ajax({
                type: "PUT",
                url: url,
                data: data,
                dataType: "json",
                success: function (response) {
                    console.log(response)        
                }
            });
            $('#editRole').modal('hide');
        }

        const deleteCategorySupply = (id) =>{
            Swal.fire({
            title: '¿Estás seguro de eliminar esta categoría?',
            text: "No se puede revertir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Borrar!',
            cancelButtonText: 'Cancelar',
            }).then((result)=>{
                url = '{{ route("category_supply.destroy", ":category_supply") }}';
                url = url.replace(':category_supply', id);
                if(result.isConfirmed){
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            console.log(response)
                            Swal.fire(
                                'Borrado!',
                                'La categoría ha sido borrada.',
                                'success'
                            )
                            Table.ajax.reload();
                        }
                    });
                }         
            })
        }
    </script> 

@endsection
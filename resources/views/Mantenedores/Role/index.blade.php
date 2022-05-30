@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    
@endsection
@section('content')
    <div class="row my-4">
        <div class="col d-flex justify-content-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarRol"> Agregar nuevo rol</button>
        </div>
    </div>
    <table class="table" id="myTable" style="width: 100%">
        {!! Form::token() !!}
        <thead class="thead bg-secondary text-white">
            <tr>
                <th>id</th>
                <th>Nombre del Rol</th>
                <th>Ver permisos</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
    <div class="">
        @include('Mantenedores.Role.modal.modal')
    </div>
    <div class="">
        @include('Mantenedores.Role.modal.modalViewPermits')
    </div>
    <div class="">
        @include('Mantenedores.Role.modal.ModalEditRole')
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
                    url: "{{ route('dataTable.Roles') }}",
                    type: 'GET',
            },
            columns:[
                {data:'id',name:'id'},
                {data:'name_role',name:'name_role'},
                {data:'viewPermits',name:'viewPermits',orderable:false,searchable:true},
                {data:'action',name:'action',orderable:false,searchable:true},
            ]
        });
        const capitalize = (s) => {
            if (typeof s !== 'string') return ''
            return s.charAt(0).toUpperCase() + s.slice(1)
        }
        const addRole = (e) =>{
            e.preventDefault();
            var data = $("#postForm").serializeArray();
            $.ajax({
                type: "POST",
                url: "{{route('roles.store')}}",
                data: data,
                dataType: "text",
                success: function (response) {
                    Table.ajax.reload();
                    $("#agregarRol").modal("hide");
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'El rol se registro correctamente.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,
                        heightAuto:false,
                    })
                },
                error: (jqXHR)=>{
                    var errors = JSON.parse(jqXHR.responseText).errors;
                    $.map(errors, function (e,key) {
                        $(`#${key}_errorCreate`).text(e);
                        $(`#${key}`).addClass('is-invalid');
                    });
                }
            });
        }
        const viewPermits = (id) => {
            $.ajax({
                type: "GET",
                url: "{{route('permits.roles')}}",
                data: {'id': id,"_token": "{{ csrf_token() }}"},
                dataType: "json",
                success: function (response) {
                    console.log(response[1]);
                    $('#viewPermits').modal('show')
                    $('#nombreRol').empty();
                    $('#nombreRol').html(`Permisos del Rol: ${response[0][0].name_role}`)
                    $('#ListPermits').empty();
                    response[1].map(e=>{
                        $('#ListPermits').append($('<li>',{
                            text:`${capitalize(e.tipe_permit)}`,
                            class:'list-group-item'
                        }));
                    })
                }
            });
        }
        const editRole = (id) => {
            $.ajax({
                type: "GET",
                url: "{{route('permits.roles')}}",
                data: {'id': id,"_token": "{{ csrf_token() }}"},
                dataType: "json",
                success: (res) =>{
                    //console.log(@json($permits));
                    //console.log(res);
                    $("#editName").val('');
                    $("#editName").val(`${res[0][0].name_role}`);
                    $("#editPermits").empty();
                    @json($permits).map(e=>{
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
        const deleteRole = (idRole) =>{
            Swal.fire({
            title: '¿Estas seguro?',
            text: "No se puede revertir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Borrar!',
            cancelButtonText: 'Cancelar',
            }).then((result)=>{
                var url = '{{ route("roles.destroy", ":id") }}';
                url = url.replace(':id', idRole);
                if(result.isConfirmed){
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {"_token": "{{ csrf_token() }}"},
                        dataType: "text",
                        success: function (response) {
                            Swal.fire(
                                'Borrado!',
                                'El rol ha sido borrado.',
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
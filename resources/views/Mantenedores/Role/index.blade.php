@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    
@endsection
@section('content')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarRol"> Agregar nuevo rol</button>
    <table class="table" id="myTable" style="width: 100%">
        {!! Form::token() !!}
        <thead class="thead">
            <tr>
                <th>id</th>
                <th>Nombre del Rol</th>
                <th>Ver permisos</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
    <div class="">
        @include('Mantenedores.Role.modal')
    </div>
    <div class="">
        @include('Mantenedores.Role.modalViewPermits')
    </div>
@endsection

@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        const Table = $("#myTable").DataTable({
            processing: true,
            serverSide: true,
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
        const editRole = (idRole) => {

        }
        const deleteRole = (idRole) =>{
            Swal.fire({
            title: '¿Estas seguro?',
            text: "No se puede revertir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
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
                            console.log('asd');
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
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
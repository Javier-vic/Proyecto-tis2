@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    
@endsection

@section('content')
    <a name="" id="" class="btn btn-primary" href="{{ route('roles.create')}}" role="button">Agregar un nuevo rol</a>
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
        const viewPermits = (id) => {
            $.ajax({
                type: "GET",
                url: "{{route('permits.roles')}}",
                data: {'id': id},
                dataType: "json",
                success: function (response) {
                    console.log(response);
                }
            });
            
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
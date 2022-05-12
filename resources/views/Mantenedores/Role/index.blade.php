@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('content')
    <a name="" id="" class="btn btn-primary" href="{{ route('roles.create')}}" role="button">Agregar un nuevo rol</a>
    <table class="table" id="myTable" style="width: 100%">
        <thead class="thead">
            <tr>
                <th>Nro</th>
                <th>id</th>
                <th>Nombre del Rol</th>
            </tr>
        </thead>
    </table>
@endsection

@section('js_after')
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
                {data:'DT_RowIndex',name:'DT_RowIndex'},
                {data:'id',name:'id'},
                {data:'name_role',name:'name_role'},
            ]
        });

        $(document).ready(function () {

        });
    </script>
@endsection
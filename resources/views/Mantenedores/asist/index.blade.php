@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('content')
<table class="table" id="myTable" style="width: 100%">
    {!! Form::token() !!}
    <thead class="thead">
        <tr>
            <th>id</th>
            <th>Fecha</th>
            <th>Hora de entrada</th>
            <th>Hora de salida</th>
        </tr>
    </thead>
</table>
@endsection

@section('js_after')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
    <script>
        const Table = $("#myTable").DataTable({
            processing: true,
            serverSide: true,
            language: {
                    url: "{{ asset('js/language.json') }}"
            },
            ajax:{
                    url: "{{ route('dataTable.asist') }}",
                    type: 'GET',
            },
            columns:[
                {data:'id',name:'id'},
                {data:'created_at',name:'crated_at'},
                {data:'created_at',name:'created_at',orderable:false,searchable:true},
                {data:'end',name:'end',orderable:false,searchable:true},
            ]
        });
    </script>
@endsection
@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('content')
<div class="container my-4">
    <div class="row ">
        <div class="col d-flex justify-content-center" id="buttonAssist">
            <button class="btn btn-success">Marcar asistencia</button>
        </div>
        <div class="col d-flex justify-content-center" id="buttonFinish">
            <button class="btn btn-danger">Terminar turno</button>
        </div>
    </div>
</div>
<table class="table" id="myTable" style="width: 100%">
    {!! Form::token() !!}
    <thead class="thead bg-secondary text-white">
        <tr>
            <th>Fecha</th>
            <th>Hora de entrada</th>
            <th>Hora de salida</th>
        </tr>
    </thead>
</table>
@endsection

@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script   script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
    <script>
        console.log(@json($currentAsist))
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
                {data:'created_at',name:'crated_at', render(data){ return moment(data).locale('es').format('LL');}},
                {data:'created_at',name:'created_at',render(data){ return moment(data).locale('es').format('LTS');},orderable:false,searchable:true},
                {data:'end',name:'end',render(data){ 
                        if(data){
                            return moment(data).locale('es').format('LTS');
                        }else{
                            return 'Sin terminar'
                        }
                    },
                    orderable:false,
                    searchable:true
                },
            ]
        });
    </script>
@endsection
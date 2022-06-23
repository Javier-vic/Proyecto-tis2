@extends('layouts.navbar')

@section('titlePage')
<h2 class="">Asistencia registrada</h2>
@endsection

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('content')

@section('titlePage')
<h3>Listado de asistencias</h3>
@endsection

<div class="container my-4">
        @if (isset($currentAsist[0]->id))
            <div class="row mb-3">
                <div class="col d-flex justify-content-center">
                    <span class="fs-4 p-2 border border-2 rounded">
                        Registra asistencia vigente con fecha y hora: <span id="currentAsist"></span>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-center" id="buttonFinish">
                    <button class="btn btn-danger" onclick="finishAsist({{$currentAsist[0]->id}})">Terminar turno</button>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col d-flex justify-content-center" id="buttonAssist">
                    <button class="btn btn-success" onclick="saveAsist()">Marcar asistencia</button>
                </div>
            </div>
        @endif
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
        const saveAsist = () => {
            Swal.fire({
                title: '¿Seguro de comenzar turno?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Comenzar!',
                cancelButtonText: 'Cancelar',
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        type: "post",
                        url: "{{route('asist.store')}}",
                        data: {"_token": "{{ csrf_token() }}"},
                        dataType: "json",
                        success: function (response) {
                            Swal.fire({
                                title: 'Turno registrado',
                                text: `Con hora: ${moment(response.asist.created_at).locale('es').format('LTS')}`,
                                footer: 'No olvides terminar tu turno' 
                            }).then((response)=>{
                                location.reload();
                            })
                        },
                        error: ()=>{
        
                        }
                    });
                }
            })
        }
        const finishAsist = (id) => {
            Swal.fire({
                title: '¿Seguro de terminar turno?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, terminar!',
                cancelButtonText: 'Cancelar',
            }).then((result)=>{
                if(result.isConfirmed){
                    var url = '{{ route("finish.asist", ":id") }}';
                    url = url.replace(':id', id);
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {"_token": "{{ csrf_token() }}"},
                        dataType: "text",
                        success: function (response) {
                            Swal.fire({
                                title: 'Turno terminado',
                                text: `Con hora: ${moment(response.date).locale('es').format('LTS')}`
                            }).then(()=>{
                                location.reload();
                            })
                        }
                    });
                }
            })
        }
        $(document).ready(function () {
            currentAsist = @json($currentAsist) 
            if(currentAsist.length>0){
                $("#currentAsist").text(currentAsist[0].created_at); 
            }
        });
    </script>
@endsection
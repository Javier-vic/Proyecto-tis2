@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')

   
<a type="button" class="btn btn-primary" href="{{route('order.create')}}" href="">Agregar Orden</a>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-W1.11.5/datatables.min.js"></script>

<table class="table table-light" id="myTable" width = 100%>
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Nombre orden</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Retiro</th>
            <th>Metodo de pago</th>
            <th>comentario</th>
            <th>acciones</th>
            
        </tr>
    </thead>

@endsection
@section('js_after')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $("#myTable").DataTable({
                bProcessing: true,
                bStateSave: true,
                deferRender: true,
                responsive: true,
                processing: true,
                searching: true,

                ajax: {
                    url: "{{ route('order.index') }}",
                    type: 'GET',
                },
                // language: {
                //     url: "{{ asset('js/plugins/datatables/spanish.json') }}",
                // },
                dom: "<'row d-flex justify-content-between'<'col-sm-12 col-md-4 d-none d-md-block'l><'col-sm-12 col-md-3 text-right'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4 d-none d-md-block'i><'col-sm-12 col-md-7'p>>",

                columns: [{
                        data: 'id',
                        name: 'id',
                        visible: false,
                        searchable: false
                    },
                    {
                        data: 'name_order',
                        name: 'name_order'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'order_status',
                        name: 'order_status'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'pick_up',
                        name: 'pick_up'
                    },
                    {
                        data: 'comment',
                        name: 'comment'
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

        })

        const addorder = (e) =>{
            e.preventDefault();
            var data = $("#postForm").serializeArray();
            $.ajax({
                type: "POST",
                url: "{{route('order.store')}}",
                data: data,
                dataType: "text",
                success: function (response) {
                    alert(response);
                   
                }
            });
        }

    </script>
@endsection
@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('content')
    <div>
        @include('sweetalert::alert')
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarInsumo"> Agregar nuevo insumo</button>
    <table class="table" id="myTable" style="width: 100%">
        {!! Form::token() !!}

        <thead class="thead">
            <tr>
                <th>#</th>
                <th>name_supply</th>
                <th>unit_meassurement</th>
                <th>quantity</th>
                <th>name_category</th>
                <th>acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($supplies as $supply)
            <tr>
                <td>{{ $supply->id }}</td>
                <td>{{ $supply->name_supply }}</td>
                <td>{{ $supply->unit_meassurement }}</td>
                <td>{{ $supply->quantity }}</td>
                <td>{{ $supply->id_category_supplies }}</td>
                <td><a href="{{ url( '/supply/'.$supply->id.'/edit' ) }}">Editar</a> |             
                    <form action="{{ url( '/supply/'.$supply->id ) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" onclick="return confirm('¿Quieres borrar?')" value="borrar">
                    </form>
                </td>          
            </tr>
            @endforeach
        </tbody>

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
    <script>
        const Table = $("#myTable").DataTable({
            processing: true,
            serverSide: true,
            language: {
                    url: "{{ asset('js/language.json') }}"
                },
            ajax:{
                    url: "{{ route('dataTable.Supply') }}",
                    type: 'GET',
            },
            columns:[
                {data:'id',name:'id'},
                {data:'name_supply',name:'name_supply'},
                {data:'unit_meassurement',name:'unit_meassurement'},
                {data:'quantity',name:'quantity'},
                {data:'id_category',name:'id_category'},
                {data:'action',name:'action',orderable:false,searchable:true},
            ]
        });

        const capitalize = (s) => {
            if (typeof s !== 'string') return ''
            return s.charAt(0).toUpperCase() + s.slice(1)
        }

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
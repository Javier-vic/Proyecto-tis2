@extends('layouts.navbar');

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('content')
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
        
        <tbody>
            @foreach($category_supplies as $category_supply)
            <tr>
                <td>{{ $category_supply->id }}</td>
                <td>{{ $category_supply->name_category }}</td>
                <td><a href="{{ url( '/category_supply/'.$category_supply->id.'/edit' ) }}">Editar</a> |             
                <form action="{{ url( '/category_supply/'.$category_supply->id ) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" onclick="return confirm('¿Quieres borrar?')" value="borrar">
                </form>
                </td>          
            </tr>
            @endforeach
        </tbody>

    </table>

    <div class="">
        @include('Mantenedores.category_supply.modal')
    </div>
    <div class="">
        <!-- include('Mantenedores.category_supply.modalViewPermits') -->
    </div>
    <div class="">
        <!-- include('Mantenedores.category_supply.ModalEditRole') -->
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
            var data = $("#postForm").serializeArray();
            $.ajax({
                type: "POST",
                url: "{{route('category_supply.store')}}",
                data: data,
                dataType: "text",
                success: function (response) {
                    Table.ajax.reload();
                    $("#agregarCategoriaInsumo").modal("hide");
                }
            });
        }

@endsection
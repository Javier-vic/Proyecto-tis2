@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('content')
    <div>
        @include('sweetalert::alert')
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarCategoriaInsumo"> Agregar nueva categoria</button>
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
            <!-- include('Mantenedores.supply.modal.create') -->
        </div>
        <div class="">
            <!-- include('Mantenedores.supply.modal.edit') -->
        </div>

    </table>
@endsection
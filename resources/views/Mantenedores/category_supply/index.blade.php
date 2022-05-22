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
        @include('Mantenedores.category_supply.Modal.ModalCreate')
    </div>
    <div class="">
        <!-- include('Mantenedores.category_supply.modalViewPermits') -->
    </div>
    <div class="">
        @include('Mantenedores.category_supply.Modal.ModalEdit')
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
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: response,
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,               
                        heightAuto:false,
                    })
                    Table.ajax.reload();
                    $("#agregarCategoriaInsumo").modal("hide");
                }
            });
        }

        const editCategorySupply = (id) => {
            $.ajax({
                type: "GET",
                url: "{{route('permits.roles')}}",
                data: {'id': id,"_token": "{{ csrf_token() }}"},
                dataType: "json",
                success: (res) =>{
                    //console.log(json($permits));
                    //console.log(res);
                    $("#editName").val('');
                    $("#editName").val(`${res[0][0].name_role}`);
                    $("#editPermits").empty();
                    json($permits).map(e=>{
                        var check = false;
                        res[1].map(el=>{
                            (el.id==e.id) ? check=true: null;
                        })
                        $("#editPermits").append(
                        $($('<div>',{
                            class: 'form-check form-switch'
                        })).append(
                        $('<input>',{
                            class:'form-check-input',
                            name:'permits[]',
                            value:`${e.id}`,
                            type:'checkbox',
                            id:`${e.id}`,
                            checked: check
                        }))
                        .append($('<label>',{
                            class:'form-check-label',
                            for:'flexSwitchCheckDefault',
                            text:`${capitalize(e.tipe_permit)}`
                        }))
                        )
                    })
                    $("#editForm").attr('onSubmit', `submitEdit(${id},event)`);
                    $('#editRole').modal('show');
                }
            })
        }
        const submitEdit = (id,e) => {
            e.preventDefault();
            var url = '{{ route("roles.update", ":id") }}';
            url = url.replace(':id', id);
            var data = $("#editForm").serializeArray();
            console.log(data)
            $.ajax({
                type: "PUT",
                url: url,
                data: data,
                dataType: "json",
                success: function (response) {
                    console.log(response)        
                }
            });
            $('#editRole').modal('hide');
        }

@endsection
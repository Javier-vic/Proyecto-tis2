@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('titlePage')
<h3>Categorías de insumos</h3>
@endsection

@section('content')
    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#agregarCategoriaInsumo"> Agregar nueva categoria</button>
    <table class="table" id="myTable" style="width: 100%">
    {!! Form::token() !!}

        <thead class="thead bg-secondary text-white">
            <tr>
                <th>Nombre de categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        
        

    </table>

    <div class="">
        @include('Mantenedores.category_supply.modal.create')
    </div>
    <div class="">
        @include('Mantenedores.category_supply.modal.edit')
    </div>
@endsection

@section('js_after')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        var table = $("#myTable").DataTable({
            bProcessing: true,
            bStateSave: true,
            deferRender: true,
            responsive: true,
            processing: true,
            searching: true,
            language: {
                url: "{{ asset('js/language.json') }}"
            },
            ajax: {
                url: "{{ route('category_supply.index') }}",
                type: 'GET',
            },
            dom: "<'row d-flex justify-content-between'<'col-sm-12 col-md-4 d-none d-md-block'l><'col-sm-12 col-md-3 text-right'B>>" +
                "<'row '<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4 d-none d-md-block 'i><'col-sm-12 col-md-7'p>>",
            columns:[
                {data:'name_category',name:'name_category'},
                {data:'action',name:'action',orderable:false,searchable:true},
            ],
            select: true
        });

        // ****************************************************************************************************************
        //MODAL DE CREAR
        //****************************************************************************************************************   
        const addCategorySupply = (e) =>{
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            $.ajax({
                type: "POST",
                url: "{{route('category_supply.store')}}",
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
                    table.ajax.reload();
                    $("#agregarCategoriaInsumo").modal("hide");                   
                },
                error: function( jqXHR, textStatus, errorThrown ){                 
                    var text = jqXHR.responseJSON;
                    //LIMPIA LAS CLASES Y ELEMENTOS DE INVALID
                    $(".createmodal_error").empty()
                    $(".input-modal").addClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    //////////////////////////////////////////
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: 'No se pudo crear la categoría.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                    //AGREGA LAS CLASES Y ELEMENTOS DE INVALID
                    if(text){
                        $.each(text.errors, function(key,item){
                        $("#"+key+"_errorCREATEMODAL").append("<span class='text-danger'>"+item+"</span>")
                        $(`#idName`).addClass('is-invalid');
                        });
                    }
                    //////////////////////////////////////
                    
                }
            });
        }
        // ****************************************************************************************************************
        //RELLENA MODAL DE EDITAR
        // ****************************************************************************************************************   
            
        const editCategorySupply = (id) => {          
            var  url = '{{ route("category_supply.edit", ":category_supply") }}';
            url = url.replace(':category_supply',id)
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    console.log(response)
                    let resultado = response[0][0];                  
                    $('#name_categorySupplyEdit').val(resultado.name_category);   
                    $("#formEdit").attr('onSubmit', `editCategorySupplySubmit(${id},event)`);
                    $('#editCategorySupply').modal('show');  
                }
                
            });
        }
        //******************************************************************************************
        //ENVÍA MODAL DE EDITAR
        // *****************************************************************************************
        const editCategorySupplySubmit = (id,e) => {
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            formData.append('_method', 'put');
            var  url = '{{ route("category_supply.update" , ":category_supply") }}';
            url = url.replace(':category_supply', id);
            Swal.fire({
                title: '¿Estás seguro de editar esta categoría',
                text: "No se puede revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, editar!',
                cancelButtonText: 'Cancelar',
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: formData ,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            table.ajax.reload();
                            Swal.fire(
                                'Editado!',
                                'La categoría ha sido editada.',
                                'success'
                            )
                            $('#editCategorySupply').modal('hide');
                        },
                        error: function( jqXHR, textStatus, errorThrown ) {
                            var text = jqXHR.responseJSON;
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'error',
                                title: 'No se pudo editar la categoría.',
                                showConfirmButton: false,
                                timer: 2000,
                                backdrop: false
                            })
                            //AGREGA LAS CLASES DE INVALID
                            if(text){
                                $.each(text.errors, function(key,item){
                                $("#"+key+"_errorEDITMODAL").append("<span class='text-danger'>"+item+"</span>")
                                $(`#name_categorySupplyEdit`).addClass('is-invalid');
                                });
                            }
                            ///////////////////////////////////////////////
                        }         
                    })
                }
            })
        }

        
        // *****************************************************************************************
        //ELIMINAR CATEGORÍA 
        // *****************************************************************************************

        const deleteCategorySupply = (id) =>{
            Swal.fire({
                title: '¿Estás seguro de eliminar esta categoría?',
                text: "Eliminar la categoría eliminara todo insumo dentro de ella y no se puede revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Borrar!',
                cancelButtonText: 'Cancelar',
            }).then((result)=>{
                url = '{{ route("category_supply.destroy", ":category_supply") }}';
                url = url.replace(':category_supply', id);
                if(result.isConfirmed){
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        error: function( jqXHR, textStatus, errorThrown ) {
                            var text = jqXHR.responseText;
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'error',
                                title: text,
                                showConfirmButton: false,
                                timer: 2000,
                                backdrop: false
                            })
                        },
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            Swal.fire(
                                'Borrado!',
                                'La categoría ha sido eliminada.',
                                'success'
                            )
                            
                            table.ajax.reload();           
                        }
                    });
                }
         
            })
        }

        // ****************************************************************************************************************
        //LIMPIA LOS INPUTS AL CERRAR UN MODAL
        // ****************************************************************************************************************
        $('#agregarCategoriaInsumo').on('hidden.bs.modal', function () {
            $(".input-modal").removeClass('is-invalid');
            $(".input-modal").removeClass('is-valid');
            $(".input-modal").val('');
            $(".createmodal_error").empty()
           })

        $('#editCategorySupply').on('hidden.bs.modal', function () {
            $(".input-modal").removeClass('is-invalid');
            $(".input-modal").removeClass('is-valid');
            $(".input-modal").val('');
            $(".editmodal_error").empty()
        })
    
        // ****************************************************************************************************************
        
    </script> 

@endsection
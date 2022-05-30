@extends('layouts.navbar')

@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#agregarInsumo"> Agregar nuevo insumo</button>
    <table class="table" id="myTable" style="width: 100%">
    {!! Form::token() !!}

        <thead class="thead bg-secondary text-white">
            <tr>
                <th>Nombre de insumo</th>
                <th>Unidad de medida</th>
                <th>Cantidad</th>
                <th>Categoria</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <div class="">
            @include('Mantenedores.supply.modal.create')
        </div>
        <div class="">
            @include('Mantenedores.supply.modal.edit')
        </div>

    </table>
@endsection

@section('js_after')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>

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
                    url: "{{ route('supply.index') }}",
                    type: 'GET',
                },
                dom: "<'row d-flex justify-content-between'<'col-sm-12 col-md-4 d-none d-md-block'l><'col-sm-12 col-md-3 text-right'B>>" +
                    "<'row '<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4 d-none d-md-block 'i><'col-sm-12 col-md-7'p>>",
                columns:[
                    {data:'name_supply',name:'name_supply'},
                    {data:'unit_meassurement',name:'unit_meassurement'},
                    {data:'quantity',name:'quantity'},
                    {data:'name_category',name:'name_category'},
                    {data:'action',name:'action',orderable:false,searchable:true}
                ],
                select: true
        });

    // ****************************************************************************************************************
    //MODAL DE CREAR
    // ****************************************************************************************************************   
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
                    //LIMPIA LAS CLASES Y ELEMENTOS DE INVALID
                    $(".createmodal_error").empty()
                    $(".input-modal").removeClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    //////////////////////////////////////////
                    $('#idname').val('');
                    table.ajax.reload();
                    $("#agregarInsumo").modal("hide");                   
                },
                error: function( jqXHR, textStatus, errorThrown ){                 
                    var text = jqXHR.responseJSON
                    //LIMPIA LAS CLASES Y ELEMENTOS DE INVALID
                    $(".createmodal_error").empty()
                    $(".input-modal").addClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    //////////////////////////////////////////
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: 'No se pudo ingresar el nuevo insumo.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false
                    })
                    //AGREGA LAS CLASES Y ELEMENTOS DE INVALID
                    if(text){
                        $.each(text.errors, function(key,item){
                        $("#"+key+"_errorCREATEMODAL").append("<span class='text-danger'>"+item+"</span>")
                        $(`#${key}`).addClass('is-invalid');
                        });
                    }
                    //////////////////////////////////////
                }
            });
        }

        const deleteSupply = (id) =>{
            Swal.fire({
                title: '¿Estás seguro de eliminar este insumo?',
                text: "No se puede revertir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Borrar!',
                cancelButtonText: 'Cancelar',
            }).then((result)=>{
                url = '{{ route("supply.destroy", ":supply") }}';
                url = url.replace(':supply', id);
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
                                'El insumo ha sido eliminado.',
                                'success'
                            )
                            
                            table.ajax.reload();           
                        }
                    });
                }
         
            })
        } 

        const editSupply = (id) =>{
            var  url = '{{ route("supply.edit", ":supply") }}';
            url = url.replace(':supply',id)
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(response) {
                    let resultado = response[0][0];                  
                    $('#name_supplyEdit').val(resultado.name_supply);
                    $('#unit_meassurementEdit').val(resultado.unit_meassurement);
                    $('#quantityEdit').val(resultado.quantity);
                    $('#id_category_suppliesEdit').val(resultado.id_category_supplies);     

                    $("#formEdit").attr('onSubmit', `editSupplySubmit(${id},event)`);
                    $('#editSupply').modal('show');  
                }
                
            });
        }

        const editSupplySubmit = (id,e)=>{
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            formData.append('_method', 'put');
            var  url = '{{ route("supply.update" , ":supply") }}';
            url = url.replace(':supply', id);
            Swal.fire({
                title: '¿Estás seguro de editar este insumo?',
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
                                'El insumo ha sido editado.',
                                'success'
                            )
                            $('#editSupply').modal('hide');
                        },
                        error: function( jqXHR, textStatus, errorThrown ) {
                            var text = jqXHR.responseJSON;
                            //AGREGA CLASE DE VALID Y ELIMINA LAS DE INVALID
                            $(".editmodal_error").empty()
                            $(".input-modal").addClass('is-valid')
                            $(".input-modal").removeClass('is-invalid')
                            /////////////////////////////////////////////
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'error',
                                title: 'No se pudo editar el insumo.',
                                showConfirmButton: false,
                                timer: 2000,
                                backdrop: false
                            })
                            //AGREGA CLASES Y ELEMENTOS INVALID
                            if(text){
                                $.each(text.errors, function(key,item){
                                $("#"+key+"_errorEDITMODAL").append("<span class='text-danger'>"+item+"</span>")
                                $(`#${key}Edit`).addClass('is-invalid');
                                });
                            }
                            //////////////////////////////
                        }         
                    })
                }
            })           
        } 

        // ****************************************************************************************************************
        // ****************************************************************************************************************
        //LIMPIA LOS INPUTS AL CERRAR UN MODAL
        // ****************************************************************************************************************
           $('#agregarInsumo').on('hidden.bs.modal', function () {
            $(".input-modal").removeClass('is-invalid');
            $(".input-modal").removeClass('is-valid');
            $(".input-modal").val('');
            $(".createmodal_error").empty()
           })

        $('#editSupply').on('hidden.bs.modal', function () {
            $(".input-modal").removeClass('is-invalid');
            $(".input-modal").removeClass('is-valid');
            $(".input-modal").val('');
            $(".editmodal_error").empty()
        })
    
        // ****************************************************************************************************************
        

    </script>

@endsection
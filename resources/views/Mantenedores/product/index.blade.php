@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarProducto">
        Agregar producto
    </button>
    {{-- <a role="button" class="btn btn-success mr-auto" href="{{ route('product.create') }}">
        <i class="fa fa-fw fa-plus mr-2"></i> Crear producto
    </a> --}}
    <div id="number"></div>
    <div>@include('Mantenedores.product.modal.create')</div>
    <div>@include('Mantenedores.product.modal.show')</div>
    <div>@include('Mantenedores.product.modal.edit')</div>

    <div class="block-content block-content-full block-content-sm bg-body-dark">
        <input type="text" id="search" class="form-control form-control-alt" autocomplete="off" placeholder="Buscar...">
    </div>
    <table id="myTable" class="responsive display nowrap" style="width: 100%;">
        <thead class="bg-primary text-white">
            <tr class="text-center">
                <th class="py-2" style="width:10%">Nombre producto</th>
                <th class="py-2" style="width:10%">Stock</th>
                <th class="py-2" style="width:10%">Acciones</th>
            </tr>
        </thead>
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
    <script type="text/javascript">
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
                    url: "{{ route('product.index') }}",
                    type: 'GET',
                },
                // language: {
                //     url: "{{ asset('js/plugins/datatables/spanish.json') }}",
                // },
                dom: "<'row d-flex justify-content-between'<'col-sm-12 col-md-4 d-none d-md-block'l><'col-sm-12 col-md-3 text-right'B>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4 d-none d-md-block'i><'col-sm-12 col-md-7'p>>",

                columns: [
                    {
                        data: 'name_product',
                        name: 'name_product'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
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
           //MODAL DE CREAR
           // ****************************************************************************************************************
           const createProduct = (e) =>{
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            var  url = '{{ route("product.store") }}';
                $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                    success: function(response, jqXHR) {
                        Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Se ingresó el producto correctamente.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,
                        heightAuto:false,
                    })
                    //QUITA LAS CLASES Y ELEMENTOS DE INVALID
                    $("input-modal").removeClass('is-invalid');
                    $("input-modal").removeClass('is-valid');
                    $(".createmodal_error").empty()
                    //
                    table.ajax.reload();
                    $('#agregarProducto').modal('hide');  
                    document.getElementById("number").innerHTML = table.data().count()+1;
 
                    },
                   error: function( jqXHR, textStatus, errorThrown ) {
                    var text = jqXHR.responseJSON;
                    $(".createmodal_error").empty()
                    $(".input-modal").addClass('is-valid')
                    $(".input-modal").removeClass('is-invalid')
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: "No se pudo realizar el ingreso del producto.",
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
                    //
               }
                
                });
            }
            //****************************************************************************************************************
           //RELLENA MODAL DE EDITAR
           // ****************************************************************************************************************
            const editProduct = (id) =>{
            var  url = '{{ route("product.edit", ":product") }}';
            url = url.replace(':product',id)
                $.ajax({
                type: "GET",
                url: url,
 
                dataType: "json",
                    success: function(response) {
                        console.log(response)
                    let resultado = response[0][0];
                    $('#image_productEDITVIEW').empty();
                    $('#name_productEDIT').val(resultado.name_product);
                    $('#stockEDIT').val(resultado.stock);
                    $('#descriptionEDIT').val(resultado.description);
                    $('#priceEDIT').val(resultado.price);
                    $('#categoryEdit').val(resultado.category);
                    
                    var url = '{{ asset('storage') . '/' . ':urlImagen' }}';
                        url = url.replace(':urlImagen', resultado.image_product);

                        $('#verProductoLabel').html(`${resultado.name_product}`)

                        $('#image_productEDITVIEW').append($('<img>', {
                            src: url,
                            class: 'img-fluid'
                        }))

                    $("#formEdit").attr('onSubmit', `editProductSubmit(${id},event)`);
                    $('#editProducto').modal('show');  
                    }
                
                });
            }
            // ****************************************************************************************************************
           //ENVÍA MODAL DE EDITAR
           // ****************************************************************************************************************
           const editProductSubmit = (id,e)=>{
            e.preventDefault();
            var formData = new FormData(e.currentTarget);
            formData.append('_method', 'put');
            var  url = '{{ route("product.update" , ":product") }}';
            url = url.replace(':product', id);
            Swal.fire({
            title: '¿Estás seguro de editar este producto',
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
                            'El producto ha sido editado.',
                            'success'
                    )
                    $('#editProducto').modal('hide');
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                   var text = jqXHR.responseJSON;
                   $(".editmodal_error").empty()
                   $(".input-modal").addClass('is-valid')
                   $(".input-modal").removeClass('is-invalid')
                   Swal.fire({
                       position: 'bottom-end',
                       icon: 'error',
                       title: 'No se pudo editar el producto.',
                       showConfirmButton: false,
                       timer: 2000,
                       backdrop: false
                   })
                    //AGREGA CLASES Y ELEMENTOS INVALID  
                   if(text){
                    $.each(text.errors, function(key,item){
                    $("#"+key+"_errorEDITMODAL").append("<span class='text-danger'>"+item+"</span>")
                    $(`#${key}EDIT`).addClass('is-invalid');
                    });
                   }
                  //
               }
         
            })
                }
            })
           
           } 

             // ****************************************************************************************************************
           //ELIMINAR UN PRODUCTO
           // ****************************************************************************************************************
           const deleteProduct = (id) =>{
            Swal.fire({
            title: '¿Estás seguro de eliminar este producto?',
            text: "No se puede revertir.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Borrar!',
            cancelButtonText: 'Cancelar',
            }).then((result)=>{
            url = '{{ route("product.destroy", ":product") }}';
            url = url.replace(':product', id);
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
                                'El producto ha sido eliminado.',
                                'success'
                            )
                    document.getElementById("number").innerHTML = table.data().count()-1;
                    table.ajax.reload();
         

                    }
                });
            }
         
            })
           } 
           // ****************************************************************************************************************
            //RELLENA EL MODAL DE VER DETALLES
           // ****************************************************************************************************************
            $(document).on("click", ".btn-view-producto", function() {
                valor_IDproducto = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('product.view') }}",
                    data: {
                        'id': valor_IDproducto,

                    },
                    dataType: "json",
                    success: function(response) {
                        var resultado = response[0][0];
                        $('#mostrarImagen').empty();
                        var url = '{{ asset('storage') . '/' . ':urlImagen' }}';
                        url = url.replace(':urlImagen', resultado.image_product);

                        $('#verProducto').modal('show');
                        $('#verProductoLabel').html(`${resultado.name_product}`)

                        $('#mostrarImagen').append($('<img>', {
                            src: url,
                            class: 'img-fluid'
                        }))

                        // $('#name_productVIEWMODAL').val(resultado.name_product) NOMBRE DEL PRODUCTO
                        $('#stockVIEWMODAL').val(resultado.stock)
                        $('#descriptionVIEWMODAL').val(resultado.description)
                        $('#category').val(resultado.category)
                    }
                });
            });
        
           // ****************************************************************************************************************
           // ****************************************************************************************************************
           //LIMPIA LOS ERRORES DE LOS INPUTS EN LOS MODALES
           // ****************************************************************************************************************
           $('#agregarProducto').on('hidden.bs.modal', function () {
            $(".input-modal").removeClass('is-invalid');
            $(".input-modal").removeClass('is-valid');
            $(".input-modal").val('');
            $(".createmodal_error").empty()
           })

           $('#editProducto').on('hidden.bs.modal', function () {
            $(".input-modal").removeClass('is-invalid');
            $(".input-modal").removeClass('is-valid');
            $(".input-modal").val('');
            $(".editmodal_error").empty()
           })
           //
           // ****************************************************************************************************************
        
    
    </script>
@endsection

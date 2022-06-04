@extends('layouts.navbar')
@section('css_extra')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
@endsection

@section('titlePage')
    <h2>Listado de ventas</h3>
    @endsection

    @section('content')
        <!-- <div id="number"></div> -->
        <div>@include('Mantenedores.order.modal.show')</div>

        <a type="button" class="btn btn-primary mb-5" href="{{ route('order.create') }}" href="">Agregar Orden</a>


        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />


        <table class="table table-light" id="myTable" width=100%>
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nombre orden</th>
                    <th>Direccion</th>
                    <th>Estado</th>
                    <th>Retiro</th>
                    <th>Metodo de pago</th>
                    <th>Total</th>
                    <th>acciones</th>

                </tr>
            </thead>
        @endsection
        @section('js_after')
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

            <script type="text/javascript">
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
                    language: {
                        url: "{{ asset('js/language.json') }}"
                    },

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
                            data: 'address',
                            name: 'address'
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
                            data: 'total',
                            name: 'total'
                        },

                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },





                    ],
                    // initComplete: function(settings, json) {

                    //     document.getElementById("number").innerHTML = table.data().count();
                    // },
                    select: true
                });
                $('#search').on('keyup', function() {
                    table.search(this.value).draw();
                });
                // ****************************************************************************************************************



                const addorder = (e) => {
                    e.preventDefault();
                    var data = $("#postForm").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('order.store') }}",
                        data: data,
                        dataType: "text",
                        success: function(response) {
                            alert(response);

                        }
                    });
                }
                // ****************************************************************************************************************
                //RELLENA EL MODAL DE VER DETALLES
                // ****************************************************************************************************************

                const showOrder = (id) => {

                    $.ajax({
                        type: "GET",
                        url: "{{ route('order.view') }}",
                        data: {
                            'id': id,
                        },
                        dataType: "json",
                        success: function(response) {
                            resultado = response;


                            $('#nameOrderVIEWMODAL').val(resultado[1]);
                            $('#name_order').val(resultado[1][0].name_order);
                            $('#payment').val(resultado[1][0].payment_method);
                            $('#total').val(resultado[1][0].total);
                            $('#dely').val(resultado[1][0].pick_up);
                            $('#date').val(resultado[1][0].created_at);

                            // $('#addorderLabel').html(${resultado.product_id})
                            console.log(resultado)
                            $('#pruebaProductos').empty();
                            resultado[0].map(product => {
                                $('#pruebaProductos').append(
                                    `
                                <tr>
                                    <td>${product.name_product}</td>
                                    <td>${product.cantidad}</td>
                                    <td>${product.cantidad*product.price}</td>
                                </tr> 
                                `
                                )
                            })

                        }
                    });
                }

                // ****************************************************************************************************************
                // ****************************************************************************************************************
                const deleteOrder = (id) => {

                    Swal.fire({
                        title: '¿Estás seguro de eliminar la orden?',
                        text: "No se puede revertir.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Borrar!',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        url = '{{ route('order.destroy', ':order') }}';
                        url = url.replace(':order', id);
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: url,
                                error: function(jqXHR, textStatus, errorThrown) {
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
                                        'La order ha sido eliminado.',
                                        'success'
                                    )
                                    // document.getElementById("number").innerHTML = table.data().count()-1;
                                    table.ajax.reload();


                                }
                            });
                        }

                    })
                }

                /////
            </script>
        @endsection

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
        
            <div class="row">

                <div class="col-md-6">
                    <h3>Productos Mas Vendido</h3>
                    <canvas id="myChart" ></canvas>
                </div>

                <div id = "grafica2" class="col-md-6 ">
                <h3 >Graficas De Ventas Mensuales</h3>

                <form action="" id = "form-yea"> 

                    

                    <select name="" class="form-select" id="selectYear">
                        <option selected>Seleccione un año</option>
                        
                        @isset($years)
                        @foreach ($years as &$valor) 

                        <option value="{{$valor->year}}">{{$valor->year}}</option>
                        
                        @endforeach
                            
                        @endisset  
    
                    </select>

        
        
                    
                    <div class="">

                        <canvas class = "canva" id="myChart2"></canvas>

                    </div>
                
                </form>
            
            </div>
   @endsection


    @section('js_after')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" ></script>

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

               
            </script>

            <script>



                let myChart2;
                function viewGraph(){
                    //////////***Graficas por años */////////////
                    
                    $('#selectYear').on('change', function() {
                    // create data from form input(s)
                    const x = $(this).val();
                    $.ajax({
                    type: "GET",
                    url: "{{ route('order.month') }}",
                    data: {
                        'year': x,
                    },
                    dataType: "json",
                    success: function(response) {
                    const resultado = response;
                    const label = []
                    const dates = new Array(12);
                        dates.fill(0);
                    let myChart;
                    
                    resultado.map( cantidad =>{
                                
                        dates[cantidad.month] = cantidad.data;
                        
                   })
                
                
                    const labels = ['enero','febrero','marzo','Abril','Mayo','Junio','Julio','Agosto', 'Septiembre', 'Octubre', 'Noviembre','Diciembre'];
                    const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Ganancias mensuales',
                        data: dates,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                    };

                    if (myChart) {
                            myChart.destroy();
                    }

                    var ctx = document.getElementById(`myChart2`).getContext('2d');
                        if (myChart2) {
                            myChart2.destroy();
                        }
                        myChart2 = new Chart(ctx, {
                        type: 'line',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Ganancias mensuales'
                            }
                            }
                        },
                    }); 
                                
                            
                            
                        
                    }
                    }); //ajax
                    });
                
                }



                var myChart;
                ////////////////////////////////////
                // Grafiva producto mas vendido
                //*////////////////////////////////////
                function getBestSellers() {
                    var label = [];
                    var date = [];
                    $.ajax({
                            type: "GET",
                            url: "{{ route('order.bestsellers') }}",
                            dataType: "json",
                            success: function(response) {
                                resultado = response;
                                
                                resultado.map( products =>{ 
                            
                                    date.push(products.cantida);
                                    label.push(products.name_product);

                                })
                                

                                const ctx = document.getElementById('myChart');
                                myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: label,
                                    datasets: [{
                                        label: 'Cantidad de producto',
                                        data: date,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                  
                                        borderWidth: 1
                                    }]
                                },
                                    options: {
                                        scales: {
                                            yAxes: {
                                                ticks: {
                                                    stepSize: 1
                                                }
                                                
                                            }
                                        }
                                    }
                            });

                            }
                        
                        
                        });
               }





                    
                    
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
                                    //RECARGA GRÁFICO AL ELIMINAR UNA ORDEN
                                    myChart.destroy()
                                    myChart2.destroy()
                                    getBestSellers();
                                    viewGraph();
                                }
                            });
                        }

                    })


                }
                
                // ****************************************************************************************************************
                //RELLENA EL MODAL DE VER DETALLES
                // ****************************************************************************************************************
           
                $(document).ready(function () {
                    
                    viewGraph();
                    getBestSellers(); /// grafic producto mas vendido
                 
                }); 

               
                

                
            </script>
        @endsection

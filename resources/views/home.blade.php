@extends('layouts.navbar')

@section('content')

    <div class = "row my-4">

        <div class="  ms-5 col-md-2 bg-white border  shadow  rounded-3" style="height = 1000px">
            <h6 class ="my-3" >ventas del mes</h6>
            <div class="row mt-2">
                <div class="col-md-6  ps-5"><h3 id="text" ></h3></div>
                <div class="col-md-6 pe-5 mt-2"><i class="fa-solid fa-cart-shopping fa-2x"></i></div>
            </div>
            
        </div>

        <div class="col-md-2 bg-white border shadow  rounded-3 ms-5" style="height = 1000px">
            <h6 class ="my-3">Ganancia del mes</h6>
            <div class="row mt-3">
                <div class="col-6 ps-4"><h3 id="money" ></h3></div>
                <div class="col-6  "><i class="fa-solid fa-money-bill fa-2x"></i></div>
            </div>
            
        </div>

        <div class="col-md-2 bg-white border shadow  rounded-3 ms-5">
            <h6 class ="my-3">Productos sin stock</h6>
            <div class="row mt-3">
                <div class="col-6 ps-4"><h3 id="supplies" ></h3></div>
                <div class="col-6  "><i class="fa-solid fa-money-bill fa-2x"></i></div>
            </div>

        </div>

        <div class="col-md-2 bg-white border shadow  rounded-3 ms-5">

            <h6 class ="my-3">Insumos Critico</h6>
                <div class="row mt-3">
                    <div class="col-md-6 "><h3 id="product" ></h3></div>
                    <div class="col-md-6  "><i class="fa-solid fa-money-bill fa-2x"></i></div>
                </div>

            
        </div>

    </div>

    <div class="row">

        <div class="col-md-5 ms-5 rounded shadow bg-white border rounded-3">
            <h5 class="ms-3 mt-3">Productos mas vendido</h5>
            <canvas width = 400px heigh= 400px id="myChart" ></canvas>
        </div>

        <div id = "grafica2" class="col-md-5 mx-5 shadow bg-white border rounded-3 ">
            <h5 class = "ms-3 mt-3">Ventas mensuales</h5>


            <select name="" class="form-select form-select-sm " style ="width = 10px" id="selectYear">
                
                <option selected>Seleccione un año</option>
                <option value = "2022">2022</option>
            

            </select>



            
            <div class="">

                <canvas class = "canva" style="display: block; box-sizing: border-box; height: 222px; width: 444.5px;" id="myChart2"></canvas>

            </div>
            
            
        </div>
    </div>

    <div class="row">

        <div class="col-5   ms-5 shadow bg-white border rounded-3 ">
            <table class="table table-light" id="myTable" width=100%>
                <h5 class="ms-3 mt-3">Insumos bajo cantidad critica</h5>   
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Insumo</th>
                        <th>Medida</th>
                        <th>Cantidad</th>
                        <th>Cantidad critica</th>
                
                    </tr>
                </thead>
            </table>

        </div>

        <div class="col-5   mx-5 shadow bg-white border rounded-3 ">
            <table class="table table-light" id="myTable" width=100%>
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre insumo</th>
                        <th>Unidad de medida</th>
                        <th>cantidad</th>
                
                    </tr>
                </thead>
            </table>

        </div>

    </div>

@endsection


@section('js_after')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" ></script>

    <script type="text/javascript">

        $(document).ready(function () {
            getBestSellers();
            GetSaleMonth();
            viewGraph();
        });
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
                                label: label,
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
        

        // cantidad de ventas en el mes

        function GetSaleMonth() {

            $.ajax({

                type: "GET",
                url: "{{ route('order.GetSaleMonth') }}",
                dataType: "json",
                success: function(response) {

                    resultado = response;
                    console.log(resultado)
                    $('#text').text(resultado.saleMonth[0].data);
                    $('#money').text(resultado.saleMonth[0].ganancias);
                    $('#product').text(resultado.countProducts[0].countproducts);
                    $('#supplies').text(resultado.countSupplies[0].countsupplies);
                }
                
                
            
            
            
            
            
            });




        }


        let myChart2;
        function viewGraph(){
            //////////***Graficas por años */////////////
            console.log('entre')
            $('#selectYear').on('change', function() {
            // create data from form input(s)
            
            const x = $(this).val();
            console.log(x)
            $.ajax({
            type: "GET",
            url: "{{ route('order.month') }}",
            data: {
                'year': x,
            },
            dataType: "json",
            success: function(response) {
            const resultado = response;
            console.log(resultado)
            const label = []
            const datesMoney = new Array(12);
            const datesSale = new Array(12);
            datesSale.fill(0);
            datesMoney.fill(0);
            
            let myChart;
            
            resultado.map( cantidad =>{
                        
                datesMoney[cantidad.month-1] = cantidad.data/1000;
                datesSale[cantidad.month-1] = cantidad.cantidad;
            })
            
            console.log(datesSale);
        
            const labels = ['enero','febrero','marzo','Abril','Mayo','Junio','Julio','Agosto', 'Septiembre', 'Octubre', 'Noviembre','Diciembre'];
            const data = {
            labels: labels,
            datasets: [ {
            label: 'Ganancias mensuales',
            data: datesMoney,
            borderColor: 'rgba(255, 99, 132, 0.2)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderWidth: 2,
            borderRadius: Number.MAX_VALUE,
            borderSkipped: false,
            },
            {
            label: 'Ventas mensuales',
            data: datesSale,
            borderColor: 'rgba(255, 99, 132, 0.2)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderWidth: 2,
            borderRadius: 5,
            borderSkipped: false,
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
                    type: 'bar',
                    data: data,
                    options: {
                    responsive: true,
                    plugins: {
                        legend: {
                        position: 'top',
                        },
                        title: {
                        display: false,
    
                    }
                    }
                },
            }); 
                        
                    
                    
                
            }
            }); //ajax
            });
        
        }



    </script>
@endsection
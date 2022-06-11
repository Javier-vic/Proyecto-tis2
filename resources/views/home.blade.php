@extends('layouts.navbar')

@section('content')
<div>

    <div class="col-4">
        
    </div>

</div>
<div class="col-md-4 rounded">
    <h3>Productos Mas Vendido</h3>
    <canvas width = 100px id="myChart" ></canvas>
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
    
    </script>
@endsection
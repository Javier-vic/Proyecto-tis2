@extends('layouts.navbar')

@section('content')
    <style>
        #my-chart.line {
            height: 25px;
            max-width: 100px;
            margin-top: 10px;
        }

        #my-chart.area {
            height: 50px;
            max-width: 100px;
            margin: 0 auto;
        }

        
    </style>

    <section>

    <div class="row">
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div id ="titlecantidad"class="h5">Ventas del mes</div>
                                <div class="text-lg fw-bold h2 " id="text" ></div>
                            </div>
                            <svg  width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar feather-xl text-white-50"><i class="fa-regular mt-4 fa-calendar-days fa-2xl"></i></svg>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <button class="btn text-white onselect" id = "bottoncantidad">
                            Ver ventas del año
                        </button>
                            <div class="text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center ">
                            <div class="me-3">
                                <div class="text-white-75 h5" id= "titleMoney">Ganancia mensual</div>
                                <div class="text-lg fw-bold h2 " id="money"></div>
                            </div>
                            <svg width="24" height="24" class=" text-white-50"><i class="fa-solid mt-3 fa-dollar-sign fa-2xl"></i></svg>
                        </div>
                        
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <button class="btn text-white onselect" id = "bottonMoney">
                            Ver ventas del año
                        </button>
                            <div class="text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 h5">Insumos por abastecer</div>
                                <div class="text-lg fw-bold h2" id ="supplies"></div>
                            </div>
                            <svg width="24" height="24" class=" text-white-50"><i class="fa-solid fa-boxes-packing fa-2xl mt-3"></i></svg>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                         <button class="btn text-white " data-bs-toggle="modal" data-bs-target="#listsupplies">
                            Ver insumos escasos
                        </button>
                        <div class="text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-danger text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 h5 ">Productos sin stock</div>
                                <div class="text-lg fw-bold h2" id = "product"></div>
                            </div>
                            <svg width="24" height="24" class=" text-white-50"><i class="fa-solid fa-bowl-food fa-2xl mt-3"></i></svg>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <button class="btn text-white  " data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Ver produtos sin stock
                        </button>
                        <div class="text-white"><svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M64 448c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L178.8 256L41.38 118.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160c12.5 12.5 12.5 32.75 0 45.25l-160 160C80.38 444.9 72.19 448 64 448z"></path></svg></div>
                    </div>
                </div>
            </div>
    </div>
        

    </section>

    <div class="row">

        <div class="col-md-5 col-xs-5 ms-5 mt-3 rounded shadow bg-white border rounded-3">
            <h5 class="ms-3 mt-3">Productos más vendidos</h5>
            <canvas style="height:40vh; width:80vw" id="myChart" ></canvas>
        </div>

        <div id = "grafica2" class="col-md-5 col-xs-5 ms-5 mt-3 shadow bg-white border rounded-3 h-100 " >
            <h5 class = "ms-3 mt-3">Ventas mensuales</h5>


            <select name="" class="form-select" id="selectYear">
                        <option selected>Seleccione un año</option>
                        
                        @isset($years)
                        @foreach ($years as &$valor) 

                        <option value="{{$valor->year}}">{{$valor->year}}</option>
                        
                        @endforeach
                            
                        @endisset  
    
            </select>



            
            <div class="chart-containers">

                <canvas class = "canva"  style="height:75px; width:80px" id="myChart2"></canvas>

            </div>
            
            
        </div>
    </div>

    <div>
        <div class="container mt-5">
            <div id ="titlecantidad" class="h5">Mejores clientes</div>
            <table class="table table-light">
                <thead>
                    <tr>

                        <th>nombre</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Gastado</th>
                        <th>Cantidad</th>
    
                    </tr>
                </thead>
                    <tbody id="bestClient">

                        
                    </tbody>
                </table>


        </div>

    </div>

    
<!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="listproductlLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6" id="exampleModalLabel">Productos sin stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
              
                <table class="table table-light">
                <thead>
                    <tr>

                        <th>Producto</th>
    
                    </tr>
                </thead>
                    <tbody id="listaProductos">

                        
                    </tbody>
                </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
<!-- Modal -->
    <div class="modal fade" id="listsupplies" tabindex="-1" aria-labelledby="listsuppliesLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6" id="exampleModalLabel">Productos sin stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
              
                <table class="table table-light">
                    <thead>
                        <tr>

                            <th>Suplemento</th>
                            <th>medida</th>
                            <th>Cantidad critica</th>
                            <th>Cantidad</th>
                        
                        </tr>
                    </thead>
                    <tbody id="listalistSupplies">

                        
                    </tbody>
                </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

   
<div>
</div>
@endsection


@section('js_after')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" ></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
    
    <script type="text/javascript">

        $(document).ready(function () {
            getBestSellers();
            GetSaleMonth();
            viewGraph();
            GetBestClient();
            defaultGraph();

            $(`#bottoncantidad`).click(function(e) {

                if ($(`#bottoncantidad`).hasClass(`onselect`)) {
                    console.log('aaa')
                    $(`#cantidad2`).removeClass(`d-none`);
                    $(`#bottoncantidad`).removeClass(`onselect`);
                    $(`#cantidad`).addClass('d-none');
                    $(`#bottoncantidad`).html('Ver ventas anuales');
                    $(`#titlecantidad`).html('Ventas del año');

                } else {
                    console.log('ee')
                    $(`#cantidad`).removeClass(`d-none`);
                    $(`#bottoncantidad`).addClass(`onselect`);
                    $(`#cantidad2`).addClass('d-none');
                    $(`#bottoncantidad`).html( 'Ver ventas del año');
                    $(`#titlecantidad`).html('Ventas del mes');
                   
                }

            });

            $(`#bottonMoney`).click(function(e) {

                if ($(`#bottonMoney`).hasClass(`onselect`)) {
                    console.log('aaa')
                    $(`#money2`).removeClass(`d-none`);
                    $(`#bottonMoney`).removeClass(`onselect`);
                    $(`#money1`).addClass('d-none');
                    $(`#bottonMoney`).html('Ver ganancias anuales');
                    $(`#titleMoney`).html('Ganancia del año');

                } else {
                    console.log('ee')
                    $(`#money1`).removeClass(`d-none`);
                    $(`#bottonMoney`).addClass(`onselect`);
                    $(`#money2`).addClass('d-none');
                    $(`#bottonMoney`).html( 'Ver ganancias del año');
                    $(`#titleMoney`).html('Ganancia del mes');
                
                }

            });
          
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
                    type: 'doughnut',
                    data: {
                        labels: label,
                    datasets: [{
                        label: 'My First Dataset',
                        data: date,
                        backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(0, 128, 0)',
                        'rgb(255, 73, 0  )'
                        ],
                        hoverOffset: 4
                    }]
                    },
                        
                });

                }
            
            
            });



        }
        

        // cantidad de ventas en el mes
        function GetBestClient(){

            $.ajax({

                type: "GET",
                url: "{{ route('order.getBestClient') }}",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    resultado = response;
                


                    $('#bestClient').empty();
                            resultado.map(cliente=> {
                                $('#bestClient').append(
                                    `
                                <tr>
                                    <td>${cliente.name}</td>
                                    <td>${cliente.email}</td>
                                    <td>${cliente.phone}</td>
                                    <td>${cliente.gastado}</td>
                                    <td>${cliente.cantidad}</td>
                                </tr> 
                                `
                                )
                    })


                }






            });




        }


        function GetSaleMonth() {
            
            $.ajax({

                type: "GET",
                url: "{{ route('order.GetSaleMonth') }}",
                dataType: "json",
                success: function(response) {

                    resultado = response;
                    $('#listaProductos').empty();
                            resultado.listProducts.map(product => {
                                $('#listaProductos').append(
                                    `
                                <tr>
                                    <td>${product.name_product}</td>
                                </tr> 
                                `
                                )
                    })


                    $('#listalistSupplies').empty();
                            resultado.listSupplies.map(supplies=> {
                                $('#listalistSupplies').append(
                                    `
                                <tr>
                                    <td>${supplies.name_supply}</td>
                                    <td>${supplies.unit_meassurement}</td>
                                    <td>${supplies.critical_quantity}</td>
                                    <td>${supplies.quantity}</td>
                                </tr> 
                                `
                                )
                    })

                    $('#text').append(
                                `
                                    <p class="text-lg text-white fw-bold h2 " id ="cantidad">${resultado.saleMonth[0].data}</p>
                                    <p id ="cantidad2" class="d-none text-lg text-white fw-bold h2 ">${resultado.saleYear[0].data}</p>
                                `
                    )

                    $('#money').append(
                    `
                        <p class="text-lg text-white fw-bold h2 " id ="money1">$ ${resultado.saleMonth[0].ganancias}</p>
                        <p id ="money2" class="d-none text-lg text-white fw-bold h2 ">$ ${resultado.saleYear[0].ganancias}</p>
                    `
                    )
        
                   
                    $('#product').text(resultado.countProducts[0].countproducts);
                    $('#supplies').text(resultado.countSupplies[0].countsupplies);
                 
                     

                
                
                }
                
                
            
            
            
            
            });

           

            
        }

        
        let myChart2;

        function viewGraph(){
            //////////***Graficas por años */////////////
           
            $('#selectYear').on('change', function() {
            // create data from form input(s)
            
            const x = $(this).val();
            let url = '{{ route('order.month') }}';
            $.ajax({
               
                type: "GET",
                url: url ,
                data: {
                    'year': x,
                },
                dataType: "json",
                success: function(response) {
                    const resultado = response;
                    console.log('error')
                    const label = []
                    const datesMoney = new Array(12);
                    const datesSale = new Array(12);
                    datesSale.fill(0);
                    datesMoney.fill(0);
            
                    
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
                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(0, 128, 0)',
                                        'rgb(255, 73, 0  )'],
                    borderWidth: 2,
                    borderSkipped: false,
                    },
                    {
                    label: 'Ventas mensuales',
                    data: datesSale,
                    borderColor: 'rgba(255, 99, 132, 0.2)',
                    backgroundColor: 'rgb(255, 205, 86)',
                    borderWidth: 2,
                    borderRadius: 5,
                    borderSkipped: false,
                    }]
                    };

                    if (myChart2) {
                            myChart2.destroy();
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
                            
                        
                        
                    
             },error: function(jqXHR, textStatus, errorThrown) {
                    
                    console.log(jqXHR)

                    var toastMixin = Swal.mixin({
                    toast: true,
                    icon: 'error',
                    title: 'error',
                    position: 'bottom-right',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    });
                    toastMixin.fire({
                        title:  'No se encontraron Datos de este años',
                        icon: 'error'
                    }); 


                }
            }); //ajax
            });
        
        }

        function defaultGraph(){
            //////////***Graficas por años */////////////
           
          
            var today = new Date();
            var year = today.getFullYear();
            const x = year;
            let url = '{{ route('order.month') }}';
            $.ajax({
               
                type: "GET",
                url: url ,
                data: {
                    'year': x,
                },
                dataType: "json",
                success: function(response) {
                    const resultado = response;
                    console.log('error')
                    const label = []
                    const datesMoney = new Array(12);
                    const datesSale = new Array(12);
                    datesSale.fill(0);
                    datesMoney.fill(0);
            
                
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
                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(0, 128, 0)',
                                        'rgb(255, 73, 0  )'],
                    borderWidth: 2,
                    borderSkipped: false,
                    },
                    {
                    label: 'Ventas mensuales',
                    data: datesSale,
                    borderColor: 'rgba(255, 99, 132, 0.2)',
                    backgroundColor: 'rgb(255, 205, 86)',
                    borderWidth: 2,
                    borderRadius: 5,
                    borderSkipped: false,
                    }]
                    };

                    if (myChart2) {
                            myChart2.destroy();
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
                            
                        
                        
                    
             },error: function(jqXHR, textStatus, errorThrown) {
                    
                    console.log(jqXHR)

                    var toastMixin = Swal.mixin({
                    toast: true,
                    icon: 'error',
                    title: 'error',
                    position: 'bottom-right',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    });
                    toastMixin.fire({
                        title:  'No se encontraron Datos de este años',
                        icon: 'error'
                    }); 


                }
            }); //ajax
            
        
        }

        


    </script>
@endsection
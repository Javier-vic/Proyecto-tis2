@extends('layouts.navbar')

@section('content')
@php
    use App\Http\Controllers\RoleController;    
@endphp
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

        .btn-circle {
    width: 20px;
    height: 20px;
    margin-top: 5px;
    padding: 0px 0.5px 0px 0px;
    border-radius: 15px;
    text-align: center;
    font-size: 12px;
    line-height: 1.42857;
}
    </style>
    <section>
        @if(RoleController::havePermits(auth()->user()->id_role,3))
            <div class="col-12 mb-4 rounded-pill">

                <div class="row">

                    

                    <div class="col-5  d-none pt-2" style="width:20%" id ="filter-year">

                        <select name="" class="form-select form-select-sm " id="selectYear">
                            <option value = "1" selected>Seleccione un año</option>
                            
            
                        </select>


                    </div>

                    <div class="col-5 d-none pt-2 " style="width:20%" id="filter-month">

                        <select name="" class="form-select form-select-sm" id="selectMonth">
                            <option value = "1" selected>Seleccione mes</option>
                            
            
                        </select>


                    </div>

                    <div class="col-2 pt-2 d-none" id = "delete-filter">
                    
                        <button type="button"  id ="id-delete-filter" class=" border-dark border btn bg-transparent btn-circle "><i class="fa-solid fa-x fa-xs "></i>
                        </button>                    
    
                    
                    </div>


                 

                    

                    
                    <div class="col-2 pt-1" id ="selectFilter">
                        <button class="btn btn-secondary rounded-pill text-white " data-bs-toggle="modal" data-bs-target="#showFilter">
                            Filtro graficas  <i class="fa-solid fa-plus"></i>
                        </button>

                        
                    </div>

                
            



                </div>
        
            
            </div>
        @endif
        
        <div class="row">

           
            @if(RoleController::havePermits(auth()->user()->id_role,3))

                <div class="col-lg-3 col-xl-3 mb-4">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div id ="titlecantidad"class="h5">Ventas del mes</div>
                                    <div class="row mt-3 pt-1">
                                        <div class="col"><i class="fa-regular mt-4 fa-calendar-days fa-2xl"></i></div>
                                        <div class="text-lg fw-bold h2 col mt-2 me-5" id="text" ></div>
                                    </div>
                                   
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-footer footer d-flex align-items-center justify-content-between small">
                            <button class="btn text-white onselect" id = "bottoncantidad">
                                Ver ventas del año
                            </button>
                        </div>
                    
                    </div>
                </div>

                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center ">
                                <div class="me-3">
                                    <div class="text-white-75 h5" id= "titleMoney">Ganancias del mes</div>
                                    
                                    <div class="mt-4 pt-1 text-center" id ="dateMoney">
                                        <div class="text-lg fw-bold h2 " id="money"></div>
                                    </div>
                                </div>
                                
                            </div>                    
                        </div>
                        <div class="card-footer d-flex footer align-items-center justify-content-between small">
                            <button class="btn text-white onselect" id = "bottonMoney">
                                Ver ganancias del año
                            </button>
                         </div>
                    </div>
                </div>

            

       
            @endif

            @if(RoleController::havePermits(auth()->user()->id_role,2))
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 h5">Insumos por abastecer</div>
                                    <div class="row mt-3 pt-1">
                                        <div class="col"><i class="fa-solid fa-boxes-packing fa-2xl mt-4"></i></div>
                                        <div class="text-lg fw-bold h2 mt-2 me-4 col pe-5" id ="supplies"></div>
                                    </div>
                                   
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <button class="btn text-white " data-bs-toggle="modal" data-bs-target="#listsupplies">
                                Ver insumos escasos
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            
            @if(RoleController::havePermits(auth()->user()->id_role,7))
                <div class="col-lg-6 col-xl-3 mb-4">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <div class="text-white-75 h5 ">Productos sin stock</div>
                                    <div class="row mt-3 pt-1">
                                        <div class="col"><i class="fa-solid fa-bowl-food fa-2xl mt-4"></i></div>
                                        <div class="text-lg fw-bold h2 col mt-2 me-5 pe-4" id = "product"></div>
                                    </div>
                                   
                                   
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between small">
                            <button class="btn text-white  " data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Ver produtos sin stock
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div class="row">

        <div class="col-md-5 col-xs-5 ms-5 mt-3 rounded shadow bg-white border rounded-3">
            <h5 id ="titleBestProduct"class="ms-3 mt-3">Productos más vendidos</h5>
            <canvas style="height:40vh; width:80vw" id="myChart" ></canvas>
        </div>
     
        <div id = "grafica2"style="height: 300px" class="col-md-5 col-xs-5 ms-5 mt-3 shadow bg-white border rounded-3 h-100 " >
            <h5 class = "ms-3 mt-3">Ventas mensuales</h5>

            <div class="chart-containers">
            

                <canvas class = "canva" width="400" height="400"   id="myChart2"></canvas>

            </div>
        </div>
    
    </div>

    <div>
        <div class="container mt-5">
            <div id ="titlecantidad" class="h5">Mejores clientes</div>
            <table class="table table-light">
                <thead>
                    <tr>

                        <th>Nombre</th>
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
    </div>
<!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="listproductlLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6" id="exampleModalLabel">Productos sin stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" >
                
                <table class="table table-light" >
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

<!-- Modal listar suplementos-->
    <div class="modal fade" id="listsupplies" tabindex="-1" aria-labelledby="listsuppliesLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6" id="exampleModalLabel">Insumos por abastecer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                <a href="javascript:imprSelec('seleccion')" >Imprimir texto</a>
                
                <div id="seleccion">

                    <table class="table table-light">
                        <thead>
                            <tr>
    
                                <th>Suplemento</th>
                                <th>Medida</th>
                                <th>Cantidad critica</th>
                                <th>Cantidad</th>
                            
                            </tr>
                        </thead>
                        <tbody id="listalistSupplies">
    
                            
                        </tbody>
                    </table>

                </div>
                
                
            </div>
            <script language="Javascript">
                function imprSelec(nombre) {
                  var ficha = document.getElementById(nombre);
                  var ventimp = window.open(' ', 'popimpr');
                  ventimp.document.write( ficha.innerHTML );
                  ventimp.document.close();
                  ventimp.print( );
                  ventimp.close();
                }
            </script>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal filtros -->
    <div class="modal fade" id="showFilter" tabindex="-1" aria-labelledby="showFilterLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6" id="exampleModalLabel">Agregar filtro estadistico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >

                <div class="form-check form-switch" id= "filterYear">
                    <input class="form-check-input" type="checkbox" id="boxFilterYear">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Filtro años</label>
                </div>

                <div class="form-check form-switch" id = "filterMonth">
                    <input class="form-check-input" type="checkbox" id="boxFilterMonth">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Filtro por año y mes</label>
                </div>
                
                
                
            </div>
          
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>

            </div>
        </div>
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

           
        
            
           
            //console.log(@json(RoleController::havePermits(auth()->user()->id_role,1)));
            if(@json(RoleController::havePermits(auth()->user()->id_role,3))){
                //order
                GetSaleMonth();
                getBestSellers();
                logicFilter()
                filter();
                GetBestClient();
                defaultGraph();
            }
            if(@json(RoleController::havePermits(auth()->user()->id_role,7))){
                //products
                $.ajax({
                    type: "GET",
                    url: "{{route('productDashboard')}}",
                    dataType: "json",
                    success: function (response) {
                        $('#listaProductos').empty();
                        $('#product').text(response.countProducts[0].countproducts);
                        response.listProducts.map(product => {
                            $('#listaProductos').append(
                                `
                                <tr>
                                    <td>${product.name_product}</td>
                                </tr> 
                                `
                            )
                        })
                    }
                });
            }
            if(@json(RoleController::havePermits(auth()->user()->id_role,2))){
                //supply
                $.ajax({
                    type: "GET",
                    url: "{{route('supplyDashboard')}}",
                    data: "json",
                    success: function (response) {           
                        $('#supplies').text(response.countSupplies[0].countsupplies);
                        $('#listalistSupplies').empty();
                        response.listSupplies.map(supplies=> {
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
                    }
                });
            }

            $(`#bottoncantidad`).click(function(e) {

                if ($(`#bottoncantidad`).hasClass(`onselect`)) {
                    $(`#cantidad2`).removeClass(`d-none`);
                    $(`#bottoncantidad`).removeClass(`onselect`);
                    $(`#cantidad`).addClass('d-none');
                    $(`#bottoncantidad`).html('Ver ventas anuales');
                    $(`#titlecantidad`).html('Ventas del año');

                } else {
                    $(`#cantidad`).removeClass(`d-none`);
                    $(`#bottoncantidad`).addClass(`onselect`);
                    $(`#cantidad2`).addClass('d-none');
                    $(`#bottoncantidad`).html( 'Ver ventas del año');
                    $(`#titlecantidad`).html('Ventas del mes');
                }
            });
            $(`#bottonMoney`).click(function(e) {

                if ($(`#bottonMoney`).hasClass(`onselect`)) {
                    $(`#money2`).removeClass(`d-none`);
                    $(`#bottonMoney`).removeClass(`onselect`);
                    $(`#money1`).addClass('d-none');
                    $(`#bottonMoney`).html('Ver ganancias anuales');
                    $(`#titleMoney`).html('Ganancias del año');

                } else {
                    $(`#money1`).removeClass(`d-none`);
                    $(`#bottonMoney`).addClass(`onselect`);
                    $(`#money2`).addClass('d-none');
                    $(`#bottonMoney`).html( 'Ver ganancias del año');
                    $(`#titleMoney`).html('Ganancias del mes');
                
                }

            });
          
        });

        // filtro -<<
        function imprSelec(nombre) {
                  var ficha = document.getElementById(nombre);
                  var ventimp = window.open(' ', 'popimpr');
                  ventimp.document.write( ficha.innerHTML );
                  ventimp.document.close();
                  ventimp.print( );
                  ventimp.close();
        }


        function logicFilter(){

            $("#id-delete-filter").click(function (e) { 
                location.reload();
                
            });

            /// Filtro datos


            $('#boxFilterYear').on( 'click', function() {
                if( $(this).is(':checked') ){
                    // Hacer algo si el checkbox ha sido seleccionado
                    $("#filter-year").removeClass('d-none');
                    $("#boxFilterMonth").attr("disabled", true);
                    $("#delete-filter").removeClass('d-none')
                    $("#selectYear").val($("#selectYear option:first").val());
                    $("#delete-filter").removeClass('d-none')
                    $("#selectFilter").addClass('d-none')
                   
                    

                } else {
                    // Hacer algo si el checkbox ha sido deseleccionado
                    $("#boxFilterMonth").removeAttr("disabled");
                    $("#filter-year").addClass('d-none');
                    $("#delete-filter").addClass('d-none')
                    $("#selectFilter").removeClass('d-none')
                }
            
            });

            $('#boxFilterMonth').on( 'click', function() {
                if( $(this).is(':checked') ){
                    // Hacer algo si el checkbox ha sido seleccionado
                    
                    $("#filter-month").removeClass('d-none');
                    $("#filter-year").removeClass('d-none')
                    $("#delete-filter").removeClass('d-none')
                    $("#boxFilterYear").attr("disabled", true);
                    $("#selectYear").val($("#selectYear option:first").val());
                    $("#selectFilter").addClass('d-none')
                    
                    

                } else {
                    // Hacer algo si el checkbox ha sido deseleccionado
                    $("#boxFilterYear").removeAttr("disabled");
                    $("#delete-filter").addClass('d-none')
                    $("#filter-month").addClass('d-none');
                    $("#filter-year").addClass('d-none');
                    $("#selectFilter").removeClass('d-none')
                    

                }
            
            });


        }


        function filter(){
            var month,year

            $("#selectYear").change(function (e) { 
               // año y mes
                if(!($("#filter-year").hasClass("d-none")) && !($("#filter-month").hasClass("d-none")))
               {    
                    year = $("#selectYear").val();
                    console.log("año")
                    selectMonth(year);
                    
                   $("#selectMonth").change(function (e) { 

                        month = $("#selectMonth").val();

                        filterYearMonth(year,month)
                    
                    });
               
               
               
                }

                // año
                if(!($("#filter-year").hasClass("d-none")) && ($("#filter-month").hasClass("d-none")))
               {
                    year = $("#selectYear").val();
                    filterYear(year);
                    console.log("mes")
                }
                
                
            });


        }

        ////////////////////////////////////
        // Grafiva producto mas vendido
        //*////////////////////////////////////
        var myChart;        
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

        function setmonth(){

            //////////***Graficas por años */////////////
           
            $('#selectYear').on('change', function() {
            // create data from form input(s)
            
            const x = $(this).val();
            if(x == 1 ){

                location.reload();

            }
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
           
                    console.log(resultado)


                    $('#selectMonth').append(
                        `
                            <option value="${resultado.years[0].year}">${resultado.years[0].year}</option>
                           
                        `
                    )
                    
                  
                
            


                
                },error: function(jqXHR, textStatus, errorThrown) {
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
                            title:  'No se encontraron Datos de meses',
                            icon: 'error'
                        }); 
                    }

            }); //ajax
            });

            
        }
        

        // cantidad de ventas en el mes
        function GetBestClient(){

            
            $.ajax({
                type: "GET",
                url: "{{ route('order.getBestClient') }}",
                dataType: "json",
                success: function(response) {
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
                    console.log(resultado.years[0].year);

              

                    $('#selectYear').append(
                        `
                            <option value="${resultado.years[0].year}">${resultado.years[0].year}</option>
                           
                        `
                    )

                    $('#text').append(
                        `
                            <p class="text-lg text-white fw-bold h2 " id ="cantidad">${resultado.saleMonth[0].data}</p>
                            <p id ="cantidad2" class="d-none text-lg text-white fw-bold h2 ">${resultado.saleYear[0].data}</p>
                        `
                    )

                    var money1 = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(resultado.saleMonth[0].ganancias)
                    var money2 = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(resultado.saleYear[0].ganancias)
                    $('#money').append(
                    `
                        <p class="text-lg text-white fw-bold h2 " id ="money1">${money1}</p>
                        <p id ="money2" class="d-none text-lg text-white fw-bold h2 ">${money2}</p>
                    `
                    )   
                }
            });
        }

        // grafica pastel
        function graftPast(variable,datos){


            if (myChart) {
                myChart.destroy();
            }
            const ctx = document.getElementById('myChart');
            myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: datos,
                datasets: [{
                    label: 'My First Dataset',
                    data: variable,
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

        let myChart2;

        function filterYear(x){
            //////////***Graficas por años */////////////
           
           
            // create data from form input(s)
            
            
            if(x == 1 ){

                location.reload();

            }
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
                    const label = []
                    const datesMoney = new Array(12);
                    const datesSale = new Array(12);
                    var datos = []
                    var variable = []
                    console.log("lolo"+resultado)
                    datesSale.fill(0);
                    datesMoney.fill(0);

                    resultado[0].map( products =>{ 
                        
                        variable.push(products.cantida);
                        datos.push(products.name_product);

                    })
                
                    
                    var money = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(resultado[2][0].data)
                    console.log(money)
                    $(`#cantidad`).addClass('d-none');
                    $(`#cantidad2`).addClass('d-none');
                    $(`#bottoncantidad`).addClass('d-none');
                    $(`#titlecantidad`).html('Ventas del año '+ x);
                    $('#text').html(resultado[2][0].cantidad);
                    $('#money').html(money);
                    $(".footer").addClass('d-none');
                    $("#text").addClass("pe-5");



                
            
                    $(`#money1`).addClass('d-none');
                    $(`#money2`).addClass('d-none');
                    $(`#bottonMoney`).addClass('d-none');
                    $(`#titleMoney`).html('Ganancias del año '+x);

                    

                 
            
                    
                    resultado[1].map( cantidad =>{
                                
                        datesMoney[cantidad.month-1] = cantidad.data/1000;
                        datesSale[cantidad.month-1] = cantidad.cantidad;
                    })

                     
                    
                    
                    graftPast(variable,datos)
                    const labels = ['Enero','Febrero','marzo','Abril','Mayo','Junio','Julio','Agosto', 'Septiembre', 'Octubre', 'Noviembre','Diciembre'];
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

                    var ctx = document.getElementById(`myChart2`).getContext('2d')
                    ctx.height = 300;
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

        function filterYearMonth(year,month)
        {


            
            let url = '{{ route('order.filterYearMonth') }}';
            $.ajax({
               
                type: "GET",
                url: url ,
                data: {
                    'year': year,
                    'month': month,
                },
                dataType: "json",
                success: function(response) {
                    const resultado = response;
                    console.log(resultado)
                    var meses = ["","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                    label = []
                    date = []

                    resultado[0].map(product =>{

                        date.push(product.cantida);
                        label.push(product.name_product);




                    })
                    var money = new Intl.NumberFormat('es-CL', {currency: 'CLP', style: 'currency'}).format(resultado[2][0].ganancias)
                    graftPast(date,label)

                    $(`#cantidad`).addClass('d-none');
                    $(`#cantidad2`).addClass('d-none');
                    $(`#bottoncantidad`).addClass('d-none');
                    $(`#titlecantidad`).html('Ventas del '+ meses[7]+' - '+year);
                    $('#text').html(resultado[2][0].data);
                    $('#money').html(money);
                    $(".footer").addClass('d-none');
                    $("#text").addClass("pe-5");
                    $("#dateMoney").removeClass("mt-4");
                    $("#dateMoney").removeClass("pt-1");
                  



                
            
                    $(`#money1`).addClass('d-none');
                    $(`#money2`).addClass('d-none');
                    $(`#bottonMoney`).addClass('d-none');
                    $(`#titleMoney`).html('Ganancias de '+ meses[7]+' - '+year);
                    
                
                    },error: function(jqXHR, textStatus, errorThrown) {
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
                            title:  'No se encontraron datos de este años',
                            icon: 'error'
                        }); 
                    }

            }); //ajax


        }

        function selectMonth(x){

            console.log(x)
            let url = '{{ route('order.selectMonth') }}';
            $.ajax({
               
                type: "GET",
                url: url ,
                data: {
                    'year': x,
                },
                dataType: "json",
                success: function(response) {
                    const resultado = response;

                    var meses = ["","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                    
                    $("#selectMonth").empty().append('<option selected value="0">Seleccione una mes..</option>');
                    resultado.map( month =>{


                        $('#selectMonth').append(
                            `
                                <option value="${month.month}">${meses[month.month]}</option>
                            
                            `
                        )

                        
                    })



                
            


                
                    },error: function(jqXHR, textStatus, errorThrown) {
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
                            title:  'No se encontraron datos de este años',
                            icon: 'error'
                        }); 
                    }

            }); //ajax


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
                    console.log(resultado)
                    const label = []
                    const datesMoney = new Array(12);
                    const datesSale = new Array(12);
                    datesSale.fill(0);
                    datesMoney.fill(0);
                    resultado[1].map( cantidad =>{
                                
                        datesMoney[cantidad.month-1] = cantidad.data/1000;
                        datesSale[cantidad.month-1] = cantidad.cantidad;
                    })
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
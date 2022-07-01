@extends('layouts.navbar')

@section('titlePage')
    <h2>Cupónes enviados </h3>
@endsection


@section('content')

    <div class="">
        @include('Mantenedores.SendCoupon.modal.modal')
    </div>

    
    <div class="row my-4">
        <div class="col d-flex justify-content-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#enviarCupon"> Enviar cupón</button>
        </div>
    </div>
    
    <table class="responsive display nowrap " id="myTable" width=100%>
        <thead class="text-white bg-secondary">
            <tr>
                
                <th>Fecha emitida</th>
                <th>Cupón</th>
                <th>Cantidad</th>
                <th>Tipo cliente</th>

            </tr>
        </thead>
    <table>

  

@endsection


@section('js_after')
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" ></script>

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
                url: "{{ route('sendCoupon.index') }}",
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
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'emited',
                    name: 'emited'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'clientype',
                    name: 'clientype'
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



        
    
    

        const sendCoupon = (e) => {
            e.preventDefault();

            var formData = new FormData(e.currentTarget);
            var url = '{{ route('order.store') }}';
            
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
                        title: 'Se ingresó la orden correctamente.',
                        showConfirmButton: false,
                        timer: 2000,
                        backdrop: false,
                        heightAuto: false,
                    })
                    location.reload();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                  

                }

            });

            
        }
    </script>

@endsection

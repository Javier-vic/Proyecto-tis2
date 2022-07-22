<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
<a class="navbar-brand d-none d-lg-block" href="/"><img
                    src="https://tolivmarket-production.s3.sa-east-1.amazonaws.com/companies/logos/8a17cb17fcb7d1012e47f83078ee24b603fd0fa1d9628ad486d5cb43bacbb81c.jpg"
                    alt="" width="75" height="75"></a>
<div class="container text-center">
    <div class="row my-5">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 border border-success p-4 bg-white shadow-lg rounded">
            <div class="text-center">
                <i class="h1 text-success fa-regular fa-circle-check"></i>
            </div>
            <div>
                <h2>SU PAGO SE CONCRETÓ CON ÉXITO</h2>
            </div>
            <div class="text-start p-2 m-2">
                <div class="p-1">Orden de compra : <b>{{ $orden_compra }}</b></div>
                <div class="p-1">Fecha de transacción : <b>{{ $fecha_compra }}</b></div>
                <div class="p-1">Estado de transacción : <b>Pago realizado con éxito</b></div>
                <div class="p-1">Correo eléctronico : <b>{{ $correo_comprador }}</b></div>
                <div class="p-1">Subtotal : <b>${{ $monto }}</b></div>
                <div class="p-1">Medio de pago : <b>{{ $medio_pago }}</b></div>
            </div>
            <button type="button" class="btn btn-outline-danger"><a href="/" class="text-reset fw-bold">Volver</a></button>
        </div>
        <div class="col-lg-3"></div>
    </div>
</div>

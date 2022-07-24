<style>
    table {
        border: 1px solid;
    }

    .outside-border {

        border: 1px solid;
    }

    .borders {
        border-top: 1px solid;
        border-right: 1px solid;
    }
</style>
<div style="width: 300px; margin:0 auto;">
    @foreach ($datosOrden as $datos)
        <div class="outside-border">
            <h2 style="margin: 0;padding:0;text-align: center;"><b>BOLETA ELECTRÓNICA</b></h2>
            <h2 style="margin: 0 auto;padding:0; text-align: center;"><b>N° {{ $datos->id }}</b></h2>
        </div>
        <h2 style="text-align: center;">S.I.I. - CHILLÁN</h2>
        <h2 style="text-align: center;">Ramen Dashi</h2>

        <p><b>Emisión</b> : {{ $datos->created_at }}</p>
        <p><b>Dirección</b> : {{ $direccionLocal }}</p>

        {{-- <p>{{ $datos->name_order }}</p> --}}

        <p><b>Forma de pago : </b>{{ $datos->payment_method }}</p>
    @endforeach
    <table>
        <tr>
            <th>Item</th>
            <th>P.unitario</th>
            <th>Cantidad</th>
            <th>Total item</th>
        </tr>
        <tbody>
            @foreach ($productosComprados as $index => $producto)
                <tr>
                    <td class="borders">{{ $productosComprados[$index]->name_product }}</td>
                    <td class="borders">{{ $productosComprados[$index]->price }}</td>
                    <td class="borders">{{ $productosComprados[$index]->cantidad }}</td>
                    <td class="borders">
                        {{ $productosComprados[$index]->cantidad * $productosComprados[$index]->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>
    <p><b>Total : </b><span>$ {{ $datos->total }}</span></p>
    <span style="font-size: .8rem;">*El total puede variar debido a cupones de dcto o método de pago
        seleccionado.</span>

</div>

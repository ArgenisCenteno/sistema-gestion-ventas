<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Venta</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 0;
            
            width: 240px; /* Ancho típico para recibo térmico */
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        td, th {
            padding: 2px 0;
            text-align: left;
        }

        .totales td {
            text-align: right;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .qr {
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="center">
        <div class="bold">COMERCIAL YASMELIS RONDÓN</div>
        <div>RIF: V-09281465-0</div>
        <div>Tel: 0412-0000000</div>
    </div>

    <div class="line"></div>

    <table>
        <tr>
            <td class="bold">Recibo N°:</td>
            <td>{{ $venta->id }}</td>
        </tr>
        <tr>
            <td class="bold">Fecha:</td>
            <td>{{ $fechaVenta }}</td>
        </tr>
        <tr>
            <td class="bold">Cliente:</td>
            <td>{{ $userArray['name'] }}</td>
        </tr>
        <tr>
            <td class="bold">Vendedor:</td>
            <td>{{ $vendedorArray['name'] }}</td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cant</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venta->detalleVentas as $detalle)
                <tr>
                    <td>{{ Str::limit($detalle->producto->nombre, 10) }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->precio_producto, 2) }}</td>
                    <td>{{ number_format($detalle->neto + $detalle->impuesto, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="line"></div>

    <table class="totales">
        <tr>
            <td class="bold">TOTAL:</td>
            <td class="bold">{{ number_format($venta->pago->monto_total, 2) }} Bs</td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th>Método</th>
                <th>Bs</th>
                <th>Div</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalBs = 0;
                $totalDiv = 0;
            @endphp
            @foreach (json_decode($venta->pago->forma_pago) as $pago)
                @if ($pago->monto > 0)
                    <tr>
                        <td>{{ $pago->metodo }}</td>
                        <td>
                            {{ $pago->metodo == 'Divisa' ? '0,00' : number_format($pago->monto, 2) }}
                        </td>
                        <td>
                            {{ $pago->metodo == 'Divisa' ? number_format($pago->monto, 2) : '0,00' }}
                        </td>
                    </tr>
                    @php
                        if ($pago->metodo == 'Divisa') {
                            $totalDiv += $pago->monto;
                        } else {
                            $totalBs += $pago->monto;
                        }
                    @endphp
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="line"></div>

    <div class="center">
        <div class="bold">¡Gracias por su compra!</div>
        <div>Este documento no es válido como factura fiscal.</div>
    </div>

    @if(isset($qrCode))
        <div class="qr">
            {!! $qrCode !!}
            <small>Escanea para verificar</small>
        </div>
    @endif
</body>
</html>

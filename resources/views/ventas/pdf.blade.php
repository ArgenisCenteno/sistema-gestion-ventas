<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
            border: none;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .footer div {
            width: 48%;
        }
        .signature {
            text-align: center;
            padding-top: 10px;
            border-top: 1px solid #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>RECIBO DE VENTA</h1>
        <table>
            <thead>
                <tr>
                    <th colspan="2" style="font-size: 22px; font-weight: bold;">SISTEMA</th>
                    <th style="font-size: 16px; text-align: center;">
                        <strong>RECIBO NRO: {{$venta->id}}</strong>
                    </th>
                </tr>
                <tr>
                    <th style="font-size: 16px;">Fecha de Emisión:</th>
                    <td style="font-size: 16px;">{{$fechaVenta}}</td>
                    <th style="font-size: 16px; text-align: center;"> </th>
                </tr>
            </thead>
        </table>

        <!-- Datos del Cliente -->
        <table>
            <thead>
                <tr>
                    <th>CLIENTE</th>
                    <th>VENDEDOR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$userArray['name']}}</td>
                    <td>{{$vendedorArray['name']}}</td>
                </tr>
            </tbody>
        </table>

        <!-- Conceptos de los productos -->
        <table>
            <thead>
                <tr>
                    <th>DESCRIPCIÓN</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO UNITARIO</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalleVentas as $detalle)
                    <tr>
                        <td>{{$detalle->producto->nombre}}</td>
                        <td>{{$detalle->cantidad}}</td>
                        <td>{{number_format($detalle->precio_producto, 2)}}</td>
                        <td>{{number_format($detalle->impuesto + $detalle->neto, 2)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="font-weight: bold; text-align: right;">TOTAL</td>
                    <td><strong>{{number_format($venta->pago->monto_total, 2)}}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Métodos de pago -->
        <table>
            <thead>
                <tr>
                    <th>METODO DE PAGO</th>
                    <th>MONTO</th>
                    <th>DIVISA</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalBolivares = 0;
                    $totalDivisa = 0;
                @endphp
                @foreach (json_decode($venta->pago->forma_pago) as $pago)
                    @if($pago->monto > 0 )
                        <tr>
                            <td>{{ $pago->metodo }}</td>
                            <td>
                                {{ $pago->metodo == 'Divisa' ? number_format(0, 2) : number_format($pago->monto, 2) }}
                            </td>
                            <td>
                                {{ $pago->metodo != 'Divisa' ? number_format(0, 2) : number_format($pago->monto, 2) }}
                            </td>
                        </tr>
                        @php
                            if ($pago->metodo != 'Divisa') {
                                $totalBolivares += $pago->monto;
                            } else {
                                $totalDivisa += $pago->monto;
                            }
                        @endphp
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="font-weight: bold;">Totales</td>
                    <td style="font-weight: bold;">{{ number_format($totalBolivares, 2) }}</td>
                    <td style="font-weight: bold;">{{ number_format($totalDivisa, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        

    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CompuBits</title>
</head>

<body
    style="font-family: Arial, sans-serif; margin: 0; padding: 10px; line-height: 1.6; border: none; background-color: #f9f9f9;">
    <div
        style="max-width: 800px; margin: auto; padding: 10px; border-radius: 8px; background: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <!-- Encabezado -->
      
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <!-- Columna para el Logo -->
                    <th style="border: 1px solid black; padding: 8px; text-align: center; font-size: 18px; width: 15%;">
                    <img src="{{ public_path('iconos/logo-final.png') }}" alt="Logo"
                            style="max-width: 100px; height: auto;">
                    </th>
                    <!-- Columna para el Nombre de la Empresa -->
                    <th colspan="2"
                        style="border: 1px solid black; padding: 8px; text-align: center; font-size: 22px; font-weight: bold; width: 70%;">
                        <h3 style="text-align: center; color: black; font-size: 24px; margin: 20px 0;">COMPROBANTE DE SERVICIO</h3>
                    </th>
                    <!-- Columna para el Número de Venta -->
                    
                    <th style="border: 1px solid black; padding: 8px; text-align: center; font-size: 16px; width: 15%;">
                        {{$fechaVenta}}
                    </th>
                </tr>
            </thead>
        </table>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <!-- Columna para el Logo -->
                    <th style="border: 1px solid black; padding: 8px; text-align: center; font-size: 18px; width: 15%;">
                    <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code"
                    style="max-width: 200px; height: auto;">
                    </th>
                    <!-- Columna para el Nombre de la Empresa -->
                    <th colspan="2"
                        style="border: 1px solid black; padding: 8px; text-align: center; font-size: 22px; font-weight: bold; width: 70%;">
                        COMPUBITS C.A
                    </th>
                    <!-- Columna para el Número de Venta -->
                    @php
                        $id = str_pad($venta->id, 8, "0", STR_PAD_LEFT);
                    @endphp
                    <th style="border: 1px solid black; padding: 8px; text-align: center; font-size: 22px; width: 15%;">
                        {{$id}}
                    </th>
                </tr>
            </thead>
        </table>


        <!-- Título -->
            <h5 class="text-center">Detalles de Mantenimiento</h5>
        <!-- Detalles del cliente y vendedor -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px; text-align: left;">CLIENTE</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left;">VENDEDOR.</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td style="padding: 8px; border: 1px solid black;">{{$userArray['name']}}</td>
                    <td style="padding: 8px; border: 1px solid black;">{{$vendedorArray['name']}}</td>


                </tr>
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px; text-align: left;">DESCRIPCIÓN</th>
                    
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td style="padding: 8px; border: 1px solid black;">{{$venta->descripcion}}</td>
                    
                </tr>
            </tbody>
        </table>
        <h5 class="text-center">Detalles de Producto</h5>
        <!-- Tabla de productos -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px; text-align: left;">PRODUCTO</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left;">CANT.</th>
                    <th style="border: 1px solid black; padding: 8px; text-align: left;">PRECIO UNIT.</th>

                    <th style="border: 1px solid black; padding: 8px; text-align: left;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalles as $detalle)
                    <tr>
                        <td style="padding: 8px; border: 1px solid black;">{{$detalle->producto->nombre}}</td>
                        <td style="padding: 8px; border: 1px solid black;">{{$detalle->cantidad}}</td>
                        <td style="padding: 8px; border: 1px solid black;">{{$detalle->precio_producto}}</td>

                        <td style="padding: 8px; border: 1px solid black;">
                            {{number_format($detalle->impuesto + $detalle->neto, 2)}}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td style="padding: 8px; border: 1px solid black;"></td>
                    <td style="padding: 8px; border: 1px solid black;"></td>
                    <td style="padding: 8px; border: 1px solid black;"></td>

                    <td style="padding: 8px; border: 1px solid black;">
                        <strong> {{number_format($venta->pago->monto_total, 2)}}</strong>
                    </td>

                </tr>
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr>
            <th style="border: 1px solid black; padding: 8px; text-align: left;">METODO DE PAGO</th>
            <th style="border: 1px solid black; padding: 8px; text-align: left;">MONTO</th>
            <th style="border: 1px solid black; padding: 8px; text-align: left;">DIVISA</th>
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
                <td style="padding: 8px; border: 1px solid black;">{{ $pago->metodo }}</td>
                <td style="padding: 8px; border: 1px solid black;">
                    {{ $pago->metodo == 'Divisa' ? number_format(0, 2) : number_format($pago->monto, 2) }}
                </td>
                <td style="padding: 8px; border: 1px solid black;">
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
            <td style="padding: 8px; border: 1px solid black; font-weight: bold;">Totales</td>
            <td style="padding: 8px; border: 1px solid black; font-weight: bold;">
                {{ number_format($totalBolivares, 2) }}
            </td>
            <td style="padding: 8px; border: 1px solid black; font-weight: bold;">
                {{ number_format($totalDivisa, 2) }}
            </td>
        </tr>
    </tfoot>
</table>

        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
    <!-- QR Code -->
     

    <!-- Espacio para firma -->
    <div style="flex: 1; text-align: center; padding-top: 10px; border-top: 1px solid #000;">
        <p>Firma del Cliente</p>
        <div style="height: 50px; border: 1px dashed #000;"></div>
    </div>
</div>

    </div>
</body>

</html>
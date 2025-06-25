<table>
    <thead style="background-color: #007bff; color: white;">
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Monto Total</th>
            <th>Descuento (%)</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalMonto = 0;
            $totalDescuento = 0;
            $contador = 0;
        @endphp

        @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->id }}</td>
                <td>{{ $venta->created_at->format('Y-m-d') }}</td>
                <td>{{ $venta->user->name ?? 'N/A' }}</td>
                <td>{{ $venta->vendedor->name ?? 'N/A' }}</td>
                <td>{{ number_format($venta->monto_total, 2) }}</td>
                <td>{{ number_format($venta->porcentaje_descuento, 2) }}</td>
                <td>{{ $venta->status }}</td>
            </tr>
            @php
                $totalMonto += $venta->monto_total;
                $totalDescuento += $venta->porcentaje_descuento;
                $contador++;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr style="font-weight: bold; background-color: #f2f2f2;">
            <td colspan="4" style="text-align: right;">Totales:</td>
            <td>{{ number_format($totalMonto, 2) }}</td>
            <td>{{ $contador > 0 ? number_format($totalDescuento / $contador, 2) : '0.00' }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>

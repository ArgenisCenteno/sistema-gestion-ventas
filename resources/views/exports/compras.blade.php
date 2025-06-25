<table>
    <thead>
        <tr style="background-color: #007bff; color: white;">
            <th>ID</th>
            <th>Fecha</th>
            <th>Proveedor</th>
            <th>Usuario</th>
            <th>Monto Total</th>
            <th>Descuento (%)</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalMonto = 0;
            $totalDescuento = 0;
            $count = 0;
        @endphp

        @foreach($compras as $compra)
            <tr>
                <td>{{ $compra->id }}</td>
                <td>{{ $compra->created_at->format('Y-m-d') }}</td>
                <td>{{ $compra->proveedor->name ?? 'N/A' }}</td>
                <td>{{ $compra->user->name ?? 'N/A' }}</td>
                <td>{{ number_format($compra->monto_total, 2) }}</td>
                <td>{{ number_format($compra->porcentaje_descuento, 2) }}</td>
                <td>{{ $compra->status }}</td>
            </tr>
            @php
                $totalMonto += $compra->monto_total;
                $totalDescuento += $compra->porcentaje_descuento;
                $count++;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr style="font-weight: bold; background-color: #f2f2f2;">
            <td colspan="4" style="text-align: right;">Totales:</td>
            <td>{{ number_format($totalMonto, 2) }}</td>
            <td>{{ $count > 0 ? number_format($totalDescuento / $count, 2) : '0.00' }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>

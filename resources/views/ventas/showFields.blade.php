<div class="">
  <!-- Información de la Venta -->

  <div class="card mb-4">
    <div class="card-header">
      <h5>Detalles de la Venta</h5>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Vendedor</th>
            <th>Cliente</th>
            <th>Monto Total</th>
            <th>Monto Neto</th>
            <th>Estado del Pago</th>
            <th>Fecha de Venta</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $venta->vendedor->name ?? 'S/D' }}</td>
            <td>{{ $venta->user->name }}</td>
            <td>{{ number_format($venta->pago->monto_total, 2) }}</td>
            <td>{{ number_format($venta->pago->monto_neto, 2) }}</td>
            <td>{{ $venta->pago->status }}</td>
            <td>{{ $venta->created_at->format('Y-m-d') }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>


  <!-- Detalles de Venta -->
  <div class="card mb-4">
    <div class="card-header">
        <h5>Productos</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venta->detalleVentas as $detalle)
                <tr>
                    <td>{{ $detalle->id }}</td>
                    <td>
                        @if($detalle->producto->imagenes->first())
                            <img src="{{ asset( $detalle->producto->imagenes->first()->url) }}" alt="Imagen del producto" style="width: 50px; height: auto;">
                        @else
                            <span>S/I</span>
                        @endif
                    </td>
                    <td>{{ $detalle->producto->nombre }}</td>
                  
                    <td>{{ number_format($detalle->precio_producto, 2) }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->neto, 2) }}</td>
                    <td>{{ number_format($detalle->impuesto, 2) }}</td>
                    <td>{{ number_format($detalle->impuesto + $detalle->neto, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


  <!-- Pago -->
  <div class="card mb-4">
    <div class="card-header">
      <h5>Detalles del Pago</h5>
    </div>
    <div class="card-body  table-responsive">
      <table class="table table-hover ">
        <thead>
          <tr>
            <th>#</th>
            <th>Monto Total</th>
            <th>Monto Neto</th>
            <th>Impuestos</th>
            <th>Tasa de Dólar</th>
            <th>Fecha de Pago</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $venta->pago->id }}</td>
            <td>{{ number_format($venta->pago->monto_total, 2) }}</td>
            <td>{{ number_format($venta->pago->monto_neto, 2) }}</td>
            <td>{{ number_format($venta->pago->impuestos, 2) }}</td>
            <td>{{ number_format($venta->pago->tasa_dolar, 2) }}</td>
            <td>{{ $venta->pago->fecha_pago }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <h5>Método de Pago</h5>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Método</th>
            <th>Monto Bs</th>
            <th>Monto USD</th>
          </tr>
        </thead>
        <tbody>
          @foreach (json_decode($venta->pago->forma_pago) as $pago)
        <tr>
        <td>{{ $pago->metodo }}</td>
        <td>{{ $pago->metodo == 'Divisa' ? number_format(0, 2) : number_format($pago->monto, 2) }}</td>
        <td>{{ $pago->metodo != 'Divisa' ? number_format(0, 2) : number_format($pago->monto, 2) }}</td>
        </tr>
      @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>
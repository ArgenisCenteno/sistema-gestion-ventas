<div class="card">
  <div class="card-body">
    <form>
      <div class="container">
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="proveedor" class="form-label">Proveedor</label>
            <input type="text" class="form-control" id="proveedor" value="{{ $compra->proveedor->razon_social}}" readonly>
          </div>
          <div class="col-md-6">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" value="Calle Nueva Sector Centro, Punta de Mata" readonly>
          </div>
        </div>

        <div class="row mb-3">
          
          <div class="col-md-6">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="text" class="form-control" id="fecha" value="{{ $compra->created_at->format('Y-m-d') }}" readonly>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="id_compra" class="form-label">ID de Compra</label>
            <input type="text" class="form-control" id="id_compra" value="{{ str_pad($compra->id, 4, '0', STR_PAD_LEFT) }}" readonly>
          </div>
          <div class="col-md-6">
            <label for="estado_compra" class="form-label">Estado</label>
            <input type="text" class="form-control" id="estado_compra" value="{{ $compra->status }}" readonly>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="subtotal" class="form-label">Subtotal</label>
            <input type="text" class="form-control" id="subtotal" value="{{ number_format($compra->pago->monto_neto, 2) }}" readonly>
          </div>
          <div class="col-md-6">
            <label for="iva" class="form-label">IVA (16%)</label>
            <input type="text" class="form-control" id="iva" value="{{ number_format($compra->pago->impuestos, 2) }}" readonly>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="total" class="form-label">Monto Total</label>
            <input type="text" class="form-control" id="total" value="{{ number_format($compra->pago->monto_total, 2) }}" readonly>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<form action="{{ route('ventas.generarVenta') }}" id="venta-form" method="POST">
    @csrf <!-- Agrega el token CSRF para seguridad -->
    <section>



        <div class="row">

            <div class="col-md-12"
                 >
                <div class="d-flex align-items-center mb-4">
                    
                    <h4 class="fw-bold mb-0">SELECCIONAR CLIENTE</h4>
                </div>
                <select name="user_id" id="user_id"
                    class="form-control select2 mb-2 mt-2 text-white bg-dark border-light" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 mt-3"
                >
                <div class="d-flex align-items-center mb-4">
                  
                    <h4 class="fw-bold mb-0">AGREGAR METODO DE PAGO</h4>
                </div>

                <div class="mb-3">
                    <label for="efectivo" class="form-label"><strong>Efectivo</strong></label>
                    <input type="number" step="any" value="0" class="form-control "
                        min="0" placeholder="Efectivo" name="Efectivo" id="efectivo" oninput="validarValor(this)"
                        onblur="establecerCeroSiVacio(this)">
                </div>

                <div class="mb-3">
                    <label for="punto" class="form-label"><strong>Punto de Venta</strong></label>
                    <input type="number" step="any" value="0" class="form-control "
                        min="0" placeholder="Punto" name="Punto-de-Venta" id="punto" oninput="validarValor(this)"
                        onblur="establecerCeroSiVacio(this)">
                </div>

                <div class="mb-3">
                    <label for="transferencia" class="form-label"><strong>Transferencia</strong></label>
                    <input type="number" step="any" value="0" class="form-control "
                        min="0" placeholder="Transferencia" name="Transferencia" id="transferencia"
                        oninput="validarValor(this)" onblur="establecerCeroSiVacio(this)">
                </div>

                <div class="mb-3">
                    <label for="pago-movil" class="form-label"><strong>Pago Móvil</strong></label>
                    <input type="number" step="any" value="0" class="form-control "
                        min="0" placeholder="Pago móvil" name="Pago-Movil" id="pago-movil" oninput="validarValor(this)"
                        onblur="establecerCeroSiVacio(this)">
                </div>

                <div class="mb-3">
                    <label for="divisa" class="form-label"><strong>Dólar</strong></label>
                    <input type="number" step="any" value="0" class="form-control "
                        min="0" placeholder="Divisa" name="Divisa" id="divisa" oninput="validarValor(this)"
                        onblur="establecerCeroSiVacio(this)">
                </div>

                <!-- Hidden Fields -->
                <input type="hidden" readonly step="any" class="form-control" placeholder="Divisa" name="dollar"
                    value="{{ $dollar }}" id="dollar-tasa">
                <input type="hidden" readonly step="any" class="form-control" name="pagado" value="0" id="pagado">
                <input type="hidden" readonly step="any" class="form-control" name="pagado" value="0"
                    id="totalBolivares">
                <div id="productos-hidden-fields"></div> <!-- Hidden fields for products -->
            </div>

        </div>
        <hr />

        <button type="submit" id="submitBtn" class="btn btn-primary" style="width: 100%" disabled>Generar</button>
        </div>

    </section>

</form>


<script>
    function validarValor(input) {
        if (parseFloat(input.value) < 0) {
            input.value = 0;
        }
    }

    function establecerCeroSiVacio(input) {
        if (input.value.trim() === '') {
            input.value = 0;
        }
    }
</script>
<div class="modal fade" id="modalTasa" tabindex="-1" aria-labelledby="modalTasaLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="{{ route('tasas.store') }}" method="POST">
                @csrf

                <div class="modal-header bg-super-dark">
                    <h5 class="modal-title" id="modalTasaLabel">Registrar Dollar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">Nombre:</label>
                        <input type="text" class="form-control round" id="nombre" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="valor" class="form-label fw-bold">Valor:</label>
                        <input type="number" class="form-control round" id="valor" name="valor" step="0.01" required>
                        <p id="valor_error" class="text-danger" style="display: none;">El valor no puede quedar vacío, en cero o ser negativo.</p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary round" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary round" id="submit_btn" disabled>Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="{{ asset('js/sweetalert2.js') }}"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            let valor = document.getElementById('valor');
            let valorError = document.getElementById('valor_error');
            let submitBtn = document.getElementById('submit_btn');

            // Función para validar el campo de valor
            function validarValor() {
                let valorInput = parseFloat(valor.value);
                let valid = true;

                // Validación del valor
                if (isNaN(valorInput) || valorInput <= 0) {
                    valorError.style.display = 'block';
                    valid = false;
                } else {
                    valorError.style.display = 'none';
                }

                // Habilitar o deshabilitar el botón de enviar
                submitBtn.disabled = !valid;
            }

            // Evento para validar el valor en tiempo real
            valor.addEventListener('input', validarValor);
        });
    </script>
 
<div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="modalProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('registrar-producto') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-super-dark">
                    <h5 class="modal-title" id="modalProductoLabel">Registrar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="nombre" class="font-weight-bold">Nombre:</label>
                        <input type="text" name="nombre" class="form-control round" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="cantidad" class="font-weight-bold">Cantidad:</label>
                        <input type="number" name="cantidad" class="form-control round" step="1" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="descripcion" class="font-weight-bold">Descripción:</label>
                        <textarea name="descripcion" class="form-control round" rows="3" required></textarea>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="sub_categoria_id" class="font-weight-bold">Subcategoría:</label>
                        <select name="sub_categoria_id" class="form-control round" required>
                            <option value="">Selecciona una subcategoría</option>
                             @foreach($subcategorias as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="precio_venta" class="font-weight-bold">Precio Venta:</label>
                        <input type="number" name="precio_venta" class="form-control round" step="0.01" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="precio_compra" class="font-weight-bold">Precio Compra:</label>
                        <input type="number" name="precio_compra" class="form-control round" step="0.01" required>
                    </div>

                    <div class="form-group col-12 col-md-6 mb-3">
                        <label for="imagenes" class="font-weight-bold">Imágenes:</label>
                        <input type="file" name="imagenes[]" class="form-control rounded" accept="image/*" multiple>
                        <p id="imagenes_error" class="text-danger d-none">Puedes subir hasta 5 imágenes.</p>
                    </div>

                    <div class="form-group col-12 mb-3" id="imagenes-preview"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary round" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary round">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

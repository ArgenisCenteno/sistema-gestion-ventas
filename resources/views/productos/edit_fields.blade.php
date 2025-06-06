<div class="modal fade" id="modalEditProducto" tabindex="-1" aria-labelledby="modalEditProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="formEditarProducto" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header bg-super-dark">
                    <h5 class="modal-title" id="modalEditProductoLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="nombre" class="font-weight-bold">Nombre:</label>
                        <input type="text" name="nombre" class="form-control round" id="edit_nombre" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="cantidad" class="font-weight-bold">Cantidad:</label>
                        <input type="number" name="cantidad" class="form-control round" id="edit_cantidad" step="1" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="descripcion" class="font-weight-bold">Descripción:</label>
                        <textarea name="descripcion" class="form-control round" id="edit_descripcion" rows="3" required></textarea>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="sub_categoria_id" class="font-weight-bold">Subcategoría:</label>
                        <select name="sub_categoria_id" class="form-control round" id="edit_sub_categoria_id" required>
                            <option value="">Selecciona una subcategoría</option>
                            @foreach($subcategorias as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="precio_venta" class="font-weight-bold">Precio Venta:</label>
                        <input type="number" name="precio_venta" class="form-control round" id="edit_precio_venta" step="0.01" required>
                    </div>

                    <div class="form-group col-sm-12 col-md-6">
                        <label for="precio_compra" class="font-weight-bold">Precio Compra:</label>
                        <input type="number" name="precio_compra" class="form-control round" id="edit_precio_compra" step="0.01" required>
                    </div>

                    <div class="form-group col-12 col-md-6 mb-3">
                        <label for="imagenes" class="font-weight-bold">Imágenes nuevas:</label>
                        <input type="file" name="imagenes[]" class="form-control rounded" accept="image/*" multiple>
                        <p id="imagenes_error" class="text-danger d-none">Puedes subir hasta 5 imágenes.</p>
                    </div>

                    <div class="form-group col-12 mb-3" id="imagenes-preview"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary round" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary round">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
 

<script src="{{asset('js/sweetalert2.js')}}"></script>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        let imagenesInput = document.getElementById('imagenes');
        let previewContainer = document.getElementById('imagenes-preview');
        let imagenesError = document.getElementById('imagenes_error');

        // Función para manejar la previsualización y eliminación de imágenes
        imagenesInput.addEventListener('change', function (event) {
            let files = event.target.files;
    let maxFiles = 5; // Máximo de archivos permitidos

    // Limpiar la previsualización actual
    previewContainer.innerHTML = '';

    // Validar cantidad de archivos seleccionados
    if (files.length > maxFiles) {
        imagenesError.style.display = 'block';
        imagenesInput.value = ''; // Limpiar la selección de archivos
        return;
    } else {
        imagenesError.style.display = 'none';
    }

    // Mostrar previsualización de cada imagen seleccionada
    Array.from(files).forEach((file) => {
        let reader = new FileReader();
        reader.onload = function (e) {
            let imgContainer = document.createElement('div');
            imgContainer.style.position = 'relative';
            imgContainer.style.display = 'inline-block';
            imgContainer.style.margin = '5px';

            let img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '300px';
            img.style.height = '300px';
            img.style.objectFit = 'cover';

            let removeBtn = document.createElement('button');
            removeBtn.innerText = 'X';
            removeBtn.style.position = 'absolute';
            removeBtn.style.top = '0';
            removeBtn.style.right = '0';
            removeBtn.style.backgroundColor = 'black';
            removeBtn.style.color = 'white';
            removeBtn.style.border = 'none';
            removeBtn.style.borderRadius = '50%';
            removeBtn.style.width = '50px';
            removeBtn.style.height = '50px';
            removeBtn.style.cursor = 'pointer';


            removeBtn.addEventListener('click', function () {
                imgContainer.remove();
                let dt = new DataTransfer();
                for (let i = 0; i < files.length; i++) {
                    if (files[i] !== file) {
                        dt.items.add(files[i]);
                    }
                }
                imagenesInput.files = dt.files;
            });

            imgContainer.appendChild(img);
            imgContainer.appendChild(removeBtn);
            previewContainer.appendChild(imgContainer);
        }
        reader.readAsDataURL(file);
    });
});
    });
</script>

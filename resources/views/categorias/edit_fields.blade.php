<div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategoriaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarCategoria" method="POST">
        @csrf
        @method('PATCH')

        <div class="modal-header bg-super-dark">
          <h5 class="modal-title">Editar Categoría</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" id="categoria_id">

          <div class="mb-3">
            <label for="edit_nombre" class="form-label fw-bold">Nombre</label>
            <input type="text" class="form-control round" id="edit_nombre" name="nombre">
          </div>

          <div class="mb-3">
            <label for="edit_status" class="form-label fw-bold">Estado</label>
            <select class="form-control round" id="edit_status" name="status">
              <option value="1">Activo</option>
              <option value="0">Inactivo</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

      </form>
    </div>
  </div>
</div>

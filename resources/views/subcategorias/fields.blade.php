<!-- Modal Registrar Subcategoría -->
<div class="modal fade" id="modalRegistrarSubcategoria" tabindex="-1" aria-labelledby="modalRegistrarSubcategoriaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-super-dark">
        <h5 class="modal-title" id="modalRegistrarSubcategoriaLabel">Registrar Subcategoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        {!! Form::open(['route' => 'subcategorias.store', 'id' => 'formRegistrarSubcategoria']) !!}
        <div class="row">
          <div class="form-group col-sm-12 col-md-6">
              {!! Form::label('nombre', 'Nombre:', ['class' => 'bold']) !!}
              {!! Form::text('nombre', null, ['class' => 'form-control round', 'required']) !!}
          </div>
          <div class="form-group col-sm-12 col-md-6">
              {!! Form::label('categoria_id', 'Categoría:', ['class' => 'bold']) !!}
              {!! Form::select('categoria_id', $categorias, null, ['class' => 'form-control round', 'placeholder' => 'Selecciona una categoría', 'required']) !!}
          </div>
          <div class="form-group col-sm-12 col-md-6 mt-3">
              {!! Form::label('status', 'Estatus:', ['class' => 'bold']) !!}
              {!! Form::select('status', ['1' => 'Activo', '0' => 'Inactivo'], null, ['class' => 'form-control round']) !!}
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary round']) !!}
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

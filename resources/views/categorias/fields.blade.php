<div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="modalCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-super-dark">
                <h5 class="modal-title" id="modalCategoriaLabel">Registrar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'categorias.store']) !!}
                <div class="">
                    <!-- Name Field -->
                    <div class="">
                        {!! Form::label('nombre', 'Nombre:', ['class' => 'fw-bold']) !!}
                        {!! Form::text('nombre', null, ['class' => 'form-control round']) !!}
                    </div>
                    <div class="">
                        {!! Form::label('status', 'Estado:', ['class' => 'fw-bold']) !!}
                        {!! Form::select('status', [
    '1' => 'Activo',
    '0' => 'Inactivo',
], null, ['class' => 'form-control round']) !!}
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
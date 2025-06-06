<td>
    {!! Form::open(['route' => ['subcategorias.destroy', $id], 'method' => 'delete', 'class' => 'btn-delete']) !!}
    <div class='btn-group'>
        <a href="#" class="btn-editar-categoria" data-id="{{ $id }}" data-bs-toggle="modal"
            data-bs-target="#modalEditarSubcategoria" title="Editar">
            <span class="material-icons" style="color: green;">edit</span>
        </a>

        {!! Form::button('<span class="material-icons" style="color: red;">delete</span>', [
    'type' => 'submit',
    'style' => 'background: none; border: none; padding: 0;',
    'data-bs-toggle' => 'tooltip',
    'data-bs-placement' => 'top',
    'title' => 'Eliminar'
]) !!}
    </div>
    {!! Form::close() !!}
</td>
<!-- SweetAlert CDN -->
<script src="{{asset('js/sweetalert2.js')}}"></script>

<!-- ALERT DE CONFIRMACION DE ELIMINACION -->
<script>
    $(document).ready(function () {
        $('.btn-delete').submit(function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Está seguro?',
                text: "El registro se eliminará permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgba(13, 172, 85)',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí se envía el formulario si se confirma la eliminación
                    $(this).off('submit').submit();
                }
            });
        });
    });
</script>
<script>
    // Aseguramos que el DOM esté listo
    $(document).ready(function () {

        // Delegación del evento de click
        $(document).on('click', '.btn-editar-categoria', function (e) {
            e.preventDefault(); // Previene navegación
            const categoriaId = $(this).data('id');

            fetch(`/subcategorias/${categoriaId}`)
                .then(response => {
                    if (!response.ok) throw new Error("Categoría no encontrada");
                    return response.json();
                })
                .then(data => {
                    // Llenar campos
                    $('#categoria_id').val(data.id);
                    $('#edit_nombre').val(data.nombre);
                    $('#edit_status').val(data.status);
                    $('#edit_categoria').val(data.categoria_id);
                    // Actualizar acción del formulario
                    $('#formEditarSubcategoria').attr('action', `/subcategorias/${categoriaId}`);
                })
                .catch(error => {
                    console.error('Error al obtener la categoría:', error);
                    Swal.fire('Error', 'No se pudo cargar la información de la categoría.', 'error');
                });
        });
    });
</script>
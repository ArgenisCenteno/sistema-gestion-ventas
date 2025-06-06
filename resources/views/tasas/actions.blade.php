<td>
    {!! Form::open(['route' => ['tasas.destroy', $id], 'method' => 'delete', 'class' => 'btn-delete']) !!}
    <div class='btn-group'>
        <a href="#" class="btn-editar-tasa" data-id="{{ $id }}" data-bs-toggle="modal"
            data-bs-target="#modalEditTasa" title="Editar">
            <span class="material-icons" style="color: green;">edit</span>
        </a>
            @if(Auth::user()->hasRole('superAdmin'))

        {!! Form::button('<span class="material-icons">delete</span>', ['type' => 'submit', 'class' =>
        'btn btn-danger', 'data-bs-toggle' => 'tooltip', 'data-bs-placement' => 'top', 'title' => 'Eliminar']) !!}
   @endif
</div>
    {!! Form::close() !!}
</td>
<!-- SweetAlert CDN -->
<script src="{{asset('js/sweetalert2.js')}}"></script>

<!-- ALERT DE CONFIRMACION DE ELIMINACION -->
<script>
    $(document).ready(function() {
        $('.btn-delete').submit(function(e) {
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
        $(document).on('click', '.btn-editar-tasa', function (e) {
            e.preventDefault(); // Previene navegación
            const categoriaId = $(this).data('id');

            fetch(`/tasas/${categoriaId}`)
                .then(response => {
                    if (!response.ok) throw new Error("Categoría no encontrada");
                    return response.json();
                })
                .then(data => {
                    // Llenar campos
                    $('#tasa_id').val(data.id);
                    $('#edit_nombre').val(data.name);
                    $('#edit_valor').val(data.valor); 
                    // Actualizar acción del formulario
                    $('#formEditarTasa').attr('action', `/tasas/${categoriaId}`);
                })
                .catch(error => {
                    console.error('Error al obtener la categoría:', error);
                    Swal.fire('Error', 'No se pudo cargar la información de la categoría.', 'error');
                });
        });
    });
</script>
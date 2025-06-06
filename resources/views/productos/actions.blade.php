<td>
    {!! Form::open(['route' => ['productos.destroy', $id], 'method' => 'delete', 'class' => 'btn-delete']) !!}
    <div class='btn-group'>
       <a href="#" class="btn-editar-producto" data-id="{{ $id }}" data-bs-toggle="modal"
   data-bs-target="#modalEditProducto" title="Editar">
   <span class="material-icons" style="color: green;">edit</span>
</a>

           
            @if(Auth::user()->hasRole('superAdmin'))
         {!! Form::button('<span class="material-icons" style="color: red;">delete</span>', [
    'type' => 'submit',
    'style' => 'background: none; border: none; padding: 0;',
    'data-bs-toggle' => 'tooltip',
    'data-bs-placement' => 'top',
    'title' => 'Eliminar'
]) !!}
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
    $(document).ready(function () {
        $(document).on('click', '.btn-editar-producto', function (e) {
            e.preventDefault();
            const id = $(this).data('id');

            fetch(`/producto/${id}`)
                .then(res => {
                    if (!res.ok) throw new Error("Producto no encontrado");
                    return res.json();
                })
                .then(data => {
                    console.log(data)
                    $('#formEditarProducto').attr('action', `/productos/${id}`);

                    $('#edit_nombre').val(data.nombre);
                    $('#edit_cantidad').val(data.cantidad);
                    $('#edit_descripcion').val(data.descripcion);
                    $('#edit_sub_categoria_id').val(data.sub_categoria_id);
                    $('#edit_precio_venta').val(data.precio_venta);
                    $('#edit_precio_compra').val(data.precio_compra);

                    // NOTA: imágenes no se pueden editar desde inputs por seguridad
                    $('#imagenes-preview').html('');
                })
                .catch(error => {
                    console.error('Error al cargar producto:', error);
                    Swal.fire('Error', 'No se pudo cargar el producto.', 'error');
                });
        });
    });
</script>

<table class="table" id="apertura-caja-table">
        <thead>
            <tr>
                <th>Caja</th>
                <th>Usuario</th>
                
                <th>Estatus</th>
                <th>Fecha de Apertura</th>
                <th>Fecha de Cierre</th>
                <th>Opciones</th> <!-- Nueva columna para las acciones -->
            </tr>
        </thead>
    </table>

@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
 
    <script type="text/javascript">
        $(document).ready(function() {
            $('#apertura-caja-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('aperturas.index') }}',  // Asegúrate de tener la ruta correcta
                columns: [
                    { data: 'caja', name: 'caja' },
                    { data: 'usuario', name: 'usuario' },
                   
                    { data: 'estatus', name: 'estatus' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'actions', name: 'actions' }
                ]
            });
        });
    </script>
    
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
@endsection
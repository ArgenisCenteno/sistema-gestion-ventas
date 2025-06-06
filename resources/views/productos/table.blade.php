 
<form id="taxesForm" action="{{ route('eliminarMultiplesProductos') }}" method="POST">
    @csrf
   <div class="d-flex justify-content-start mb-3">
    <button id="submitBtn" style="display: none;" class="btn btn-danger round">
        <i class="material-icons align-middle">delete</i> Eliminar
    </button>
</div>


    <div class="table-responsive">
        <table class="table table-hover" id="productos-table">
            <thead class="bg-light">
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>P. de Venta </th>
                    <th>P. de Compra </th>

                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Subcategoría</th>
                    <th>Creado en</th>
                    <th>Actualizado en</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</form>

@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        let table = $('#productos-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('almacen') }}",
                type: "GET",
                data: function (d) {
                    d.subCategoria = $('#filter-subcategoria').val(); // Enviar el filtro de subcategoría
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                {
                    data: 'disponible', // Utilizar el campo 'status' para obtener el estado y decidir si mostrar el checkbox
                    render: function (data, type, full, meta) {

                        return `<input type="checkbox" class="taxes-checkbox" style="transform: scale(1.5); margin-right: 5px; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); border: 2px solid #d1d1d1;" name="selected_taxes[]" value="${full.id}">`;

                    },
                    orderable: false,
                    searchable: false
                },
                { data: 'id', name: 'id' },
                { data: 'imagen', name: 'imagen' },
                { data: 'nombre', name: 'nombre' },
                { data: 'descripcion', name: 'descripcion' },
                { data: 'precio_venta', name: 'precio_venta' },
                { data: 'precio_compra', name: 'precio_compra' },

                { data: 'cantidad', name: 'cantidad' },
                { data: 'subCategoria', name: 'subCategoria' },
                { data: 'categoria', name: 'categoria' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'actions', name: 'actions', searchable: true, orderable: true }
            ],
            order: [[0, 'desc']],
            language: {
                lengthMenu: "Mostrar _MENU_ Registros por Página",
                zeroRecords: "Sin resultados",
                info: "Mostrando página _PAGE_ de _PAGES_",
                infoEmpty: "No hay Registros Disponibles",
                infoFiltered: "Filtrado de _TOTAL_ de _MAX_ Registros Totales",
                search: "Buscar",
                paginate: {
                    next: ">",
                    previous: "<"
                }
            }
        });

        $('#filter-subcategoria').on('change', function () {
            table.ajax.reload(); // Recargar la tabla con el nuevo filtro
        });
    });
</script>

<script type="text/javascript">
    $(document).on('change', '.taxes-checkbox', function () {
        toggleSubmitButton();
    });

    function toggleSubmitButton() {
        // Verifica si al menos un checkbox está seleccionado
        if ($('.taxes-checkbox:checked').length > 0) {
            $('#submitBtn').show();
        } else {
            $('#submitBtn').hide();
        }
    }
</script>
@endsection
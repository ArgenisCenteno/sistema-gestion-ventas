<div class="table-responsive">
    <table class="table table-hover" id="productos-table">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Creado en</th>
                <th>Actualizado en</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {

        $('#productos-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('usuarios.clientes') }}",
            dataType: 'json',
            type: "POST",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'dni', name: 'dni' },
               
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                 { data: 'actions', name: 'actions', searchable: false, orderable: false } // Make sure to set orderable and searchable to false
            ],
            order: [[0, 'desc']],
            "language": {
                "lengthMenu": "Mostrar _MENU_ Registros por Página",
                "zeroRecords": "Sin resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay Registros Disponibles",
                "infoFiltered": "Filtrado de _TOTAL_ de _MAX_ Registros Totales",
                "search": "Buscar",
                "paginate": {
                    "next": ">",
                    "previous": "<"
                }
            }
        });

    });
</script>


@endsection
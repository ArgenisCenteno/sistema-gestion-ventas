<!-- Modal -->


<button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#productosModal">
    Ver Precios
</button>
<div class="col-md-12 mt-3"
                style="background-color: rgb(8, 21, 33); color: white; padding: 20px; border-radius: 10px;">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{asset('iconos/logo-final.png')}}" alt="Logo" style="height: 50px; margin-right: 15px;">
                    <h4 class="fw-bold mb-0">Detalles del Mantenimiento</h4>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label"><strong>Descripción</strong></label>
                    <textarea class="form-control text-white bg-dark border-light" name="descripcion" id="descripcion"
                        rows="3" placeholder="Escriba una descripción detallada"></textarea>
                </div>

                <div class="mb-3">
                    <label for="fecha_ingreso" class="form-label"><strong>Fecha de Ingreso</strong></label>
                    <input type="date" class="form-control text-white bg-dark border-light" name="fecha_ingreso"
                        id="fecha_ingreso">
                </div>

                <div class="mb-3">
                    <label for="fecha_estimada_entrega" class="form-label"><strong>Fecha Estimada de
                            Entrega</strong></label>
                    <input type="date" class="form-control text-white bg-dark border-light"
                        name="fecha_estimada_entrega" id="fecha_estimada_entrega">
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label"><strong>Estado</strong></label>
                    <select class="form-control text-white bg-dark border-light" name="estado" id="estado">
                        <option value="Pendiente">Pendiente</option>
                        <option value="En Proceso">En Proceso</option>
                        <option value="Completado">Completado</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>
            </div>

<div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(8, 21, 33) !important; color: white !important;">
                <!-- Logo en el encabezado -->
                <img src="{{ asset('iconos/logo-final.png') }}" alt="SIAV" style="height: 40px; margin-right: 10px;">
                <h5 class="modal-title fw-bold" id="productosModalLabel">Lista de Servicios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="productos-table2">
                        <thead class="bg-light">
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>

                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Categoría</th>
                                <th>Subcategoría</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos de la tabla se cargarán dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<h4 class="mt-4 mb-4 p-3">SERVICIOS</h4>
<div class="table-responsive">
    <table class="table table-hover" id="productos-ventas">
        <thead class="bg-light">
            <tr>

                <th>Nombre</th>
                <th>Precio</th>


                <th>Cantidad</th>
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
<script src="{{asset('js/sweetalert2.js')}}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        let productosEnCarrito = [];


        $('#productos-table2').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('mantenimientos.datatableProductoVenta') }}",
            dataType: 'json',
            type: "POST",
            columns: [
                { data: 'imagen', name: 'imagen' },
                { data: 'nombre', name: 'nombre' },

                { data: 'precio_venta', name: 'precio_venta' },

                { data: 'cantidad', name: 'cantidad' },
                { data: 'categoria', name: 'categoria' },
                { data: 'subCategoria', name: 'subCategoria' },
                {
                    data: 'id',
                    name: 'actions',
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {

                        return `<button type="button" class="btn btn-success" onClick="modificarTabla('${data}')"><span >Agregar</span></button>`;
                    }
                }
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

    })
</script>


<script>
    var productos = [];
    var totalDolar = 0;
    var totalBS = 0;

    var tasaCambio = document.getElementById("dollar-tasa").value;
    function modificarTabla(id) {
        const url = `{{ route('productos.obtener', ':id') }}`.replace(':id', id); // Reemplaza :id con el valor de ID dinámico

        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al consultar el producto.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log(data.producto.sub_categoria.nombre)
                    agregarProducto(
                        data.producto.nombre,
                        data.producto.precio_venta,
                        data.producto.cantidad,
                        data.producto.sub_categoria.nombre

                    );
                } else {
                    console.error(data);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Función para agregar un producto al carrito
    function agregarProducto(nombre, precio, iva, stock, subcategoria) {
        const productoExistente = productos.find((p) => p.nombre === nombre);
        if (productoExistente) {
            if (productoExistente.cantidad < stock) {
                productoExistente.cantidad++;
                productoExistente.subtotal = calcularSubtotal(productoExistente);
            } else {
                Swal.fire({
                    title: 'Stock Excedido',
                    text: `La cantidad solicitada excede el stock disponible.`,
                    icon: 'info',
                    confirmButtonColor: '#3085d6'
                });
            }
        } else {
            const nuevoProducto = {
                nombre: nombre,
                precio: parseFloat(precio),
                iva: parseFloat(iva),
                stock: parseInt(stock),
                subcategoria: subcategoria,
                cantidad: 1,
                subtotal: calcularSubtotal({ precio, iva, cantidad: 1 }),
            };
            productos.push(nuevoProducto);
        }
        actualizarTabla();
        pagado();
    }

    // Función para calcular el subtotal de un producto con IVA
    function calcularSubtotal(producto) {
        if (!producto.iva) {
            return producto.precio * producto.cantidad;
        } else {
            return producto.precio  * producto.cantidad;
        }

    }

    // Función para aumentar la cantidad de un producto en el carrito
    function aumentarCantidad(nombre, inputElement) {
        const nuevaCantidad = parseFloat(inputElement.value); // Captura el valor ingresado
        const producto = productos.find((p) => p.nombre === nombre);

        if (producto) {
            // Si la cantidad es mayor al stock, ajustarla al máximo disponible
            if (nuevaCantidad > producto.stock) {
                inputElement.value = producto.stock; // Ajusta el valor del input al máximo disponible
                producto.cantidad = producto.stock; // Establece la cantidad en el stock disponible
                Swal.fire({
                    title: 'Stock Excedido',
                    text: `La cantidad solicitada excede el stock disponible. Se ajustó a ${producto.stock}.`,
                    icon: 'info',
                    confirmButtonColor: '#3085d6'
                });
            } else {
                producto.cantidad = nuevaCantidad; // Si la cantidad es válida, la asigna
            }

            // Calcular el subtotal con la nueva cantidad
            producto.subtotal = calcularSubtotal(producto);

            // Actualizar el pago y la tabla

            actualizarTabla();
        } else {
            Swal.fire({
                title: 'Producto no encontrado',
                text: 'No se ha encontrado el producto en el carrito.',
                icon: 'error',
                confirmButtonColor: '#3085d6'
            });
        }

        pagado();
    }



    // Función para eliminar un producto del carrito
    function eliminarProducto(nombre) {
        productos = productos.filter((p) => p.nombre !== nombre);
        actualizarTabla();
        pagado();
    }

    // Función para actualizar la tabla del carrito y calcular totales
    function actualizarTabla() {
        const tbody = document.querySelector('#productos-ventas tbody');

        tbody.innerHTML = '';

        totalDolar = 0;
        totalBS = 0;

        productos.forEach((producto) => {
            totalDolar += producto.subtotal;
            totalBS += producto.subtotal * tasaCambio;

            const fila = document.createElement('tr');
            fila.innerHTML = `
        <td>${producto.nombre}</td>
        <td>$${producto.precio.toFixed(2)}</td>
        
        <td>
            <input type="number" class="form-control" step="any" value="${producto.cantidad}" 
                onChange="aumentarCantidad('${producto.nombre}', this)">
        </td>
        <td>
            <button class="btn btn-danger m-2 text-white" onclick="eliminarProducto('${producto.nombre}')">
                <span>Quitar</span>
            </button>
        </td>
    `;
            tbody.appendChild(fila);
        });


        // Actualizar los totales
        document.getElementById('total-dolar').innerText = `${totalDolar.toFixed(2)}`;
        document.getElementById('total-bs').innerText = `${totalBS.toFixed(2)}`;
        document.getElementById('totalBolivares').value = `${totalBS.toFixed(2)}`;
    }


    function pagado() {
        // Obtener los valores de los métodos de pago
        var efectivo = parseFloat(document.querySelector('input[name="Efectivo"]').value) || 0;
        var punto = parseFloat(document.querySelector('input[name="Punto-de-Venta"]').value) || 0;
        var transferencia = parseFloat(document.querySelector('input[name="Transferencia"]').value) || 0;
        var pagoMovil = parseFloat(document.querySelector('input[name="Pago-Movil"]').value) || 0;
        var divisa = parseFloat(document.querySelector('input[name="Divisa"]').value) || 0;
        var totalBS = parseFloat(document.getElementById("totalBolivares").value);
        // Obtener la tasa de cambio (en dólares)
        var tasaDollar = document.getElementById("dollar-tasa").value;


        var totalDolar = divisa;
        var totalDolar2 = divisa * tasaDollar;


        var totalBs = efectivo + punto + transferencia + pagoMovil + totalDolar2

        var restante = totalBS.toFixed(2) - totalBs.toFixed(2);

        var restanteDollar = (totalBS.toFixed(2) - totalBs.toFixed(2)) / tasaDollar;

        // Habilitar o deshabilitar el botón de "Generar Venta"
        if (totalBS.toFixed(2) == totalBs.toFixed(2) && totalBS > 0) {
            document.getElementById('submitBtn').disabled = false;
        } else {
            document.getElementById('submitBtn').disabled = true;
        }
        document.getElementById('restante').innerText = `${restante.toFixed(2)}`;
        document.getElementById('restante-dollar').innerText = `${restanteDollar.toFixed(2)}`;
        // Asignar la función de actualización a los inputs
        document.querySelectorAll('input[name="Efectivo"], input[name="Punto-de-Venta"], input[name="Transferencia"], input[name="Pago-Movil"], input[name="Divisa"]').forEach(input => {
            input.addEventListener('input', pagado);
        });

    }
    pagado();

</script>

<script>
    function enviarProductosFormulario() {
        const productosHiddenFieldsContainer = document.getElementById('productos-hidden-fields');
        productosHiddenFieldsContainer.innerHTML = ''; // Clear previous hidden fields

        productos.forEach(producto => {
            const hiddenFields = `
            <input type="hidden" name="productos[${producto.nombre}][nombre]" value="${producto.nombre}">
            <input type="hidden" name="productos[${producto.nombre}][precio]" value="${producto.precio}">
            <input type="hidden" name="productos[${producto.nombre}][cantidad]" value="${producto.cantidad}">
            <input type="hidden" name="productos[${producto.nombre}][subtotal]" value="${producto.subtotal}">
        `;
            productosHiddenFieldsContainer.innerHTML += hiddenFields;
        });
    }
    document.getElementById('venta-form').addEventListener('submit', function (event) {
        enviarProductosFormulario(); // Populate the hidden fields with product data
    });


</script>

@endsection
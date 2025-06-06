<!-- Mostrar datos de la apertura y caja -->
<div class="row mb-4">
  

<!-- Totales Generales -->
<div class="row mb-4">
    <!-- Total en Bolívares -->
    <div class="col-lg-6 col-12">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ number_format($montoBs, 2) }}</h3>
                <p>Total en Bolívares</p>
            </div>
            <i class="small-box-icon fas fa-chart-line"></i>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
    
    <!-- Total en Dólares -->
    <div class="col-lg-6 col-12">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($montoDolar, 2) }}</h3>
                <p>Total en Dólares</p>
            </div>
            <i class="small-box-icon fas fa-chart-line"></i>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
</div>

<!-- Totales por Método de Pago -->
<div class="row mb-4">
    <!-- Total Transferencia -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ number_format($transaferencia, 2) }}</h3>
                <p>Total Transferencia</p>
            </div>
            <i class="small-box-icon fas fa-credit-card"></i>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
    
    <!-- Total Pago Móvil -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ number_format($pagoMovil, 2) }}</h3>
                <p>Total Pago Móvil</p>
            </div>
            <i class="small-box-icon fas fa-mobile-alt"></i>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
    
    <!-- Total Efectivo -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($efectivo, 2) }}</h3>
                <p>Total Efectivo</p>
            </div>
            <i class="small-box-icon fas fa-money-bill-wave"></i>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
</div>

<!-- Otros Totales -->
<div class="row mb-4">
    <!-- Total Dólares -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ number_format($divisa, 2) }}</h3>
                <p>Total Dólares</p>
            </div>
            <i class="small-box-icon fas fa-exchange-alt"></i>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
    
    <!-- Total Punto de Venta -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($punto, 2) }}</h3>
                <p>Total Punto de Venta</p>
            </div>
            <i class="small-box-icon fas fa-cash-register"></i>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
</div>

 

@if($apertura->estatus !== 'Finalizado')
<!-- Botón para cerrar caja -->
<form class="btn-apertura" action="{{ route('aperturas.update', $apertura->id) }}" method="POST">
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-success mt-3 w-100">Cerrar Caja</button>
</form>
@endif

@section('js') 
<script>
    $(document).ready(function() {
        $('#movimientosTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.3/i18n/es-ES.json'
            }
        });
    });
</script>
@endsection

<script>
    $(document).ready(function() {
        $('.btn-apertura').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Confirmar',
                text: "¿Esta seguro de que desea realizar esta acción?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: 'green',
                cancelButtonColor: 'red',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>

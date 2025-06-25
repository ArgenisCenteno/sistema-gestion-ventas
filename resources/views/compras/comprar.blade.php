@extends('layout.app')
@section('content')
    <main class="app-main"> <!--begin::App Content Header-->
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card border-0 my-5">
                            <div class="px-2 row">
                                <div class="col-lg-12">
                                    @include('flash::message')
                                </div>
                                <div class="col-md-6 col-6">
                                    <h3 class="p-2 bold">Generar Compra</h3>
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="row g-3">
                                        <!-- MONTO TOTAL ($) -->
                                        <div class="col-lg-3 col-6">
                                            <div class="small-box bg-success shadow rounded-4">
                                                <div class="inner">
                                                    <h3 id="total-dolar" class="fs-1 fw-bold">0</h3>
                                                    <p class="fs-6">MONTO TOTAL ($)</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                                </div>
                                                <a href="#"
                                                    class="small-box-footer text-white text-decoration-none fw-semibold">
                                                    Ver más <i class="bi bi-link-45deg"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- MONTO TOTAL (BS) -->
                                        <div class="col-lg-3 col-6">
                                            <div class="small-box bg-warning shadow rounded-4">
                                                <div class="inner">
                                                    <h3 id="total-bs" class="fs-1 fw-bold">0</h3>
                                                    <p class="fs-6">MONTO TOTAL (BS)</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-coins fa-2x"></i>
                                                </div>
                                                <a href="#"
                                                    class="small-box-footer text-white text-decoration-none fw-semibold">
                                                    Ver más <i class="bi bi-link-45deg"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- RESTANTE (BS) -->
                                        <div class="col-lg-3 col-6">
                                            <div class="small-box bg-danger shadow rounded-4">
                                                <div class="inner">
                                                    <h3 id="restante" class="fs-1 fw-bold">0</h3>
                                                    <p class="fs-6">Restante (BS)</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-ban fa-2x"></i>
                                                </div>
                                                <a href="#"
                                                    class="small-box-footer text-white text-decoration-none fw-semibold">
                                                    Ver más <i class="bi bi-link-45deg"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- RESTANTE ($) -->
                                        <div class="col-lg-3 col-6">
                                            <div class="small-box bg-dark shadow rounded-4">
                                                <div class="inner">
                                                    <h3 id="restante-dollar" class="fs-1 fw-bold text-white">0</h3>
                                                    <p class="fs-6 text-white">Restante ($)</p>
                                                </div>
                                                <div class="icon text-white">
                                                    <i class="fas fa-dollar fa-2x"></i>
                                                </div>
                                                <a href="#"
                                                    class="small-box-footer text-white text-decoration-none fw-semibold">
                                                    Ver más <i class="bi bi-link-45deg"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-6">
                                        @include('compras.datatableProductos')
                                    </div>
                                    <div class="col-6">

                                        @include('compras.fields_compra')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main> <!--end::App Main--> <!--begin::Footer-->
    <style>
    .small-box .icon {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 0;
        opacity: 0.4;
    }
    .small-box {
        position: relative;
        overflow: hidden;
        padding: 20px;
        min-height: 120px;
    }
    .small-box .inner {
        z-index: 1;
        position: relative;
    }
</style>

@endsection
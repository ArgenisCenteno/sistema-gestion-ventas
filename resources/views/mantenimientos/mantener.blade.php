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
                                <h3 class="p-2 bold">Registrar Servicio Técnico<i
                                        class="nav-icon fas fa-cash-register"></i></h3>
                            </div>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('mantenimientos.store') }}" id="venta-form" method="POST">

                                @csrf <!-- Agrega el token CSRF para seguridad -->
                                <div class="row">
                                    <div class="row">
                                        <div class="col-lg-3 col-6">
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3 id="total-dolar">0<sup class="fs-5"></sup></h3>
                                                    <p>MONTO TOTAL ($)</p>
                                                </div>
                                                <i class="small-box-icon fas fa-dollar-sign"></i>
                                                <!-- Actualiza el ícono -->
                                                <a href="#"
                                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                    Ver más <i class="bi bi-link-45deg"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-6">
                                            <div class="small-box bg-warning">
                                                <div class="inner">
                                                    <h3 id="total-bs">0<sup class="fs-5"></sup></h3>
                                                    <p>MONTO TOTAL (BS)</p>
                                                </div>
                                                <i class="small-box-icon fas fa-coins"></i> <!-- Actualiza el ícono -->
                                                <a href="#"
                                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                    Ver más <i class="bi bi-link-45deg"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-6">
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3 id="restante">0<sup class="fs-5"></sup></h3>
                                                    <p>Restante (BS)</p>
                                                </div>
                                                <i class="small-box-icon fas fa-ban"></i> <!-- Actualiza el ícono -->
                                                <a href="#"
                                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                    Ver más <i class="bi bi-link-45deg"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-6">
                                            <div class="small-box bg-dark">
                                                <div class="inner">
                                                    <h3 id="restante-dollar" class="text-white">0<sup
                                                            class="fs-5"></sup></h3>
                                                    <p class="text-white">Restante ($)</p>
                                                </div>
                                                <i class="small-box-icon fas fa-dollar"></i> <!-- Actualiza el ícono -->
                                                <a href="#"
                                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                                    Ver más <i class="bi bi-link-45deg"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-6">
                                        @include('mantenimientos.tableServicios') 
                                    </div>
                                    <div class="col-6">

                                        @include('mantenimientos.fields') 
                                    </div>
                                </div>
                                </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection
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
                                    <h3 class="p-2 bold">Ventas del sistema</h3>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <a href="{{ route('ventas.vender') }}" class="btn btn-primary round mx-1">
                                        <span class="material-icons align-middle">add</span> Nueva venta
                                    </a>

                                </div>

                            </div>

                            <div class="card-body">
                                <form action="{{ route('ventas.export') }}" method="GET" class="row g-3 align-items-end">
                                    @csrf

                                    <div class="col-md-4">
                                        <label for="start_date" class="form-label">Desde</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="end_date" class="form-label">Hasta</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                                    </div>

                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" name="type" value="EXCEL" class="btn btn-success w-100"
                                            title="Exportar a Excel">
                                            <i class="fas fa-file-excel me-1"></i> Excel
                                        </button>
                                    </div>
                                </form>

                                @include('ventas.table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main> <!--end::App Main--> <!--begin::Footer-->
@endsection
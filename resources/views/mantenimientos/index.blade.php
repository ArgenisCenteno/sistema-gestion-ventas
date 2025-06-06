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
                                <h3 class="p-2 bold">Servicios   <i class="nav-icon fas fa-store"></i></h3>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <form action="{{ route('mantenimientos.export') }}" method="GET" class="d-flex align-items-end">
                                    @csrf
                                    <div class="me-2">
                                        <label for="start_date" class="form-label mb-0">Fecha Inicio</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            required>
                                    </div>
                                    <div class="me-2">
                                        <label for="end_date" class="form-label mb-0">Fecha Fin</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                                    </div>
                                    <input type="hidden" name="type" value="EXCEL">
                                    <button type="submit" class="btn btn-primary">Exportar</button>
                                </form>
                            </div>

                        </div>
                        <div class="card-body">

                            @include('mantenimientos.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection
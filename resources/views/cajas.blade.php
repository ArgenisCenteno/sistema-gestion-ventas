<div class="row"> <!--begin::Col-->
    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$ventas}}</h3>
                <p>Ventas</p>
            </div>
            <i class="small-box-icon fas fa-shopping-cart"></i> <!-- Updated icon -->
            <a href="{{route('ventas.index')}}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div> <!--end::Small Box Widget 1-->
    </div> <!--end::Col-->

    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 2-->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$compras}}<sup class="fs-5"></sup></h3>
                <p>Valor Neto de Inventario</p>
            </div>
            <i class="small-box-icon fas fa-boxes"></i> <!-- Updated icon -->
            <a href="{{route('almacen')}}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div> <!--end::Small Box Widget 2-->
    </div> <!--end::Col-->

    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 3-->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{$dolar}}</h3>
                <p>Tasa del Dollar</p>
            </div>
            <i class="small-box-icon fas fa-dollar-sign"></i> <!-- Updated icon -->
            <a href="{{route('usuarios.index')}}"
                class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div> <!--end::Small Box Widget 3-->
    </div> <!--end::Col-->

    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{$productos}}</h3>
                <p>Productos</p>
            </div>
            <i class="small-box-icon fas fa-cogs"></i> <!-- Updated icon -->
            <a href="{{route('almacen')}}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div> <!--end::Small Box Widget 4-->
    </div> <!--end::Col-->
</div> <!--end::Row-->
<div class="row"> <!--begin::Col-->

    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 2-->
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>{{$compras}}<sup class="fs-5"></sup></h3>
                <p>Compras</p>
            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path
                    d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                </path>
            </svg> <a href="{{route('compras.index')}}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i> </a>
        </div> <!--end::Small Box Widget 2-->
    </div> <!--end::Col-->
    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 3-->
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3>{{$usuarios}}</h3>
                <p>Usuarios Registrados</p>
            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path
                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                </path>
            </svg> <a href="{{route('usuarios.index')}}"
                class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i> </a>
        </div> <!--end::Small Box Widget 3-->
    </div> <!--end::Col-->
<div class="col-lg-3 col-6"> <!--begin::Small Box Widget 6-->
        <div class="small-box text-bg-secondary">
            <div class="inner">
                <h3>{{$categorias}}</h3>
                <p>Categorías</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true">
                <path
                    d="M12 3L2 9l10 6 10-6-10-6zm0 7l8.485-4.909L12 8 3.515 5.091 12 10zM2 19v-2l10 6 10-6v2l-10 6-10-6zm10-4l10-6v4l-10 6-10-6v-4l10 6z">
                </path>
            </svg>
            <a href="{{route('categorias.index')}}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div> <!--end::Small Box Widget 6-->

    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 7-->
        <div class="small-box text-bg-dark">
            <div class="inner">
                <h3>{{$subcategorias}}</h3>
                <p>Subcategorías</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true">
                <path
                    d="M12 2C6.486 2 2 6.486 2 12c0 5.514 4.486 10 10 10s10-4.486 10-10c0-5.514-4.486-10-10-10zM12 4c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8zm-1 4v8h2V8h-2zm-2 2H7v4h2v-4zm8 0h-2v4h2v-4z">
                </path>
            </svg>
            <a href="{{route('subcategorias.index')}}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                Ver más <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div> <!--end::Small Box Widget 7-->
</div> <!--end::Row--> <!--begin::Row-->
<div class="row">





</div>
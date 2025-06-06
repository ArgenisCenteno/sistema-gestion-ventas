<nav class="app-header navbar bg-light navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <!-- Puedes agregar un ícono aquí si es necesario -->
                </a>
            </li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Logout Icon-->
            <li class="nav-item">
                <a class="nav-link text-black" href="{{ route('verificarCaja') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Cerrar sesión">
                    <i class="material-icons">logout</i>
                </a>
                <form id="logout-form" action="{{ route('verificarCaja') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            <!--end::Logout Icon-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>

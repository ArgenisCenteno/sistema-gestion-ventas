<aside class="app-sidebar bg-body-secondary shadow pt-2" data-bs-theme="dark"
    style="  background-color:rgb(0, 25, 48) !important; color: white !important"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link--> COMERCIAL <br> YASMELIS RONDÓN
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->

            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                @if(Auth::user()->hasRole('superAdmin') || Auth::user()->hasRole('empleado'))
                    <div class="container-fluid">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="{{url('/home')}}" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>Inicio</p>
                                </a>
                            </li>

                            <!-- Gestionar Sistema -->
                            <li class="nav-item">
                                <a href="{{route('categorias.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-tags"></i>
                                    <p>Categorías</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('subcategorias.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-sitemap"></i>
                                    <p>Subcategorías</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('tasas.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-dollar-sign"></i>
                                    <p>Dólar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('almacen') }}" class="nav-link">
                                    <i class="nav-icon fas fa-boxes"></i>
                                    <p>Almacén</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('usuarios.clientes')}}" class="nav-link">
                                    <i class="nav-icon fas fa-user-friends"></i>
                                    <p>Clientes</p>
                                </a>
                            </li>

                            <!-- Ventas -->
                            <li class="nav-item">
                                <a href="{{route('ventas.vender')}}" class="nav-link">
                                    <i class="nav-icon fas fa-cash-register"></i>
                                    <p>Generar venta</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('ventas.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                    <p>Ventas</p>
                                </a>
                            </li>

                            <!-- Compras -->
                            <li class="nav-item">
                                <a href="{{route('proveedores.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-truck"></i>
                                    <p>Proveedores</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('compras.comprar')}}" class="nav-link">
                                    <i class="nav-icon fas fa-cart-plus"></i>
                                    <p>Generar compra</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('compras.index')}}" class="nav-link">
                                    <i class="nav-icon fas fa-file-invoice"></i>
                                    <p>Compras</p>
                                </a>
                            </li>




                        </ul>
                    </div>


                @else(Auth::role('cliente'))
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>{{Auth::user()->name ?? ''}}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('ventas.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Mis compras</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('carrito.show')}}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Carrito</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('products')}}" class="nav-link">
                            <i class="nav-icon fas fa-store"></i>
                            <p>Seguir comprando</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('pagos.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>Gestión de Pagos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('usuarios.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Perfil</p>
                        </a>
                    </li>

                @endif


            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar--> <!--begin::App Main-->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="backend/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="imgs/{{Auth::guard('admin')->user()->image}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                <li class="nav-item">

                    <a href="{{ url('/admin/dashboard') }}"
                        class="nav-link {{ Session::get('page') == 'dashboard' ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item menu-open">

                    <a
                        class="nav-link {{ Session::get('page') == 'settings' || Session::get('page') == 'update-admin-details' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-atom"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


                        <li class="nav-item">

                            <a href="{{ url('/admin/settings') }}"
                                class="nav-link {{ Session::get('page') == 'settings' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Update Admin Password</p>
                            </a>
                        </li>
                        <li class="nav-item">

                            <a href="{{ url('/admin/update-admin-details') }}"
                                class="nav-link {{ Session::get('page') == 'update-admin-details' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Update Admin Details</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item menu-open">

                    <a
                        class="nav-link {{ Session::get('page') == 'user-order'||Session::get('page') == 'sections'||Session::get('page') == 'coupons'||Session::get('page')=='banners' || Session::get('page') == 'categories' || Session::get('page') == 'products'||Session::get('page')=="brands" ? 'active' : '' }}">
                        <i class="nav-icon fas fa-atom"></i>
                        <p>
                            Catalogues
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">


                        <li class="nav-item">

                            <a href="{{ url('/admin/sections') }}"
                                class="nav-link {{ Session::get('page') == 'sections' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sections</p>
                            </a>
                        </li>
                        <li class="nav-item">

                            <a href="{{ url('/admin/brands') }}"
                                class="nav-link {{ Session::get('page') == 'brands' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">

                            <a href="{{ url('/admin/categories') }}"
                                class="nav-link {{ Session::get('page') == 'categories' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Catagories</p>
                            </a>
                        </li>
                        <li class="nav-item">

                            <a href="{{ url('/admin/products') }}"
                                class="nav-link {{ Session::get('page') == 'products' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">

                            <a href="{{ url('/admin/banners') }}"
                                class="nav-link {{ Session::get('page') == 'banners' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Banners</p>
                            </a>
                        </li>
                        <li class="nav-item">

                            <a href="{{ url('/admin/coupons') }}"
                                class="nav-link {{ Session::get('page') == 'coupons' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Coupons</p>
                            </a>
                        </li>
                        <li class="nav-item">

                            <a href="{{ url('/admin/user-order') }}"
                                class="nav-link {{ Session::get('page') == 'user-order' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Orders</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

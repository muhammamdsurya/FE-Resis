<aside class= "main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/dashboard" class="brand-link " style="text-decoration: none;">
        <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fas fa-user-circle text-white elevation-2" alt="User Icon" style="font-size: 30px;"></i>
            </div>
            <div class="info">
                <a href="/admin/profile" style="text-decoration: none;" class="d-block">{{ $name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/admin/dashboard" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Beranda
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/kelas" class="nav-link {{ request()->routeIs('admin.kelas') || request()->routeIs('detail-kelas') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-reader"></i>
                        <p>
                            Data Kelas
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/bundling" class="nav-link {{ request()->routeIs('admin.bundling') || request()->routeIs('detail-bundling')  ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Data Bundling
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/sales" class="nav-link {{ request()->routeIs('sales') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Data Penjualan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/data-admin" class="nav-link {{ request()->routeIs('data.admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>
                            Data Admin
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/data-pengajar"
                        class="nav-link {{ request()->routeIs('data.pengajar') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>
                            Data Pengajar
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/data-siswa" class="nav-link {{ request()->routeIs('data.siswa') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            Data Siswa
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

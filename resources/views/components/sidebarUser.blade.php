<aside class= "main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link" style="text-decoration: none;">
        <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fas fa-user-circle text-white elevation-2" alt="User Icon" style="font-size: 30px;"></i>
            </div>
            <div class="info">
                <a href="/user/profile" style="text-decoration: none;" class="d-block">{{ $name }}</a>
            </div>

        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/user/dashboard" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Beranda
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/user/kelas" class="nav-link {{ request()->routeIs('kelas') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-reader"></i>
                        <p>
                            Kelasku
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/user/transaksi" class="nav-link {{ request()->routeIs('transaksi') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Data Transaksi
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

</aside>

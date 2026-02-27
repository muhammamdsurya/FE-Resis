<aside class="main-sidebar sidebar-dark-primary elevation-0"
    style="background-color: #1e293b; border-right: 1px solid #334155;">
    <a href="{{ route('user.dashboard') }}" class="brand-link border-0 text-center py-4" style="text-decoration: none;">
        <span class="brand-text font-weight-bold text-white" style="letter-spacing: 1px; font-size: 1.2rem;">
            AKU<span class="text-primary">ANALIS</span>
        </span>
    </a>

    <div class="sidebar px-3">
        <div class="user-panel mt-3 pb-3 mb-4 d-flex align-items-center border-0"
            style="background: rgba(255,255,255,0.05); border-radius: 12px; padding: 10px;">
            <div class="image d-flex justify-content-center">
                <div class="bg-primary d-flex align-items-center justify-content-center rounded-circle shadow-sm"
                    style="width: 35px; height: 35px; min-width: 35px;">
                    <i class="fas fa-user text-white" style="font-size: 16px;"></i>
                </div>
            </div>
            <div class="info">
                <a href="/user/profile" class="d-block text-white fw-600 ml-2"
                    style="text-decoration: none; font-size: 0.9rem;">
                    {{ Str::limit($name, 15) }}
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column gap-2" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-header text-uppercase small text-muted mb-2"
                    style="letter-spacing: 1px; font-size: 0.7rem;">Menu Utama</li>

                <li class="nav-item">
                    <a href="/user/dashboard"
                        class="nav-link py-2 px-3 border-0 {{ request()->routeIs('user.dashboard') ? 'active shadow-sm' : '' }}"
                        style="border-radius: 10px; transition: all 0.3s;">
                        <i class="nav-icon fas fa-th-large mr-2"></i>
                        <p>Beranda</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/user/kelas"
                        class="nav-link py-2 px-3 border-0 {{ request()->routeIs('user.kelas') ? 'active shadow-sm' : '' }}"
                        style="border-radius: 10px; transition: all 0.3s;">
                        <i class="nav-icon fas fa-graduation-cap mr-2"></i>
                        <p>Kelasku</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/user/transaksi"
                        class="nav-link py-2 px-3 border-0 {{ request()->routeIs('transaksi') ? 'active shadow-sm' : '' }}"
                        style="border-radius: 10px; transition: all 0.3s;">
                        <i class="nav-icon fas fa-wallet mr-2"></i>
                        <p>Data Transaksi</p>
                    </a>
                </li>

                <li class="nav-item border-top border-secondary mt-3 pt-3">
                <li class="nav-header text-uppercase small text-muted mb-2"
                    style="letter-spacing: 1px; font-size: 0.7rem;">Layanan AI</li>
                <li class="nav-item">
                    <a href="/user/cvmenu"
                        class="nav-link py-2 px-3 border-0 {{ request()->routeIs('cvmenu') ? 'active shadow-sm' : '' }}"
                        style="border-radius: 10px; transition: all 0.3s;">
                        <i class="nav-icon fas fa-magic mr-2"></i>
                        <p>Analisis CV</p>
                    </a>
                </li>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<style>
    /* Styling khusus Sidebar untuk override AdminLTE */
    .main-sidebar .nav-link.active {
        background-color: #007bff !important;
        color: #fff !important;
    }

    .main-sidebar .nav-link:not(.active):hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        transform: translateX(5px);
    }

    .nav-sidebar .nav-item p {
        font-size: 0.95rem;
        font-weight: 500;
    }

    /* Menghilangkan border bawah default AdminLTE */
    .brand-link,
    .user-panel {
        border-bottom: none !important;
    }

    /* ... (CSS Anda yang sudah ada) ... */

    /* LOGIKA SAAT SIDEBAR MENCIIUT (COLLAPSED) */

    /* 1. Sembunyikan Nama User di Panel */
    .sidebar-collapse .main-sidebar .user-panel .info {
        display: none !important;
    }

    /* 2. Sembunyikan Teks Logo (Brand Text) */
    .sidebar-collapse .main-sidebar .brand-text {
        display: none !important;
    }

    /* 3. Pastikan User Panel tetap rapi di tengah */
    .sidebar-collapse .user-panel {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        justify-content: center !important;
        /* Memaksa konten ke tengah */
        background: transparent !important;
        /* Opsional: hilangkan bg transparan agar lebih bersih */
    }

    .sidebar-collapse .user-panel .image {
        width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        padding: 0 !important;
    }

    /* 4. Menyesuaikan Padding Sidebar saat mini agar ikon tetap center */
    .sidebar-collapse .sidebar {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }

    /* Transition halus saat sidebar melebar/menciut */
    .brand-text,
    .info,
    .user-panel {
        transition: all 0.3s ease-in-out;
    }

    .sidebar-collapse .main-sidebar .brand-text,
    .sidebar-collapse .main-sidebar .info {
        display: none !important;
        opacity: 0;
    }

    /* SAAT SIDEBAR TERBUKA (EXPANDED) */
    /* Pastikan teks muncul kembali saat class .sidebar-collapse tidak ada */
    .main-sidebar:not(.sidebar-collapse) .brand-text,
    .main-sidebar:not(.sidebar-collapse) .info {
        display: inline-block !important;
        opacity: 1;
        transition: opacity 0.3s ease-in-out;
    }

    /* Tambahan agar transisi sidebar mulus dan tidak kaku */
    .brand-link .brand-text {
        transition: opacity 0.3s ease;
    }

    /* Mencegah teks terpotong saat proses animasi melebar */
    .main-sidebar {
        overflow-x: hidden !important;
    }
</style>

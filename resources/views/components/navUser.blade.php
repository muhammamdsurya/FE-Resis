<nav class="main-header navbar navbar-expand navbar-white navbar-light border-0 shadow-sm px-2">
    <ul class="navbar-nav align-items-center">
        <li class="nav-item">
            <a class="nav-link text-secondary" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/"
                class="nav-link fw-500 custom-nav-link {{ request()->is('/') ? 'active-link' : '' }}">Beranda</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/kelas"
                class="nav-link fw-500 custom-nav-link {{ request()->is('kelas*') ? 'active-link' : '' }}">Kelas</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/kontak"
                class="nav-link fw-500 custom-nav-link {{ request()->is('kontak*') ? 'active-link' : '' }}">Kontak</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto align-items-center">

        <li class="nav-item ml-2">
            <div class="d-flex align-items-center px-3 py-1 bg-light rounded-pill border shadow-sm">
                <i class="far fa-calendar-alt text-primary mr-2"></i>
                <span class="small fw-bold text-dark d-none d-md-block">
                    {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
                </span>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link text-secondary hover-icon" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<style>
    /* Styling Navbar agar lebih Modern */
    .main-header {
        transition: all 0.3s ease;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    /* Custom Nav Link */
    .custom-nav-link {
        color: #64748b !important;
        /* Slate Gray */
        font-weight: 500;
        padding: 0.5rem 1rem !important;
        transition: all 0.2s ease;
        position: relative;
    }

    .custom-nav-link:hover {
        color: #007bff !important;
    }

    /* Indikator Active yang elegan */
    .active-link {
        color: #007bff !important;
        font-weight: 700 !important;
    }

    .active-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 3px;
        background-color: #007bff;
        border-radius: 10px;
    }

    /* Hover Icon Right */
    .hover-icon:hover {
        color: #007bff !important;
        transform: scale(1.1);
    }

    /* Utilitas tambahan */
    .fw-500 {
        font-weight: 500;
    }
</style>

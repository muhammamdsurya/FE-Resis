
<div>
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="/" class="logo d-flex align-items-center ">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="{{asset('assets/img/logo.png')}}" alt="">
            </a>

            <div class="search-form ms-2" style="width: 100%">
                <form class="d-flex" role="search" method="GET" action="{{ route('kelas') }}">
                    <input id="searchInput" class="form-control" type="search" placeholder="Cari Kelas..."
                        name="q" aria-label="Search" value="{{ request('q') }}">
                </form>
            </div>


            <nav id="navmenu" class="navmenu">
                <ul>
                    <li>
                        <a href="/" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
                    </li>
                    <li><a href="/kelas" class="{{ request()->routeIs('kelas') ? 'active' : '' }}">Kelas</a></li>
                    <li><a href="/bundling" class="{{ request()->routeIs('bundling') ? 'active' : '' }}">Bundling</a></li>
                    <li><a href="/kontak" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak kami</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted flex-md-shrink-0" href="{{ $href }}" >
            {{ $text }}
         </a>


        </div>
    </header>
</div>

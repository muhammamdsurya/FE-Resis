 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav ml-3">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a href="/" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Beranda</a>
      </li>
      <li class="nav-item">
        <a href="/kelas" class="nav-link">Kelas</a>
      </li>
      <li class="nav-item">
        <a href="/kontak" class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto gap-2 mr-3">

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

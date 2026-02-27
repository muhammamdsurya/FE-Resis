@extends('layout.authLayout')

@section('content')
<style>
    /* Menambahkan Background Estetik */
    body {
        /* Gradient lembut agar tetap profesional */
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        /* Atau jika ingin warna yang lebih 'hidup' (modern mesh):
        background-color: #e5e5f7;
        background-image:  radial-gradient(#0d6efd 0.5px, transparent 0.5px), radial-gradient(#0d6efd 0.5px, #f8fafc 0.5px);
        background-size: 20px 20px;
        background-position: 0 0,10px 10px; */
        margin: 0;
        padding: 0;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    /* Card Styling */
    .login-card {
        border-radius: 24px;
        overflow: hidden;
        border: none;
        /* Shadow lebih dalam agar kartu terlihat melayang di atas background */
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
        background-color: #ffffff !important; /* Memastikan kartu tetap putih bersih */
    }

    /* Area Logo */
    .logo-section {
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        border-right: 1px solid #f1f5f9;
    }

    /* Input Styling */
    .form-control {
        border-radius: 12px;
        padding-right: 48px !important;
        border: 1.5px solid #edf2f7;
        background-color: #fdfdfd;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    /* Tombol Login */
    .btn-login {
        border-radius: 12px;
        font-weight: 600;
        padding: 14px;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.25);
    }

    /* Toggle Mata */
    #togglePassword {
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 100;
        color: #94a3b8;
    }
</style>

<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card login-card">
                    <div class="row g-0 align-items-stretch">

                        <div class="col-md-6 logo-section d-none d-md-flex">
                            <div class="text-center">
                                <img src="{{ asset('assets/img/logo.png') }}"
                                     class="img-fluid"
                                     style="max-width: 75%; height: auto; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.05));"
                                     alt="Instructor Logo">
                            </div>
                        </div>

                        <div class="col-md-6 p-4 p-lg-5">
                            <form method="POST" action="{{ route('login.instructor') }}">
                                @csrf
                                <div class="mb-4">
                                    <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Instruktur Login</h3>
                                    <p class="text-muted small">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
                                </div>

                                @if (session('error'))
                                    <div id="alert-message" class="alert alert-danger py-2 small border-0 shadow-sm d-flex align-items-center mb-4">
                                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                                    </div>
                                @endif

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="floatingInput" placeholder="name@example.com" name="email"
                                        value="{{ old('email') }}" autofocus>
                                    <label for="floatingInput" class="text-muted">Email Address</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating position-relative mb-4">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="floatingPassword" placeholder="Password" name="password">
                                    <label for="floatingPassword" class="text-muted">Password</label>

                                    <span id="togglePassword" class="position-absolute">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>

                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-login w-100 shadow-sm mb-3">
                                    Masuk ke Dashboard
                                </button>

                                <div class="text-center mt-4">
                                    <p class="small text-muted mb-0">Kesulitan masuk? <a href="#" class="text-primary text-decoration-none fw-bold">Hubungi Dukungan</a></p>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <p class="text-center text-muted mt-4 small fw-light">
                    &copy; {{ date('Y') }} <strong>Instructor Portal</strong>.
                    Built for excellence.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#floatingPassword');

        togglePassword.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');

            // Tambahkan sedikit feedback warna saat aktif
            if (isPassword) {
                this.style.color = '#0d6efd';
            } else {
                this.style.color = '#94a3b8';
            }
        });
    });
</script>
@endsection

@extends('layout.authLayout')

@section('content')
<style>
    /* Background Gradient Elegan untuk Halaman Admin */
    body {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        min-height: 100vh;
        margin: 0;
    }

    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    /* Card Styling Modern */
    .admin-card {
        border-radius: 24px;
        overflow: hidden;
        border: none;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1) !important;
        background-color: #ffffff !important;
    }

    /* Sisi Kiri (Area Logo) */
    .logo-container {
        background-color: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        border-right: 1px solid #e2e8f0;
    }

    /* Input Field Modern */
    .form-control {
        border-radius: 12px;
        padding-right: 48px !important;
        border: 1.5px solid #edf2f7;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        background-color: #fff;
    }

    /* Tombol Admin */
    .btn-admin {
        border-radius: 12px;
        font-weight: 600;
        padding: 14px;
        transition: all 0.3s ease;
        background-color: #1e293b; /* Warna admin lebih gelap/tegas */
        border: none;
        color: white;
    }

    .btn-admin:hover {
        background-color: #0f172a;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 41, 59, 0.25);
        color: white;
    }

    /* Ikon Toggle Mata */
    #togglePassword {
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 100;
        color: #94a3b8;
    }
</style>

<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="card admin-card">
                    <div class="row g-0 align-items-stretch">

                        <div class="col-md-6 logo-container d-none d-md-flex">
                            <div class="text-center">
                                <img src="{{ asset('assets/img/logo.png') }}"
                                    class="img-fluid"
                                    style="max-width: 75%; height: auto; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.05));"
                                    alt="Admin Portal">
                            </div>
                        </div>

                        <div class="col-md-6 p-4 p-lg-5">
                            <form method="POST" action="{{ route('login.admin') }}">
                                @csrf
                                <div class="mb-4 text-center text-md-start">
                                    <h3 class="fw-bold text-dark mb-1">Admin Login</h3>
                                    <p class="text-muted small">Panel kontrol sistem keamanan.</p>
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
                                    <label for="floatingInput">Email Admin</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating position-relative mb-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="floatingPassword" placeholder="Password" name="password">
                                    <label for="floatingPassword">Password</label>

                                    <span id="togglePassword" class="position-absolute">
                                        <i class="fas fa-eye-slash"></i>
                                    </span>

                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end mb-4">
                                    <a href="{{ route('reset.password.public') }}" class="small text-decoration-none">Lupa Password?</a>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 shadow-sm mb-3">
                                    Masuk Ke Sistem
                                </button>

                                <div class="text-center mt-3">
                                    <a href="/" class="small text-muted text-decoration-none">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                                    </a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <p class="text-center text-muted mt-4 small fw-light">
                    &copy; {{ date('Y') }} <strong>Secure Admin Panel</strong>. v1.0.0
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

            this.style.color = isPassword ? '#1e293b' : '#94a3b8';
        });
    });
</script>
@endsection

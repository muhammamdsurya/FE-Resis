@extends('layout.authLayout')

@section('content')
<style>
    /* Background Gradient untuk User Login agar lebih fresh */
    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        margin: 0;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    /* Card dengan sudut halus dan shadow elegan */
    .login-card {
        border-radius: 24px;
        overflow: hidden;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08) !important;
        background-color: #ffffff !important;
    }

    /* Sisi Kiri (Area Logo) */
    .logo-section {
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        border-right: 1px solid #f1f5f9;
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
    }

    /* Tombol-tombol */
    .btn-login {
        border-radius: 12px;
        font-weight: 600;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(13, 110, 253, 0.2);
    }

    .btn-google {
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        font-weight: 500;
        transition: all 0.3s ease;
        background: white;
    }

    .btn-google:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Divider "atau" */
    .divider:after, .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    /* Ikon Mata */
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

                        <div class="col-md-6 logo-section d-none d-md-flex text-center">
                            <div>
                                <img src="{{ asset('assets/img/logo.png') }}"
                                     class="img-fluid"
                                     style="max-width: 75%; height: auto;"
                                     alt="Brand Logo">
                                <p class="text-muted mt-3 small">Belajar lebih mudah dan menyenangkan.</p>
                            </div>
                        </div>

                        <div class="col-md-6 p-4 p-lg-5">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-4">
                                    <h3 class="fw-bold text-dark mb-1">Selamat Datang</h3>
                                    <p class="text-muted small">Silakan masuk ke akun Anda untuk melanjutkan.</p>
                                </div>

                                @if (session('error'))
                                    <div id="alert-message" class="alert alert-danger py-2 small border-0 shadow-sm mb-4">
                                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                                    </div>
                                @endif

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="floatingInput" placeholder="name@example.com" name="email"
                                        value="{{ old('email') }}" autofocus>
                                    <label for="floatingInput">Email</label>
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
                                    <a href="{{ route('reset.password.public') }}" class="small text-decoration-none fw-bold text-primary">Lupa Password?</a>
                                </div>

                                <button type="submit" class="btn btn-primary btn-login w-100 mb-3 shadow-sm text-white">
                                    Masuk Sekarang
                                </button>

                                <div class="divider d-flex align-items-center my-4">
                                    <p class="text-center fw-bold mx-3 mb-0 text-muted small">atau</p>
                                </div>

                                <a href="{{ route('login.google') }}" class="btn btn-google w-100 py-2 d-flex align-items-center justify-content-center mb-4">
                                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="18" class="me-2" alt="Google">
                                    Masuk dengan Google
                                </a>

                                <div class="text-center mt-4">
                                    <p class="small mb-0">Belum punya akun? <a href="/register" class="text-primary fw-bold text-decoration-none">Daftar sekarang</a></p>
                                    <a href="/terms" class="text-muted" style="font-size: 10px; text-decoration: none;">Syarat & Ketentuan Berlaku</a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <p class="text-center text-muted mt-4 small fw-light">
                    &copy; {{ date('Y') }} <strong>akuanalis</strong> by resi's project
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

            this.style.color = isPassword ? '#0d6efd' : '#94a3b8';
        });
    });
</script>
@endsection

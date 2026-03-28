@extends('layout.authLayout')
@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            margin: 0;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* Agar ikon berada di atas input */
        .z-index-3 {
            z-index: 3;
        }

        /* Memberi ruang di kanan agar teks password tidak tertutup ikon */
        .pe-5 {
            padding-right: 3rem !important;
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
    </style>
    <div class="login-section" style="background: linear-gradient(135deg, #f8faff 0%, #e9f0ff 100%);">
        <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
            <div class="card border-0 shadow-lg overflow-hidden rounded-4 w-100" style="max-width: 1000px;">
                <div class="row g-0">

                    <div
                        class="col-md-6 bg-light d-none d-md-flex align-items-center justify-content-center p-5 position-relative">
                        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10"
                            style="background-image: url('data:image/svg+xml,...');"></div>
                        <div class="text-center text-dark z-index-1">
                            <img src="assets/img/logo.png" class="img-fluid mb-4 floating-ani"
                                style="width: 15rem; "alt="Logo">
                            <p class="opacity-75">Bergabunglah dengan ribuan profesional lainnya dan raih karier impian Anda
                                bersama Akuanalis.</p>
                        </div>
                    </div>

                    <div class="col-md-6 bg-white p-4 p-lg-5">
                        <form id="registrationForm" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-4 text-center text-md-start">
                                <h3 class="fw-bold text-dark">Registrasi Akun</h3>
                                <p class="text-muted small">Silakan lengkapi data di bawah ini untuk memulai.</p>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3" id="name"
                                    placeholder="Nama lengkap" name="nama">
                                <label for="name text-muted"><i class="bi bi-person me-2"></i>Nama Lengkap</label>
                                <p class="small text-danger mt-1" id="nameError" style="display: none;">Masukkan nama
                                    lengkap</p>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" class="form-control rounded-3" id="email" placeholder="email"
                                    name="email">
                                <label for="email text-muted"><i class="bi bi-envelope me-2"></i>Email</label>
                                <p class="small text-danger mt-1" id="emailError" style="display: none;">Gunakan alamat
                                    email aktif</p>
                            </div>
                            <div class="form-floating mb-2 position-relative">
                                <input type="password" class="form-control rounded-3 pe-5" id="password"
                                    placeholder="Password" name="password">
                                <label for="password" class="text-muted"><i class="bi bi-lock me-2"></i>Password</label>
                                <span
                                    class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer z-index-3"
                                    onclick="togglePassword('password', 'eyeIcon1')">
                                    <i class="bi bi-eye-slash text-muted" id="eyeIcon1"></i>
                                </span>
                            </div>
                            <div class="mb-3 px-1">
                                <p id="passwordError" class="x-small text-muted mb-0" style="font-size: 0.75rem;">
                                    <i class="bi bi-info-circle me-1"></i> Minimal 8 karakter (Huruf, Angka & Simbol)
                                </p>
                            </div>

                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control rounded-3 pe-5" id="confirmPassword"
                                    placeholder="Konfirmasi Password" name="confirm">
                                <label for="confirmPassword" class="text-muted"><i
                                        class="bi bi-shield-check me-2"></i>Konfirmasi Password</label>
                                <span
                                    class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer z-index-3"
                                    onclick="togglePassword('confirmPassword', 'eyeIcon2')">
                                    <i class="bi bi-eye-slash text-muted" id="eyeIcon2"></i>
                                </span>
                                <p id="passwordMismatch" class="small text-danger mt-1" style="display: none;">Password
                                    tidak cocok</p>
                            </div>

                            <button type="submit"
                                class="btn btn-primary btn-login w-100 py-3 fw-bold rounded-3 shadow-sm mt-2"
                                id="register">
                                Buat Akun Sekarang
                            </button>

                            <div class="d-flex align-items-center my-4">
                                <hr class="flex-grow-1 text-muted">
                                <span class="mx-3 text-muted small fw-bold">ATAU</span>
                                <hr class="flex-grow-1 text-muted">
                            </div>

                            <a href="{{ route('register.google') }}"
                                class="btn btn-google w-100 py-2 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="18"
                                    class="me-2" alt="Google">
                                Masuk dengan Google
                            </a>

                            <p class="text-center small mb-0 text-muted">
                                Sudah punya akun? <a href="/login" class="text-primary fw-bold text-decoration-none">Login
                                    di sini</a>
                            </p>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye'); // Ganti ke ikon mata terbuka
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash'); // Ganti ke ikon mata tertutup
            }
        }
        // Check if the alert exists and set a timeout to hide it
        document.addEventListener('DOMContentLoaded', function() {
            var alertMessage = document.getElementById('alert-message');
            if (alertMessage) {
                setTimeout(function() {
                    alertMessage.style.opacity = '0';
                    setTimeout(function() {
                        alertMessage.style.display = 'none';
                    }, 500); // Delay for fade-out effect
                }, 2000); // Time to wait before starting fade-out
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json', // Memberitahu server bahwa kita mengharapkan respons dalam format JSON
                'Content-Type': 'application/json' // Memberitahu server bahwa kita mengirimkan data dalam format JSON
            }
        });

        $(document).ready(function() {

            const passwordInput = $('#password');
            const confirmPasswordInput = $('#confirmPassword');
            const nameInput = $('#name');
            const emailInput = $('#email');
            const registerButton = $('#register');

            function validatePassword() {
                const password = passwordInput.val();
                const confirmPassword = confirmPasswordInput.val();

                const hasUpperCase = /[A-Z]/.test(password);
                const hasDigit = /\d/.test(password);
                const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password); // Check for special character
                const minLength = password.length >= 8;

                if (!minLength || !hasUpperCase || !hasDigit || !hasSpecialChar) {
                    $('#passwordError').show();
                    registerButton.prop('disabled', true);
                } else {
                    $('#passwordError').hide();
                    if (password === confirmPassword) {
                        registerButton.prop('disabled', false);
                        $('#passwordMismatch').hide();
                    } else {
                        $('#passwordMismatch').show();
                        registerButton.prop('disabled', true);
                    }
                }
            }

            function validateForm() {
                const name = nameInput.val().trim();
                const email = emailInput.val().trim();
                const password = passwordInput.val().trim();
                const confirmPassword = confirmPasswordInput.val().trim();

                let valid = true;

                if (name === '') {
                    $('#nameError').show();
                    valid = false;
                } else {
                    $('#nameError').hide();
                }

                if (email === '') {
                    $('#emailError').show();
                    valid = false;
                } else {
                    $('#emailError').hide();
                }

                if (password === '') {
                    $('#passwordError').hide();
                    $('#passwordMismatch').hide();
                }

                if (confirmPassword === '') {
                    $('#passwordMismatch').hide();
                }

                return valid && password === confirmPassword;
            }

            passwordInput.add(confirmPasswordInput).on('input', function() {
                validatePassword();
                validateForm();
            });

            $('#registrationForm').on('submit', function(event) {
                event.preventDefault();

                if (!validateForm()) {
                    return;
                }
                // Menyiapkan data untuk dikirim ke server
                const data = {
                    email: emailInput.val().trim(),
                    password: passwordInput.val().trim(),
                    password_confirm: confirmPasswordInput.val().trim(),
                    full_name: nameInput.val().trim(),
                };

                createOverlay("Proses...");
                $.ajax({
                    method: 'POST',
                    url: '{{ route('register') }}', // URL ke Laravel controller
                    data: JSON.stringify(data), // Mengirim data sebagai JSON
                    contentType: 'application/json', // Set content type ke JSON
                    processData: false, // Tidak memproses data menjadi query string
                    success: function(response) {
                        if (response.status === 'success') {
                            gOverlay.hide()
                            Swal.fire(
                                'Berhasil!',
                                response.message,
                                'success'
                            ).then(() => {
                                window.location.href =
                                    '/login'; // Redirect ke halaman login
                            });
                        } else {
                            gOverlay.hide()
                            Swal.fire(
                                'Ooops!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Ooops!',
                            'Terjadi kesalahan, coba lagi!',
                            'error'
                        );
                    }
                });
            });
        });
    </script>
@endsection

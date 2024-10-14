@extends('layout.authLayout')
@section('content')
    <div class="login">
        <div class="container d-flex align-items-center justify-content-center min-vh-100 z-index-99">
            <div class="container bg-light">
                <div class="row d-flex justify-content-center align-items-center shadow py-3">

                    <div class="col-md-5 col-lg-5 ">
                        <form id="registrationForm" method="POST" action="{{ route('register') }}">
                            @csrf
                            <h3 class="text-center mb-3">Registrasi</h3>
                            <!-- Name input -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="name" placeholder="Nama lengkap"
                                    name="nama">
                                <label for="name">Nama Lengkap</label>
                                <p class="small" id="nameError" style="color: red; display: none;">Masukan nama lengkap</p>
                            </div>

                            <!-- Email input -->
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" placeholder="email"
                                    name="email">
                                <label for="email">Email</label>
                                <p class="small" id="emailError" style="color: red; display: none;">Gunakan alamat email
                                    aktif anda</p>
                            </div>

                            <!-- Password input -->
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password" placeholder="Password"
                                    name="password">
                                <label for="password">Password</label>
                                <p class="small">Gunakan minimal 8 karakter dengan kombinasi huruf, angka & karakter</p>
                                <p id="passwordError" class="small text-danger" style="display: none;">Password harus
                                    mengandung minimal 8 karakter, 1 huruf besar, 1 angka & 1 Karakter</p>
                            </div>

                            <div class="form-floating">
                                <input type="password" class="form-control" id="confirmPassword"
                                    placeholder="Konfirmasi Password" name="confirm">
                                <label for="confirmPassword">Konfirmasi Password</label>
                                <p id="passwordMismatch" class="small text-danger" style="display: none;">Password tidak
                                    cocok</p>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" class="btn btn-primary w-100" id="register"
                                    disabled>Registrasi</button>

                                <div class="d-flex align-items-center my-2">
                                    <div class="flex-grow-1 border-top" style="border-color: #ccc;"></div>
                                    <span class="mx-2">atau</span>
                                    <div class="flex-grow-1 border-top" style="border-color: #ccc;"></div>
                                </div>

                                <a href="{{ route('register.google') }}" class="btn btn-light w-100"><i
                                        class="bi bi-google mx-3"></i>Daftar
                                    dengan google</a>

                                <p class="small mt-3 pt-1 mb-0">Sudah punya akun? <a href="/login"
                                        class="link-primary">Login</a></p>
                            </div>
                        </form>

                    </div>
                    <div class="col-md-5 col-lg-5">
                        <img src="assets/img/logo.png" class="img-fluid d-none d-md-block mx-auto" style="width: 20rem;"
                            alt="Sample image">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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

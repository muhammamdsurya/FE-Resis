@extends('layout.authLayout')

@section('content')
<style>
    /* Background Gradient konsisten dengan sistem */
    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
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

    /* Card Reset Password yang lebih ramping dan elegan */
    .reset-card {
        max-width: 450px;
        width: 100%;
        border-radius: 24px;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08) !important;
        background-color: #ffffff !important;
        padding: 40px;
    }

    /* Ikon Kunci di bagian atas */
    .icon-box {
        width: 70px;
        height: 70px;
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin: 0 auto 20px;
    }

    .form-control {
        border-radius: 12px;
        border: 1.5px solid #edf2f7;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    .btn-reset {
        border-radius: 12px;
        font-weight: 600;
        padding: 12px;
        transition: all 0.3s ease;
        background-color: #0d6efd;
        border: none;
    }

    .btn-reset:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(13, 110, 253, 0.2);
    }
</style>

<div class="auth-wrapper">
    <div class="reset-card">
        <div class="icon-box">
            <i class="fas fa-lock"></i>
        </div>

        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark">Lupa Password?</h3>
            <p class="text-muted small">Jangan khawatir! Masukkan email Anda dan kami akan mengirimkan instruksi untuk mengatur ulang password Anda.</p>
        </div>

        <form id="resetPasswordForm">
            <div class="mb-4">
                <label for="email" class="form-label small fw-bold text-secondary">Email Terdaftar</label>
                <input type="email" class="form-control" id="email" name="email" required
                       placeholder="nama@email.com">
            </div>

            <button type="submit" class="btn btn-primary btn-reset w-100 shadow-sm mb-3">
                Kirim Instruksi Reset
            </button>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="small text-decoration-none fw-bold">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#resetPasswordForm').on('submit', function(e) {
            e.preventDefault();

            const email = $('#email').val();

            // createOverlay dan gOverlay diasumsikan sudah ada di layout utama
            if (typeof createOverlay === "function") createOverlay("Mengirim email...");

            $.ajax({
                url: '{{ route('reset.password') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                contentType: 'application/json',
                data: JSON.stringify({ email: email }),
                success: function(response) {
                    if (typeof gOverlay !== "undefined") gOverlay.hide();

                    Swal.fire({
                        title: 'Email Terkirim!',
                        text: response.message,
                        icon: 'success',
                        border: 'none',
                        confirmButtonColor: '#0d6efd',
                        confirmButtonText: 'Oke, Paham'
                    });
                },
                error: function(xhr) {
                    if (typeof gOverlay !== "undefined") gOverlay.hide();

                    Swal.fire({
                        title: 'Oops...',
                        text: xhr.responseJSON.message || 'Terjadi kesalahan sistem.',
                        icon: 'error',
                        confirmButtonColor: '#0d6efd'
                    });
                }
            });
        });
    });
</script>
@endsection

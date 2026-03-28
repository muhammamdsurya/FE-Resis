@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <style>
        .profile-card {
            transition: transform 0.3s ease;
        }

        .form-control:disabled {
            cursor: not-allowed;
            opacity: 0.8;
            color: #333;
        }

        .profile-avatar i {
            color: #4e73df !important;
        }
    </style>

    <div class="container-fluid p-4" style="background-color: #f4f6f9; min-height: 100vh;">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-11">
                <div class="card profile-card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="profile-header-bg"
                        style="background: linear-gradient(45deg, #4e73df, #224abe); height: 120px;"></div>

                    <div class="profile-avatar-wrapper text-center"
                        style="margin-top: -60px; position: relative; z-index: 1;">
                        <div class="profile-avatar mb-3">
                            <i class="fas fa-user-circle fa-7x text-white bg-white rounded-circle shadow"></i>
                        </div>
                        <h3 class="fw-bold mt-2 mb-0 text-dark">{{ $full_name }}</h3>
                        <div class="mt-2">
                            <span class="badge rounded-pill bg-primary-subtle text-primary px-4 py-2">
                                <i class="fas fa-shield-alt me-1"></i> Tipe: {{ strtoupper($role) }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body px-lg-5 pb-5 pt-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small text-uppercase">Nama Lengkap</label>
                                <input type="text" class="form-control bg-light border-0 shadow-none py-2"
                                    value="{{ $full_name }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small text-uppercase">Email</label>
                                <input type="email" class="form-control bg-light border-0 shadow-none py-2"
                                    value="{{ $email }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small text-uppercase">Dibuat Tanggal</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i
                                            class="far fa-calendar-alt"></i></span>
                                    <input type="text" class="form-control bg-light border-0 shadow-none py-2"
                                        value="{{ $created_at }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted small text-uppercase">Diperbarui
                                    Tanggal</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i
                                            class="fas fa-history"></i></span>
                                    <input type="text" class="form-control bg-light border-0 shadow-none py-2"
                                        value="{{ $updated_at }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mt-5">
                            <button type="button" class="btn btn-warning px-4 fw-bold shadow-sm reset-password">
                                <i class="fas fa-key me-2"></i>Reset Password
                            </button>

                            <button type="button" class="btn btn-danger btn-logout px-4 fw-bold shadow-sm">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.reset-password').addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah pengiriman formulir default

                // Ambil email dari input
                const email = document.querySelector('#email').value;

                // Lakukan validasi
                if (!email) {
                    Swal.fire('Gagal!', 'Email harus diisi', 'error');
                    return;
                }

                // Kirim permintaan AJAX
                fetch("{{ route('reset.password') }}", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Menambahkan token CSRF
                        },
                        body: JSON.stringify({
                            email: email
                        }) // Kirim email sebagai JSON
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Permintaan gagal!');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Tampilkan pesan sukses
                        Swal.fire('Sukses!', data.message, 'success');
                    })
                    .catch(error => {
                        // Tangani error
                        Swal.fire('Sukses!', error.message, 'success');
                    });
            });

            document.querySelector('.btn-logout').addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah pengiriman formulir default

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda akan keluar dari akun Anda!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mengirimkan permintaan POST untuk logout
                        fetch('/logout', {

                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({}) // Laravel mengharapkan metode POST
                            })
                            .then(response => {

                                if (response.ok) {
                                    // Redirect setelah logout
                                    Swal.fire(
                                        'Logged out!',
                                        'Anda telah berhasil logout.',
                                        'success'
                                    ).then(() => {
                                        window.location.href =
                                            '/login'; // Redirect ke halaman login dengan HTTPS
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Terjadi kesalahan saat logout.',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat logout.',
                                    'error'
                                );
                            });
                    }
                });
            });
        });
    </script>

@endsection

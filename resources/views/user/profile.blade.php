@extends('layout.userLayout')

@section('content')
<style>
    .profile-card {
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }
    .profile-header-bg {
        background: linear-gradient(135deg, #007bff 0%, #00d2ff 100%);
        height: 120px;
    }
    .profile-avatar-wrapper {
        margin-top: -60px;
        text-align: center;
        margin-bottom: 20px;
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 6px solid #fff;
        background-color: #f8f9fa;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #007bff;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .form-label {
        font-weight: 600;
        font-size: 0.8rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-control:disabled, .form-control[readonly] {
        background-color: #f8f9fa;
        border-color: #e9ecef;
        color: #495057;
    }
</style>

<div class="container-fluid p-4" style="background-color: #f4f6f9; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-11">
            <div class="card profile-card shadow-sm">
                <div class="profile-header-bg"></div>

                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h3 class="fw-bold mt-2 mb-0">{{ $full_name }}</h3>
                    <p class="text-muted">{{ $email }}</p>
                </div>

                <div class="card-body px-lg-5 pb-5">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control shadow-none" value="{{ $full_name }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control shadow-none" value="{{ $email }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="text" class="form-control shadow-none" value="{{ $birth }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Pendidikan</label>
                            <input type="text" class="form-control shadow-none" value="{{ $study_level }}" readonly>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Institusi / Sekolah</label>
                            <input type="text" class="form-control shadow-none" value="{{ $institution }}" disabled>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mt-5">
                        <button type="button" class="btn btn-success px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </button>
                        <button type="button" class="btn btn-danger btn-logout px-4 fw-bold">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold"><i class="fas fa-user-edit text-success me-2"></i>Edit Profile</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('update.data') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light" value="{{ $full_name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Email</label>
                            <input type="email" class="form-control bg-light" id="emailModal" value="{{ $email }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="birth" value="{{ $birth_edit }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Pendidikan</label>
                            <select class="form-select" name="study_level">
                                <option value="sd" {{ $study_level == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="smp" {{ $study_level == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="sma" {{ $study_level == 'SMA' ? 'selected' : '' }}>SMA</option>
                                <option value="universitas" {{ $study_level == 'UNIVERSITAS' ? 'selected' : '' }}>Universitas</option>
                                <option value="umum" {{ $study_level == 'UMUM' ? 'selected' : '' }}>Umum</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Sekolah</label>
                            <input type="text" class="form-control" name="institution" value="{{ $institution }}">
                        </div>
                        <div class="col-12 mt-3">
                            <button type="button" class="btn btn-sm btn-outline-danger reset-password shadow-none">
                                <i class="fas fa-key me-1"></i> Reset Password
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // SWAL UNTUK SESSION MESSAGE
        @if (session('message'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('message') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif

        // LOGIKA RESET PASSWORD (SWAL + FETCH)
        document.querySelector('.reset-password').addEventListener('click', function(e) {
            e.preventDefault();
            const email = document.querySelector('#emailModal').value;

            if (!email) {
                Swal.fire('Gagal!', 'Email harus diisi', 'error');
                return;
            }

            Swal.fire({
                title: 'Kirim Reset Password?',
                text: "Link reset password akan dikirim ke email Anda.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('reset.password') }}", {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ email: email })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Permintaan gagal!');
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message });
                    })
                    .catch(error => {
                        Swal.fire({ icon: 'error', title: 'Ooops!', text: error.message });
                    });
                }
            });
        });

        // LOGIKA LOGOUT (SWAL + FETCH)
        document.querySelector('.btn-logout').addEventListener('click', function(e) {
            e.preventDefault();

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
                    fetch('/logout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (response.ok) {
                            Swal.fire('Logged out!', 'Berhasil logout.', 'success')
                            .then(() => { window.location.href = '/login'; });
                        } else {
                            Swal.fire('Error!', 'Terjadi kesalahan saat logout.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    });
                }
            });
        });
    });
</script>
@endsection

@extends('layout.userLayout')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Profile</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullName" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="fullName" value="{{ $full_name }}"
                                    disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ $email }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="birth" class="form-label">Tanggal Lahir</label>
                                <input type="text" class="form-control" id="birth" value="{{ $birth }}"
                                    disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="studyLevel" class="form-label">Pendidikan</label>
                                <input type="text" class="form-control" id="studyLevel" value="{{ $study_level }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="institution" class="form-label">Sekolah</label>
                                <input type="text" class="form-control" id="institution" value="{{ $institution }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Edit</button>
                            <button type="button" class="btn btn-danger btn-logout">Logout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.data') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label for="fullName" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="fullName" name="full_name"
                                    value="{{ $full_name }}" readonly>
                            </div>
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="emailModal" name="emailModal"
                                    value="{{ $email }}" readonly>
                            </div>
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label for="birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="birth" name="birth"
                                    value="{{ $birth_edit }}">
                            </div>
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label for="studyLevel" class="form-label">Pendidikan</label>
                                <select class="form-select" id="studyLevel" name="study_level">
                                    <option value="sd" {{ $study_level == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="smp" {{ $study_level == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="sma" {{ $study_level == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="universitas" {{ $study_level == 'UNIVERSITAS' ? 'selected' : '' }}>
                                        Universitas</option>
                                    <option value="umum" {{ $study_level == 'UMUM' ? 'selected' : '' }}>Umum</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for="institution" class="form-label">Sekolah</label>
                                <input type="text" class="form-control" id="institution" name="institution"
                                    value="{{ $institution }}">
                            </div>
                            <div class="col-lg-12 mb-3">
                                <button type="button" class="btn btn-sm btn-danger reset-password"
                                    id="resetPassword">Reset Password</button>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            document.querySelector('.reset-password').addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah pengiriman formulir default

                // Ambil email dari input
                const email = document.querySelector('#emailModal').value;
                console.log(email);

                // Lakukan validasi
                if (!email) {
                    alert('Email harus diisi!');
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Yess',
                            text: data.message
                        });
                    })
                    .catch(error => {
                        // Tangani error
                        Swal.fire({
                            icon: 'error',
                            title: 'Ooops!',
                            text: error.message
                        });
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

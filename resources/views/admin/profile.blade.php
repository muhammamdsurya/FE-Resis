@extends('layout.adminLayout')
@section('title', $title)

@section('content')

    <style>

    </style>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <div class="text-center mb-3">
                            <span class="badge bg-primary fs-5">Tipe : {{ $role }}</span>
                        </div>

                        <div class="mb-3">
                            <label for="fullName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="fullName" value="{{ $full_name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $email }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="createdAt" class="form-label">Dibuat Tanggal</label>
                            <input type="text" class="form-control" id="createdAt" value="{{ $created_at }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="updatedAt" class="form-label">Diperbarui Tanggal</label>
                            <input type="text" class="form-control" id="updatedAt" value="{{ $updated_at }}" disabled>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-warning mb-3 reset-password">Reset Pasword</button>
                            <button type="submit" class="btn btn-danger mb-3 btn-logout">Logout</button>
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

@extends('layout.InstLayout')
@section('title', $title)

@section('content')
    <div class="container">

        <div class="image text-center mb-5">
            <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" alt="" class="rounded-circle"
                width="200rem" height="200rem">

        </div>
        <div class="row">
            <div class="col-lg-5 col-md-6 mx-auto">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="email" value="{{ $full_name }}">
                    <label for="floatingInput">Nama Lengkap</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="email" value="">
                    <label for="floatingInput">Pendidikan</label>
                </div>

                <p class="fs-6">Dibuat Tanggal : {{ $created_at }}</p>


            </div>
            <div class="col-lg-5 col-md-6 mx-auto">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="email" value="{{ $email }}">
                    <label for="floatingInput">Email</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="email" value="">
                    <label for="floatingInput">Pengalaman</label>
                </div>

                <p class="fs-6">Diupdate Tanggal : {{ $updated_at }} </p>

            </div>

            <div class="col-lg-5 ml-5">
                <button type="submit" class="btn btn-success px-3 mb-5 mt-3">Edit</button>
                <button type="submit" class="btn btn-danger px-3 mb-5 mt-3 btn-logout">Logout</a>
            </div>

        </div>

    </div>


    <script>
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
    </script>

@endsection

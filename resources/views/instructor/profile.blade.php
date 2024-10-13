@extends('layout.InstLayout')
@section('title', $title)

@section('content')
    <div class="container ">
        <!-- Profile Image Section -->
        <div class="image text-center mb-4">
            <img src="{{ $photo_profile }}" alt="Profile Picture" class="rounded-circle shadow" width="200rem" height="200rem">
        </div>

        <!-- Form Section -->
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6 ">
                <!-- Name Field -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control shadow-sm" id="floatingFullName" placeholder="Full Name"
                        name="full_name" value="{{ $full_name }}">
                    <label for="floatingFullName">Nama Lengkap</label>
                </div>

                <!-- Education Field -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control shadow-sm" id="floatingEducation" placeholder="Pendidikan"
                        name="education" value="{{ $data['education'] }}">
                    <label for="floatingEducation">Pendidikan</label>
                </div>

                <!-- Creation Date (Hidden on mobile, shown on larger screens) -->
                <p class="text-muted small d-none d-md-block">Dibuat Tanggal: {{ $created_at }}</p>
            </div>

            <div class="col-lg-5 col-md-6">
                <!-- Email Field -->
                <div class="form-floating mb-3">
                    <input type="email" class="form-control shadow-sm" id="floatingEmail" placeholder="Email"
                        name="email" value="{{ $email }}">
                    <label for="floatingEmail">Email</label>
                </div>

                <!-- Experience Field -->
                <div class="form-floating mb-3">
                    <input type="text" class="form-control shadow-sm" id="floatingExperience" placeholder="Experience"
                        name="experience" value="{{ $data['experience'] }}">
                    <label for="floatingExperience">Pengalaman</label>
                </div>

                <!-- Update Date (Hidden on mobile, shown on larger screens) -->
                <p class="text-muted small d-none d-md-block">Diaktivasi Tanggal: {{ $activated_at }}</p>
            </div>
        </div>

        <!-- Creation & Update Date (Shown only on mobile) -->
        <div class="row d-md-none mt-4">
            <div class="col text-center">
                <p class="text-muted small">Dibuat Tanggal: {{ $created_at }}</p>
                <p class="text-muted small">Diaktivasi Tanggal: {{ $activated_at }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center my-3">
            <button type="button" class="btn btn-danger mx-2 btn-logout">Logout</button>
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

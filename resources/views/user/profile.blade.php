@extends('layout.userLayout')
@section('title', $title)

@section('content')
    <div class="container">

        <div class="row ">
            <div class="col-lg-5 col-md-6 mx-auto">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ $full_name }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email </label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ $email }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Tanggal lahir </label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ $birth }}" disabled>
                </div>


            </div>
            <div class="col-lg-5 col-md-6 mx-auto">


                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label"> Jenjang </label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ $study_level }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label"> Sekolah </label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ $institution }}" disabled>
                </div>

            </div>

            <div class="col-lg-5 ml-5">
                <button type="button" class="btn btn-success px-3 mb-5 mt-3" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Edit</button>
                <button type="submit" class="btn btn-danger px-3 mb-5 mt-3 btn-logout">Logout</a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="">
                        <div class="row ">
                            <div class="col-lg-5 col-md-6 mx-auto">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $full_name }}">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email </label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $email }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Tanggal lahir </label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $birth }}">
                                </div>

                            </div>
                            <div class="col-lg-5 col-md-6 mx-auto">

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Jenjang</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $study_level }}">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Sekolah</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $institution }}">
                                </div>


                            </div>

                            <a href="/reset-password" class="small ml-4">Reset Password</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

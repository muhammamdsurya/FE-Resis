@extends('layout.authLayout')

@section('content')

    <body>
        <div class="login">

            <div class="container vh-100 d-flex justify-content-center align-items-center">
                <!-- Memastikan container memenuhi tinggi layar -->
                <div class="card shadow" style="width: 400px;"> <!-- Mengatur lebar card -->
                    <div class="card-body">
                        <h5 class="card-title text-center mb-2">Reset Password</h5>
                        <hr class="mb-4">
                        <form id="resetPasswordForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Masukkan Email Terdaftar</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    placeholder="example@mail.com">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Kirim Email</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <script>
            $(document).ready(function() {

                // Event listener untuk mengirim form
                $('#resetPasswordForm').on('submit', function(e) {
                    e.preventDefault(); // Mencegah pengiriman form default

                    const email = $('#email').val();

                    $.ajax({
                        url: '{{ route('reset.password') }}', // Route untuk mengatur password
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content'), // CSRF token dari Laravel
                        },
                        contentType: 'application/json',
                        data: JSON.stringify({
                            email: email,

                        }),
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000, // Automatically close after 2 seconds
                                    showConfirmButton: false
                                })
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: xhr.responseJSON.message,
                                icon: 'error',
                                timer: 2000, // Automatically close after 2 seconds
                                showConfirmButton: false
                            })
                        }
                    });
                });
            });
        </script>
    </body>
@endsection

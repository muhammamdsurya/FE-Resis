@extends('layout.authLayout')

@section('content')
    <div class="login">
        <div class="container vh-100 d-flex justify-content-center align-items-center">
            <div class="card shadow w-50 p-4">
                <h4 class="text-center mb-2">Reset Password</h4>
                <hr class="mb-4">
                <form id="resetPasswordForm" onsubmit="return validatePassword()">
                    <div class="mb-3 position-relative">
                        <label for="newPassword" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                    </div>

                    <div class="mb-3 position-relative">

                        <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                    </div>
                    <p class="small text-muted">Gunakan minimal 8 karakter dengan kombinasi huruf, angka & karakter khusus.
                    </p>


                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function validatePassword() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Validasi panjang dan kompleksitas password
            const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;

            if (!passwordRegex.test(newPassword)) {
                Swal.fire('Ooops!','Password harus minimal 8 karakter dengan kombinasi huruf, angka, dan karakter khusus.','error');
                return false;
            }

            if (newPassword !== confirmPassword) {
                Swal.fire('Ooops!','Password tidak cocok','error');
                return false;
            }

            return true; // Lanjutkan pengiriman form jika validasi berhasil
        }
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const token = urlParams.get('token');
            const email = urlParams.get('email');


            // Event listener untuk mengirim form
            $('#resetPasswordForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah pengiriman form default

                const newPassword = $('#newPassword').val();
                const confirmPassword = $('#confirmPassword').val();
                const email = urlParams.get('email');

                // Validasi konfirmasi password
                if (newPassword !== confirmPassword) {
                    Swal.fire({
                        title: 'Ooops!',
                        text: 'Password Tidak Cocok',
                        icon: 'error',
                        timer: 2000, // Automatically close after 2 seconds
                        showConfirmButton: false
                    });
                    return;
                }

                $.ajax({
                    url: `/reset-password/${token}`, // Route untuk mengatur password
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // CSRF token dari Laravel
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        email: email,
                        new_password: newPassword,
                        new_password_confirm: confirmPassword
                    }),
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Password berhasil diperbarui. Anda akan diarahkan ke halaman login.',
                                icon: 'success',
                                timer: 2000, // Automatically close after 2 seconds
                                showConfirmButton: false
                            }).then(function() {
                                // Redirect to logout after Swal is closed
                                window.location.href = '/login';
                            });
                        }

                    },
                    error: function(xhr) {
                        // Parse the JSON response
                        let response = JSON.parse(xhr.responseText);

                        let errorMessage = response.message ? response.message.trim() :
                            'Terjadi kesalahan';

                        // Log the full response to the console for debugging (optional)
                        console.log(response);

                        // Check if the response contains a message
                        Swal.fire(
                            'Ooops!',
                            'Terjadi kesalahan.' + (xhr
                                .responseJSON?.message || ''),
                            'error'
                        );
                    }

                });
            });
        });
    </script>
@endsection

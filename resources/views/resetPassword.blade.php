<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container {
            max-width: 500px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card p-4">
            <h4 class="text-center mb-4">Reset Password</h4>
            <form id="resetPasswordForm">
                <div class="mb-3 position-relative">
                    <label for="newPassword" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="newPassword" name="new_password" required>
                </div>

                <div class="mb-3 position-relative">

                    <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>
        </div>
    </div>

    <script>
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
                    alert('Konfirmasi password tidak cocok.');
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
                    console.log(response);
                        if (response.status === 'success') {
                            alert(
                                'Password berhasil diperbarui. Anda akan diarahkan ke halaman login.'
                            );
                            setTimeout(function() {
                                window.location.href =
                                    '/logout'; // Redirect ke halaman login
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
</body>

</html>

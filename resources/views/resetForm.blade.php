<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <form id="resetPasswordForm">
            <div class="mb-3">
                <label for="newPassword" class="form-label">Masukan Email Terdaftar</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <button type="submit" class="btn btn-primary">Kirim email</button>
        </form>
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
                       console.log(response);
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

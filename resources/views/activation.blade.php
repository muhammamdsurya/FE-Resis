<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aktivasi Akun</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .activation-container {
            max-width: 400px;
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: .5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .activation-container i {
            font-size: 3rem;
            color: #28a745;

        }

        .activation-container.success i {
            color: #28a745;
        }

        .activation-container.error i {
            color: #dc3545;
        }

        .activation-container h1 {
            font-size: 1.5rem;
            margin: 15px 0;
        }

        .activation-container p {
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <div class="activation-container mx-auto" id="activation-box">
        <i class="fas fa-check-circle"></i>
        <h1 id="message-header">Aktivasi Akun</h1>
        <p id="message">Sedang memproses...</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const token = urlParams.get('token');
            const email = urlParams.get('email');

            const activationBox = $('#activation-box');
            const messageHeader = $('#message-header');
            const message = $('#message');
            const icon = activationBox.find('i');

            if (token && email) {
                $.ajax({
                    url: `/activate/${token}`, // Laravel route untuk aktivasi
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // CSRF token dari Laravel
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        email: email
                    }), // Kirim email sebagai data JSON
                    success: function(response) {
                        if (response.status === 'success') {
                            messageHeader.text('Aktivasi Berhasil');
                            message.text('Akun Anda berhasil diaktifkan. Silakan login.');
                            activationBox.addClass('success').removeClass('error');
                            setTimeout(function() {
                                window.location.href = '/login'; // Redirect ke halaman login
                            }, 2000);
                        }
                    },
                    error: function(xhr) {
                        messageHeader.text('Aktivasi Gagal');
                        message.text('Token mungkin tidak valid atau sudah kadaluarsa.');
                        activationBox.addClass('error').removeClass('success');
                        icon.addClass('fa-times-circle'); // Tampilkan ikon kegagalan
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    </script>



</body>

</html>

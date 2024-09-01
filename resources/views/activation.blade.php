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
        const API_URL = '{{ env('API_URL') }}'; // Mengambil URL dari variabel lingkungan

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const token = urlParams.get('token');
            const email = urlParams.get('email');

            const activationBox = document.getElementById('activation-box');
            const messageHeader = document.getElementById('message-header');
            const message = document.getElementById('message');
            const icon = activationBox.querySelector('i');


            if (token && email) {
                fetch(`${API_URL}auth/activation/${token}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            email: email
                        })
                    })
                    .then(response => {

                        if (response.status === 200) {
                            return response.json(); // Jika status 200, ambil respons sebagai JSON
                        } else {
                            return response.text().then(text => {
                                throw new Error(text); // Jika status selain 200, lemparkan error
                            });
                        }
                    })
                    .then(data => {
                            messageHeader.innerText = 'Aktivasi Berhasil';
                            message.innerText = 'Akun Anda berhasil diaktifkan. Silakan login.';
                            activationBox.classList.add('success');
                            activationBox.classList.remove('error');
                            setTimeout(() => {
                                window.location.href = '/login';
                            }, 2000);

                    })
                    .catch(error => {
                        messageHeader.innerText = 'Aktivasi Gagal';
                        message.innerText = 'Token mungkin tidak valid atau sudah kadaluarsa.';
                        activationBox.classList.add('error');
                        icon.classList.add('fa-times-circle'); // Change to failure icon
                        activationBox.classList.remove('success');
                    });
            }
        });
    </script>



</body>

</html>

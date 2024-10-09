@extends('layout.layout')

@section('content')
    <section class="section">
        <div class="container mt-5 section-title" data-aos="fade-up">
            <p>Kontak Kami<br></p>
            <p class="fs-6 text-dark">Hubungi Kami, Kami Ada di Sini Untukmu!</p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-center">
                <!-- Google Maps Embed -->
                <div class="col-lg-6 mb-4">
                    <div class="map-container" style="height: 400px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345096264!2d144.95373531531657!3d-37.81627997975173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f123456%3A0xabcdef123456789!2sYour%20Location!5e0!3m2!1sen!2sus!4v1631898377850!5m2!1sen!2sus"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>
                <!-- Contact Form -->
                <div class="col-lg-6">
                    <form id="messageForm" onsubmit="return sendMessage()">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nameInput" required>
                        </div>
                        <div class="mb-3">
                            <label for="messageTextarea" class="form-label">Pesan</label>
                            <textarea class="form-control" id="messageTextarea" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success" style="width: 100%">
                                <i class="bi bi-whatsapp"></i> Kirim via WhatsApp
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        function sendMessage() {
            const form = document.getElementById('messageForm');

            // Memeriksa validitas formulir
            if (!form.checkValidity()) {
                form.reportValidity(); // Menampilkan pesan kesalahan
                return false; // Mencegah pengiriman formulir
            }

            // Ambil nilai dari input dan textarea
            const name = document.getElementById('nameInput').value.trim();
            const message = document.getElementById('messageTextarea').value.trim();

            // Encode nilai untuk URL
            const encodedName = encodeURIComponent(name);
            const encodedMessage = encodeURIComponent(message);

            // Ambil nomor WhatsApp dari server (harus diubah dengan nomor Anda)
            const whatsappNumber = '+6285717358096';

            // Buat URL WhatsApp dengan parameter teks
            const whatsappURL =
                `https://api.whatsapp.com/send?phone=${whatsappNumber}&text=Nama:%20${encodedName}%0APesan:%20${encodedMessage}`;

            // Arahkan ke URL WhatsApp
            window.open(whatsappURL, '_blank');

            // Mencegah pengiriman formulir secara default
            return false;
        }
    </script>
@endsection

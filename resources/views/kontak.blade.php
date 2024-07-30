@extends('layout.layout')

@section('content')
        <section class="section">
            <div class="container mt-5 section-title" data-aos="fade-up">
                <p>Kontak Kami<br></p>
                <p class="fs-6 text-dark">Hubungi Kami, Kami Ada di Sini Untukmu!</p>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <form id="messageForm" onsubmit="return sendMessage()">
                    <div class="col-lg-6 mx-auto">
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
                    </div>
                </form>
                </div>
            </div>
        <section>

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
    const whatsappNumber = '+628889162042';

    // Buat URL WhatsApp dengan parameter teks
    const whatsappURL = `https://api.whatsapp.com/send?phone=${whatsappNumber}&text=Nama:%20${encodedName}%0APesan:%20${encodedMessage}`;

    // Arahkan ke URL WhatsApp
    window.open(whatsappURL, '_blank');

    // Mencegah pengiriman formulir secara default
    return false;
}


        </script>
@endsection

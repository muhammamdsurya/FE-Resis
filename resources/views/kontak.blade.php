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
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253813.8766008566!2d106.80855836726039!3d-6.284513705843108!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698c6900964f69%3A0xd00495351896398!2sBekasi%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1729278297877!5m2!1sen!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <!-- Contact Form -->
                <div class="col-lg-6">
                    <form>
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nameInput" required>
                        </div>
                        <div class="mb-3">
                            <label for="messageTextarea" class="form-label">Pesan</label>
                            <textarea class="form-control" id="messageTextarea" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-success" style="width: 100%"
                                onclick="sendMessage('628889162042')">
                                <i class="bi bi-whatsapp"></i> Admin 1 (Dimas)
                            </button>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-success" style="width: 100%"
                                onclick="sendMessage('6285782244353')">
                                <i class="bi bi-whatsapp"></i> Admin 2 (Gita)
                            </button>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-success" style="width: 100%"
                                onclick="sendMessage('6285133795890')">
                                <i class="bi bi-whatsapp"></i> Admin 3 (Okta)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        function sendMessage(whatsappNumber) {
            const form = document.getElementById('messageForm');

            // Get values from input and textarea
            const name = document.getElementById('nameInput').value.trim();
            const message = document.getElementById('messageTextarea').value.trim();

            // Encode values for URL
            const encodedName = encodeURIComponent(name);
            const encodedMessage = encodeURIComponent(message);

            // Construct WhatsApp URL with the selected number
            const whatsappURL =
                `https://api.whatsapp.com/send?phone=${whatsappNumber}&text=Nama:%20${encodedName}%0APesan:%20${encodedMessage}`;

            // Open WhatsApp URL in a new tab
            window.open(whatsappURL, '_blank');

            return false; // Prevent form default submission
        }
    </script>
@endsection

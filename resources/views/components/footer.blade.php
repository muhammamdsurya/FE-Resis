<footer id="footer" class="footer shadow-lg">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="/" class="d-flex align-items-center">
                    <span class="sitename">AkuAnalis</span>
                </a>
                <div class="footer-contact pt-3">
                    <p>Kota Bekasi, Jawa Barat</p>
                    <p>Indonesia</p>
                    <div class="social-links d-flex mt-3">
                        <a href="https://wa.me/{{ env('WHATSAPP_NUMBER') }}"><i class="bi bi-whatsapp"></i></a>
                        <a href="https://www.facebook.com/profile.php?id=100086836052617"><i
                                class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/resis.project/"><i class="bi bi-instagram"></i></a>
                        <a href="http://www.linkedin.com/in/dimas-panduresi-9258591b4"><i
                                class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Profile</h4>
                <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="/#about">Tentang kami</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="/#alt-features">Keunggulan</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="/#visi">Visi Misi</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="/#testimonials">Testimoni</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="/#faq">F A Q</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Navigasi</h4>
                <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="/">Beranda</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="/kelas">Kelas Kami</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="/kontak">Kontak</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12">
                <h4>Partner Kami</h4>
                <div class="partner"> <!-- Mengatur teks dan gambar berada di tengah -->
                    <!-- Gambar -->
                    <img src="{{asset('assets/img/logo1.png')}}" alt="" width="30%">
                </div>
                <a href="/terms" class="small mb-1">Syarat & Ketentuan</a><br>
                <a href="/privacy-policy" class="small mb-1">Kebijakan Privasi</a>
            </div>


        </div>
    </div>

    <div class="container copyright text-center mt-4">

        <p>© <span>Copyright</span> <strong class="px-1 sitename">akuanalis.com</strong> </p>

    </div>

</footer>

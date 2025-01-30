@extends('layout.layout')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-7 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h1 class="text-dark" data-aos="fade-up">Belajar menjadi analis lebih mudah bersama <span>AkuAnalis</span>
                        by Resi’s Project</h1>
                    <p data-aos="fade-up" data-aos-delay="100">Segera mulai perjalanan kimia anda bersama kami!</p>
                    <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
                        <a href="/kelas" class="btn-get-started">Belajar Sekarang <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                    <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

        <div class="container" data-aos="fade-up">
            <div class="row gx-0">

                <div class="col-lg-7 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="content">
                        <h2 class="text-center">Tentang Kami </h2>

                        <p class="text-center">
                            Kami berdedikasi untuk menyediakan media belajar kursus online Kimia Analisis yang berkualitas
                            dan mudah diakses, menawarkan pengalaman belajar yang komprehensif dan interaktif. Dengan
                            teknologi digital terkini, Anda akan mendapatkan materi pembelajaran yang dirancang oleh para
                            lulusan di bidang kimia, lengkap dengan fasilitas Virtual Lab secara real time untuk melakukan
                            eksperimen seolah-olah berada di laboratorium sungguhan. <br><br>

                            Kami juga menyediakan berbagai soal latihan dan studi kasus untuk menguji dan memperdalam
                            pemahaman Anda, serta wawasan tentang penerapan ilmu kimia dalam industri. Bersiaplah untuk
                            menghadapi tantangan di sektor kimia dengan percaya diri, menguasai pengetahuan akademis, dan
                            keterampilan praktis yang relevan. Mari bergabung dengan kami dan jadikan setiap pembelajaran
                            sebagai langkah menuju kesuksesan!
                        </p>
                    </div>
                </div>

                <div class="col-lg-5 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                    <img src="assets/img/about.png" class="img-fluid" alt="">
                </div>

            </div>
        </div>

    </section><!-- /About Section -->


    <!-- Alt Features Section -->
    <section id="alt-features" class="alt-features section">

        <div class="container">

            <div class="row gy-4">

                <h3 class="text-center">Kenapa harus kami?</h2>

                    <div class="col-xl-7 d-flex order-2 order-xl-1" data-aos="fade-up" data-aos-delay="200">

                        <div class="row align-self-center gy-5">

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-award"></i>
                                <div>
                                    <h4>Inovasi Terbaru</h4>

                                    <p>Virtual Lab real-time kami memungkinkan siswa untuk eksperimen praktis</p>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-mortarboard"></i>
                                <div>
                                    <h4>Pengajar Ahli</h4>
                                    <p>Lulusan kimia dan pengajar berpengalaman untuk merancang kurikulum yang terbaik</p>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-laptop"></i>
                                <div>
                                    <h4>Akses Kapanpun</h4>
                                    <p>Kemudahan akses materi dan pembelajaran yang sesuai dengan kebutuhan Kimia Analisis.
                                    </p>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-book-half"></i>
                                <div>
                                    <h4>Studi Kasus & Kuis</h4>
                                    <p>Kuis dan studi kasus terkait
                                        analisis kimia sesuai kebutuhan di dunia Industri</p>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-chat-right-text-fill"></i>
                                <div>
                                    <h4>Forum Diskusi</h4>
                                    <p>Mendukung komunitas belajar yang aktif dan bersemangat</p>
                                </div>
                            </div><!-- End Feature Item -->

                            <div class="col-md-6 icon-box">
                                <i class="bi bi-cash-coin"></i>
                                <div>
                                    <h4>Harga Terjangkau</h4>
                                    <p>Materi berstandar industri berkualitas tinggi dengan harga terjangkau</p>
                                </div>
                            </div><!-- End Feature Item -->

                        </div>

                    </div>

                    <div class="col-xl-5 d-flex align-items-center order-1 order-xl-2" data-aos="fade-up"
                        data-aos-delay="100">
                        <img src="assets/img/alt-features.png" class="img-fluid" alt="">
                    </div>

            </div>

        </div>

    </section><!-- /Alt Features Section -->

    <!-- Visi Misi Section -->
    <section id="visi" class="about section">

        <div class="container" data-aos="fade-up">
            <div class="row gx-0">

                <div class="col-lg-7 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="content">
                        <h2 class="text-center">Visi</h2>

                        <p class="text-center">
                            Menjadi pionir dalam transformasi pembelajaran Kimia Analisis melalui pengalaman belajar
                            interaktif dan aplikatif yang menggunakan teknologi terkini, mempersiapkan siswa untuk menjadi
                            profesional yang kompeten dan inovatif di industri kimia global.
                        </p>

                        <h2 class="text-center">Misi</h2>
                        <div class="d-flex align-items-center misi">
                            <h2 class="me-3">01</h2>
                            <p>Mengembangkan dan menyajikan kurikulum kimia analisis yang inovatif dan terkini untuk
                                memastikan pemahaman mendalam tentang analisis bahan kimia.</p>
                        </div>
                        <div class="d-flex align-items-center misi">
                            <h2 class="me-3">02</h2>
                            <p>Menyediakan platform pembelajaran interaktif yang memungkinkan siswa untuk melakukan
                                eksperimen praktis dan simulasi melalui penggunaan Virtual Lab real-time.</p>
                        </div>
                        <div class="d-flex align-items-center misi">
                            <h2 class="me-3">03</h2>
                            <p>Memberikan akses terbuka dan luas ke sumber belajar, termasuk soal latihan dan studi kasus
                                yang relevan dengan aplikasi industri kimia, untuk meningkatkan keterampilan dan persiapan
                                profesional siswa.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                    <img src="assets/img/features.png" class="img-fluid" alt="">
                </div>

            </div>
        </div>

    </section><!-- /Visi Misi Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Testimoni</h2>
            <p>Apa kata mereka tentang kami<br></p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="swiper init-swiper">
                <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": "auto",
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 1,
              "spaceBetween": 40
            },
            "1200": {
              "slidesPerView": 3,
              "spaceBetween": 1
            }
          }
        }
      </script>
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                Pembelajarannya menarik ditambah lagi ada tips cara jawab latihan soal dengan cepat, apalagi
                                praktikumnya menggunakan app simuasi yang keadaannya standar.Thanks ya ka.
                            </p>
                            <div class="profile mt-auto">
                                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img"
                                    alt="">
                                <h3>Dinda</h3>
                                <h4>Umum</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                kadimm enak mengajarnya, menjelaskan dengan detail terkait materi yang diajarkan, menerima
                                dan menjawab pertanyaan yang masih kita bingung/kurang paham jugaa
                            </p>
                            <div class="profile mt-auto">
                                <img src="assets/img/testimonials/elvira.jpg" class="testimonial-img"
                                    alt="">
                                <h3>Elvyra</h3>
                                <h4>Siswi di SMK Negeri 5 Kota Bekasi</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                Materi yang disajikan sangat mudah dipahami dan langsung dapat diaplikasikan dalam pekerjaan
                                sehari-hari saya sebagai ahli kimia. Terima kasih, AkuAnalis"
                            </p>
                            <div class="profile mt-auto">
                                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img"
                                    alt="">
                                <h3>Hadi</h3>
                                <h4>Umum</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="stars">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i>
                            </div>
                            <p>
                                Materi yang disajikan sangat mudah dipahami dan langsung dapat diaplikasikan dalam pekerjaan
                                sehari-hari saya sebagai ahli kimia. Terima kasih, AkuAnalis"
                            </p>
                            <div class="profile mt-auto">
                                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img"
                                    alt="">
                                <h3>Azizah</h3>
                                <h4>Umum</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section><!-- /Testimonials Section -->

    <!-- Faq Section -->
    <section id="faq" class="faq section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>F A Q</h2>
            <p>Yang sering ditanyakan</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row">

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">

                    <div class="faq-container">

                        <div class="faq-item faq-active">
                            <h3>Apa itu AkuAnalis?</h3>
                            <div class="faq-content">
                                <p>Selamat datang di AkuAnalis by Resi's Project!
                                    Kami adalah media
                                    yang menyediakan Online Course dengan fokus di bidang Kimia
                                    Analisis serta dapat diakses dengan mudah oleh siswa/i. Yuk segera daftarkan diri kalian
                                    dan nikmati fitur yang kami sediakan!
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Siapa yang yang menjadi pengajar atau tutor di AkuAnalis ini?</h3>
                            <div class="faq-content">
                                <p>Pengajar yang kami miliki adalah para lulusan Kimia/Analis Kimia yang memiliki pengalaman
                                    keterampilan langsung di laboratorium dari berbagai sektor industry sehingga ilmu teori
                                    dan praktikum kami nantinya sudah sesuai dengan laboratorium nyata.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Di mana saya bisa mengakses kursus-kursus di AkuAnalis?</h3>
                            <div class="faq-content">
                                <p>Saat ini kalian bisa akses dimana pun dan kapan pun melalui Website resmi kami di
                                    akuanalis.com. Yuk segera daftarkan diri kalian dan nikmati fitur yang kami sediakan!
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                    </div>

                </div><!-- End Faq Column-->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">

                    <div class="faq-container">

                        <div class="faq-item">
                            <h3>Kapan kursus-kursus tersedia?</h3>
                            <div class="faq-content">
                                <p>Kursus kami tersedia ketika siswa/i telah berhasil daftar/registrasi pembuatan akun, Dan
                                    sesuaikan dengan kebutuhan belajar yang ingin kalian pelajari sesuai dengan minat.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Mengapa memilih AkuAnalis untuk belajar kimia analisis?</h3>
                            <div class="faq-content">
                                <p>Materi dan praktikum kami telah dirancang oleh para lulusan Kimia/Analis Kimia di
                                    bidangnya sehingga sudah sesuai dengan kebutuhan nyata di laboratorium. Dengan fitur
                                    keunggulan kami yaitu: Kemudahan Akses Materi, Pengajaran Virtual Lab, Soal Latihan dan
                                    Studi Kasus.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Bagaimana cara mendaftar untuk kursus di AkuAnalis ?</h3>
                            <div class="faq-content">
                                <p>Klik menu Login, kemudian klik Daftar/Sign In, lihat notifikasi di email yang kalian
                                    daftarkan, lakukan aktivasi akun, dan selamat akun kalian telah berhasil dibuat! Lakukan
                                    Login untuk melihat kelas kursus yang telah kami sediakan.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                    </div>

                </div><!-- End Faq Column-->

            </div>

        </div>

    </section><!-- /Faq Section -->

    <div class="bg-light mt-5 py-5">
        <div class="container py-2">
            <div class="row justify-content-center text-center">
                <div class="col-lg-7 ">
                    <h4 class="text-dark" data-aos="fade-up">Tunggu apalagi ? Yuk belajar di <span
                            class="">AkuAnalis</span></h1>
                        <div class="d-flex justify-content-center mt-2" data-aos="fade-up" data-aos-delay="200">
                            <a href="/kelas" class="btn-get-started text-center">Belajar Sekarang <i
                                    class="bi bi-arrow-right"></i></a>
                        </div>
                </div>
            </div>
        </div>
    @endsection

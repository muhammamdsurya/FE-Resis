@extends('layout.layout')

@section('content')
    <section id="detail-kelas" class="hero section">
        <div class="container my-5">

            <div class="row gy-4 g-4">
                <div class="col-lg-9 col-md-8 d-flex order-2 order-xl-1" data-aos="fade-up" data-aos-delay="200">

                    <div class="container">
                        <div class="row align-self-center align-items-center gy-5">

                            <div class="col-lg-5">
                                <img src="{{asset('assets/img/values-1.png')}}" alt="" width="100%" >
                            </div><!-- End Feature Item -->

                            <div class="col-lg-7">
                                <div>
                                    <h4>{{$course->course->name}}</h4>
                                    <div class="header-card d-flex justify-content-between">
                                        <p class="mr-auto fs-6"><i class="bi bi-star-fill text-warning me-1"></i>{{$course->course->rating}}</p>
                                        <p class="ml-auto fs-6">Jenjang : '{{$course->course_category->name}}'</p>
                                    </div>
                                    <p>100 Siswa Terdaftar</p>
                                    <p> {{$course->course->description}}
                                    </p>
                                </div>
                            </div><!-- End Feature Item -->
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 d-flex align-items-center order-2" data-aos="fade-up"
                    data-aos-delay="100">
                    <div class="card text-bg-light shadow" style="width: 100%;">
                        <div class="card-body mx-auto d-flex flex-column align-items-center">
                            <h5 class="card-title">Rp. {{$course->course->price}}</h5>
                            <button id="checkoutBtn" class="btn btn-success">Belajar Sekarang</button>
                        </div>
                        <hr class="border border-dark border-1 opacity-20">
                        <div class="card-body mx-auto d-grid flex-column align-items-center">
                            <a href="#informasi-kelas" class="btn btn-primary mb-2">Informasi Kelas</a>
                            <a href="#silabus-kelas" class="btn btn-primary">Lihat Silabus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- Deskrpsi Kelas --}}
    <section id="informasi-kelas" class="section">
        <div class="container shadow p-3">
            <div class="row">
                <div class="col-lg-7">
                    <div class="container mb-3">
                        <h4>Deskripsi</h4>
<<<<<<< HEAD
                        <p>{{$courses['course']['description']}}
=======
                        <p>{{$course->course->description}}
>>>>>>> edca9f6bbbe5ab45cd2664448047acf904ba4bbc
                        </p>
                    </div>
                    <div class="container mb-3">
                        <h4>Tujuan</h4>
<<<<<<< HEAD
                        <p>{{$courses['course']['purpose']}}
=======
                        <p>{{$course->course->purpose}}
>>>>>>> edca9f6bbbe5ab45cd2664448047acf904ba4bbc
                        </p>
                    </div>
                    <div class="container mb-3">
                        <h4>Pengajar</h4>
                        <div class="d-flex my-3 align-items-center gap-3">
                            <img src="assets/img/values-1.png" alt="" width="100rem">
                            <div class="container">
<<<<<<< HEAD
                                <h6>{{$courses['instructor']['full_name']}}</h6>
                                <p>{{$courses['instructor']['instructor']['education']}}</p>
                                <p>{{$courses['instructor']['instructor']['experience']}}</p>
=======
                                <h6>{{$course->instructor->full_name}}</h6>
                                <p>{{$course->instructor->instructor->education}}</p>
                                <p>Tutor Online</p>
>>>>>>> edca9f6bbbe5ab45cd2664448047acf904ba4bbc
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="container">
                        <h4>Metode Ajar</h4>
                        <p>Online - Self-paced Learning</p>
                        <ul>
                            <li>tentukan sendiri berapa lama waktu yang akan digunakan untuk belajar materi kelas ini
                                selama
                                masih aktif terdaftar pada kelas</li>
                        </ul>
                        <p>Fasilitas Pengajar</p>
                        <ul>
                            <li>Video Pembelajaran</li>
                            <li>Modul Online</li>
                            <li>Kuis Interaktif</li>
                            <li>Forum Diskusi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Faq Section -->
    <section id="silabus-kelas" class="faq section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <p>Silabus</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row">

                <div class="col-lg-8 mx-auto" data-aos="fade-up" data-aos-delay="100">

                    <div class="faq-container">

                        <div class="faq-item faq-active">
                            <h3>Apa itu AkuAnalis?</h3>
                            <div class="faq-content">
                                <p>Selamat datang di AkuAnalis by Resi's Project!
                                    Kami adalah media belajar yang menyediakan Online Course dengan fokus di bidang Kimia Analisis serta dapat diakses dengan mudah oleh siswa/i.  Yuk segera daftarkan diri kalian dan nikmati fitur yang kami sediakan!
                                    </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Siapa yang yang menjadi pengajar atau tutor di AkuAnalis ini?</h3>
                            <div class="faq-content">
                                <p>Pengajar yang kami miliki adalah para lulusan Kimia/Analis Kimia yang memiliki pengalaman keterampilan langsung di laboratorium dari berbagai sektor industry sehingga ilmu teori dan praktikum kami nantinya sudah sesuai dengan laboratorium nyata.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Di mana saya bisa mengakses kursus-kursus di AkuAnalis?</h3>
                            <div class="faq-content">
                                <p>Saat ini kalian bisa akses dimana pun dan kapan pun melalui Website resmi kami di akuanalis.com. Yuk segera daftarkan diri kalian dan nikmati fitur yang kami sediakan!
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                    </div>

                </div><!-- End Faq Column-->

            </div>

        </div>

    </section><!-- /Faq Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <p>Testimoni Kelas</p>
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
                                Pembelajarannya menarik ditambah lagi ada tips cara jawab latihan soal dengan cepat, apalagi praktikumnya menggunakan app simuasi yang keadaannya standar.Thanks ya ka.
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
                                kadimm enak mengajarnya, menjelaskan dengan detail terkait materi yang diajarkan, menerima dan menjawab pertanyaan yang masih kita bingung/kurang paham jugaa
                            </p>
                            <div class="profile mt-auto">
                                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img"
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
                                Materi yang disajikan sangat mudah dipahami dan langsung dapat diaplikasikan dalam pekerjaan sehari-hari saya sebagai ahli kimia. Terima kasih, Akuanalis.com!"
                            </p>
                            <div class="profile mt-auto">
                                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img"
                                    alt="">
                                <h3>Azizah</h3>
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
                                Materi yang disajikan sangat mudah dipahami dan langsung dapat diaplikasikan dalam pekerjaan sehari-hari saya sebagai ahli kimia. Terima kasih, Akuanalis.com!"
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if($isLogin == 'y')
    <script type="text/javascript"
		src="https://app.sandbox.midtrans.com/snap/snap.js"></script>
    @endif
    <script>

         $('#checkoutBtn').on('click', function(event) {
            event.preventDefault();


            if('{{$isLogin}}' == 'y'){

                $.ajax({
                url: '{{ route("user.checkout") }}', // Direct API endpoint
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                data: JSON.stringify({
                    courseId: '{{$course->course->id}}'
                }),
                success: function(response) {

                    // Swal.fire('Berhasil', response.data.message, 'success');
                    if(response.data.midtrans_snap_token){
                        const midTransSnap = new MidTransSnap(response.data.midtrans_snap_token);
                        midTransSnap.pay();
                    }

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Log the error for debugging
                    console.error('Response Text:', xhr.responseText);
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
                });

            }else{
                document.location.href = '/login'
            }
         })
    </script>



@endsection

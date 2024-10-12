@extends('layout.layout')

@section('content')
    <style>
        .section {
            background-color: #f9f9f9;
        }

        h4.fw-bold {
            color: #333;
            font-weight: bold;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .list-unstyled li {
            margin-bottom: 10px;
        }

        .rounded-circle {
            border-radius: 50%;
        }

        .badge.bg-primary {
            background-color: #007bff;
            font-size: 0.9rem;
            padding: 0.5em 0.75em;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        #checkoutBtn {
            transition: background-color 0.3s ease;
        }

        #checkoutBtn:hover {
            background-color: #28a745;
        }

        .section-title h2 {
            font-size: 1rem;
            color: #343a40;
            /* Darker color for title */
        }

        .section-title p {
            font-size: 1rem;
            color: #6c757d;
            /* Muted color for subtitle */
        }
    </style>
    <section id="detail-kelas" class="hero section py-5" style="background-color: #f9f9f9;">
        <div class="container my-5">

            <div class="row gy-4 g-4">
                <!-- Left Content: Course Info -->
                <div class="col-lg-9 col-md-8 order-2 order-xl-1" data-aos="fade-up" data-aos-delay="200">

                    <div class="container bg-white p-4 shadow rounded" style="border-radius: 15px;">
                        <div class="row align-items-center gy-5">

                            <div class="col-lg-5">
                                <img src="{{ $course->course->thumbnail_image }} " alt="{{ $course->course->name }}"
                                    class="img-fluid rounded" class="card-img-top rounded"
                                    style="height: 300px; object-fit: cover;">
                            </div><!-- End Image -->

                            <div class="col-lg-7">
                                <div>
                                    <h4 class="fw-bold text-dark">{{ $course->course->name }}</h4>
                                    <div class="header-card d-flex justify-content-between my-3">
                                        <p class="text-muted mb-0 fs-6"><i
                                                class="bi bi-star-fill text-warning me-1"></i>{{ $course->course->rating }}
                                        </p>
                                        <p class="badge bg-primary text-white fs-6 mb-0">
                                            {{ $course->course_category->name }}
                                        </p>
                                    </div>
                                    <p class="text-muted">{{ $course->course->description }}</p>
                                </div>
                            </div><!-- End Text -->
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Pricing and Buttons -->
                <div class="col-lg-3 col-md-4 order-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="card text-bg-light shadow-lg border-0 rounded" style="border-radius: 15px;">
                        <div class="card-body text-center py-4">
                            <h5 class="card-title text-success fw-bold fs-3">Rp.
                                {{ number_format($course->course->price, 0, ',', '.') }}</h5>
                                @if ($role == 'admin')
                                <a href="{{ route('detail-kelas', ['id' => $course->course->id]) }}"  class="btn btn-success btn-lg mt-3 px-4">Edit kelas</a>
                                @elseif ( $role == 'instructor')
                                <a href="{{ route('instructor.detail-kelas', ['id' => $course->course->id]) }}"  class="btn btn-success btn-lg mt-3 px-4">Lihat kelas</a>
                                @else
                                <button id="checkoutBtn" class="btn btn-success btn-lg mt-3 px-4">Belajar Sekarang</button>

                                @endif
                        </div>
                        <hr class="border border-dark border-1 opacity-20 mx-4">
                        <div class="card-body d-grid gap-2 py-3 px-4">
                            <a href="#informasi-kelas" class="btn btn-outline-primary btn-lg mb-2">Informasi Kelas</a>
                            <a href="#silabus-kelas" class="btn btn-outline-primary btn-lg">Lihat Silabus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Deskripsi Kelas -->
    <section id="informasi-kelas" class="section">
        <div class="container shadow p-4 rounded bg-white">
            <div class="row">
                <!-- Left Column: Deskripsi, Tujuan, Pengajar -->
                <div class="col-lg-7">
                    <!-- Deskripsi -->
                    <div class="mb-5">
                        <h4 class="fw-bold mb-3">Deskripsi</h4>
                        <p class="text-muted">{{ $course->course->description }}</p>
                    </div>

                    <!-- Tujuan -->
                    <div class="mb-5">
                        <h4 class="fw-bold mb-3">Tujuan</h4>
                        <p class="text-muted">{{ $course->course->purpose }}</p>
                    </div>

                    <!-- Pengajar -->
                    <div class="mb-5">
                        <h4 class="fw-bold mb-3">Pengajar</h4>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $course->instructor->photo_profile }}" alt="Instructor"
                                class="rounded-circle" width="100rem">
                            <div>
                                <h6 class="fw-bold">{{ $course->instructor->full_name }}</h6>
                                <p class="text-muted">{{ $course->instructor->instructor->education }}</p>
                                <span class="badge bg-primary">Tutor Online</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Metode Ajar, Fasilitas Pengajar -->
                <div class="col-lg-5">
                    <div>
                        <!-- Metode Ajar -->
                        <h4 class="fw-bold mb-3">Metode Ajar</h4>
                        <p class="text-muted">Online - Self-paced Learning</p>
                        <ul class="list-unstyled text-muted">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Tentukan sendiri waktu belajar
                                selama masih aktif terdaftar</li>
                        </ul>

                        <!-- Fasilitas Pengajar -->
                        <h4 class="fw-bold mt-4 mb-3">Fasilitas Pengajar</h4>
                        <ul class="list-unstyled text-muted">
                            <li><i class="bi bi-play-circle-fill text-success me-2"></i> Video Pembelajaran</li>
                            <li><i class="bi bi-file-earmark-text-fill text-success me-2"></i> Modul Online</li>
                            <li><i class="bi bi-question-circle-fill text-success me-2"></i> Kuis Interaktif</li>
                            <li><i class="bi bi-chat-left-dots-fill text-success me-2"></i> Forum Diskusi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Faq Section -->
    <section id="silabus-kelas" class="faq section">

        <!-- Section Title -->
        <div class="container section-title text-center" data-aos="fade-up">
            <h2 class="fw-bold">Silabus</h2>
            <p class="text-muted">Materi yang akan kamu pelajari</p>
        </div>
        <!-- End Section Title -->

        <div class="container">

            <div class="row">

                <div class="col-lg-8 mx-auto" data-aos="fade-up" data-aos-delay="100">

                    <div class="faq-container">
                        @if ($content)
                            @foreach ($content as $row)
                                <div class="faq-item">
                                    <h3>{{ $row->content_title }}</h3>

                                    <div class="faq-content">
                                        <p>{{!! $row->content_description !!}}</p>

                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div><!-- End Faq item-->
                            @endforeach
                        @else
                            <p>Belum Ada Konten </p>
                        @endif

                    </div>

                </div><!-- End Faq Column-->

            </div>

        </div>

    </section><!-- /Faq Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2 class="fw-bold">Testimoni</h2>
            <p class="text-muted">Pengalaman dari mereka tentang kelas ini</p>
        </div>
        <!-- End Section Title -->

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
                                <img src="{{ asset('assets/img/testimonials/testimonials-4.jpg') }}"
                                    class="testimonial-img" alt="">
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
                                <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}"
                                    class="testimonial-img" alt="">
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
                                sehari-hari saya sebagai ahli kimia. Terima kasih, Akuanalis.com!"
                            </p>
                            <div class="profile mt-auto">
                                <img src="{{ asset('assets/img/testimonials/testimonials-2.jpg') }}"
                                    class="testimonial-img" alt="">
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
                                Materi yang disajikan sangat mudah dipahami dan langsung dapat diaplikasikan dalam pekerjaan
                                sehari-hari saya sebagai ahli kimia. Terima kasih, Akuanalis.com!"
                            </p>
                            <div class="profile mt-auto">
                                <img src="{{ asset('assets/img/testimonials/testimonials-3.jpg') }}"
                                    class="testimonial-img" alt="">
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
    @if ($isLogin == 'y')
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"></script>
    @endif
    <script>
        $('#checkoutBtn').on('click', function(event) {
            event.preventDefault();


            if ('{{ $isLogin }}' == 'y') {

                if('{{$alreadyCourse}}' == 'y'){
                    window.location.href='/user/detail-kelas/{{ $course->course->id }}'
                }else{
                    createOverlay("Proses Membeli Kelas...");
                    $.ajax({
                        url: '{{ route('user.checkout') }}', // Direct API endpoint
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        data: JSON.stringify({
                            courseId: '{{ $course->course->id }}'
                        }),
                        success: function(response) {

                            // Swal.fire('Berhasil', response.data.message, 'success');
                            gOverlay.hide()
                            if (response.data.midtrans_snap_token) {
                                const midTransSnap = new MidTransSnap(response.data.midtrans_snap_token);
                                midTransSnap.pay();
                            }

                        },
                        error: function(xhr, status, error) {
                            gOverlay.hide()
                            console.error('Error:', error); // Log the error for debugging
                            console.error('Response Text:', xhr.responseText);
                            Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                        }
                    });
                }


            } else {
                document.location.href = '/login'
            }
        })
    </script>
@endsection

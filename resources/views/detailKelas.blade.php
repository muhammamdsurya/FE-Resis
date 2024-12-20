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

        .rating-box {
            background-color: #ffffff;
            /* Warna latar belakang kotak rating */
            border: 1px solid #dee2e6;
            /* Border kotak */
            transition: transform 0.2s;
            /* Animasi saat hover */
        }

        .rating-box:hover {
            transform: translateY(-5px);
            /* Mengangkat kotak saat hover */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            /* Bayangan saat hover */
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
                                    <p class="text-muted">{{ Str::limit($course->course->description, 200) }}</p>
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
                                <a href="{{ route('detail-kelas', ['id' => $course->course->id]) }}"
                                    class="btn btn-success btn-lg mt-3 px-4">Edit kelas</a>
                            @elseif ($role == 'instructor')
                                <a href="{{ route('instructor.detail-kelas', ['id' => $course->course->id]) }}"
                                    class="btn btn-success btn-lg mt-3 px-4">Lihat kelas</a>
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
                                class="rounded-circle shadow-sm" width="100rem">
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
                                        <p>{{ $row->content_description }}</p>
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
        <div class="container">
            @if ($ratings->data != null)
                @foreach ($ratings->data as $row)
                    <div class="rating-box shad rounded p-3 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-0">{{ $row->student_name }}</h5>
                                <p class="mb-0 text-muted">{{ $row->description }} stars</p>
                            </div>
                            <div class="rating-stars fs-3">
                                @for ($i = 1; $i <= $row->rating; $i++)
                                    <i class="bi bi-star-fill text-warning me-1 star-hover"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Belum ada rating</p>
            @endif

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <!-- Previous Button -->
                    @if ($ratings->pagination->page > 1)
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ route('detail.kelas', ['page' => $ratings->pagination->page - 1]) }}">Previous</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>
                    @endif

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $ratings->pagination->total_page; $i++)
                        <li class="page-item {{ $ratings->pagination->page === $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ route('detail.kelas', ['courseId' => $course->course->id, 'page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Button -->
                    @if ($ratings->pagination->page < $ratings->pagination->total_page)
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ route('detail.kelas', ['courseId' => $course->course->id, 'page' => $ratings->pagination->page + 1]) }}">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link">Next</a>
                        </li>
                    @endif
                </ul>
            </nav>

        </div>


    </section><!-- /Testimonials Section -->


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if ($isLogin == 'y')
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"></script>
    @endif
    <script>
        $(document).ready(function() {

            // Function to generate stars based on rating value
            function generateStars(rating) {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= rating) {
                        stars += '<i class="fas fa-star"></i>';
                    } else {
                        stars += '<i class="far fa-star"></i>';
                    }
                }
                return stars;
            }
        });
        $('#checkoutBtn').on('click', function(event) {
            event.preventDefault();


            if ('{{ $isLogin }}' == 'y') {

                if ('{{ $alreadyCourse }}' == 'y') {
                    window.location.href = '/user/detail-kelas/{{ $course->course->id }}'
                } else {
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
                                const midTransSnap = new MidTransSnap(response.data
                                    .midtrans_snap_token);
                                midTransSnap.pay();
                            }

                        },
                        error: function(xhr, status, error) {
                            gOverlay.hide()
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

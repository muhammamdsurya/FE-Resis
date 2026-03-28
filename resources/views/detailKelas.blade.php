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

        /* Menghilangkan border default accordion yang kaku */
    .accordion-item {
        border-color: #f1f1f1 !important;
    }

    /* Efek saat tombol diklik */
    .accordion-button:not(.collapsed) {
        background-color: #f8f9ff !important;
        color: #0d6efd !important;
        box-shadow: none !important;
    }

    .accordion-button:focus {
        box-shadow: none !important;
        border-color: rgba(0,0,0,.125);
    }

    /* Badge nomor urut */
    .bg-primary-subtle {
        background-color: #e7f1ff;
    }

    /* Animasi icon rotasi */
    .accordion-button::after {
        background-size: 1.25rem;
        transition: transform 0.3s ease;
    }
    </style>
    <section id="detail-kelas" class="hero section py-5" style="background: linear-gradient(to bottom, #f4f7fe, #ffffff);">
    <div class="container py-4">
        <div class="row gy-4">

            <div class="col-lg-8" data-aos="fade-up">
                <div class="card border-0 shadow-sm p-3" style="border-radius: 20px;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-5 mb-3 mb-md-0">
                                <div class="position-relative">
                                    <img src="{{ $course->course->thumbnail_image }}"
                                         alt="{{ $course->course->name }}"
                                         class="img-fluid rounded-4 shadow-sm"
                                         style="width: 100%; height: 250px; object-fit: cover;">
                                    <span class="position-absolute top-0 start-0 m-3 badge rounded-pill bg-white text-primary fw-bold shadow-sm px-3 py-2">
                                        <i class="bi bi-tag-fill me-1"></i> {{ $course->course_category->name }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <h2 class="fw-bold text-dark mb-2">{{ $course->course->name }}</h2>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="text-warning me-2">
                                        @for($i=0; $i<5; $i++)
                                            <i class="bi bi-star-fill small"></i>
                                        @endfor
                                    </div>
                                    <span class="text-muted fw-semibold small">({{ $course->course->rating }} Rating)</span>
                                </div>
                                <p class="text-secondary lh-base" style="font-size: 0.95rem;">
                                    {{ $course->course->description }}
                                </p>
                                <hr class="opacity-10">
                                <div class="d-flex gap-3 text-muted small align-items-center">
    <span class="d-flex align-items-center">
        <i class="bi bi-play-circle-fill text-primary me-2"></i>
        <strong>{{ count($content) }}</strong> &nbsp;Materi
    </span>
</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-lg sticky-top" style="border-radius: 20px; top: 100px; z-index: 10;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h3 class="fw-extrabold text-success mb-0" style="font-size: 2.2rem;">
                                Rp {{ number_format($course->course->price, 0, ',', '.') }}
                            </h3>
                        </div>

                        <div class="d-grid gap-3">
                            @if ($role == 'admin')
                                <a href="{{ route('detail-kelas', ['id' => $course->course->id]) }}" class="btn btn-warning btn-lg fw-bold rounded-pill py-3">
                                    <i class="bi bi-pencil-square me-2"></i> Edit Kelas
                                </a>
                            @elseif ($role == 'instructor')
                                <a href="{{ route('instructor.detail-kelas', ['id' => $course->course->id]) }}" class="btn btn-primary btn-lg fw-bold rounded-pill py-3">
                                    Lihat Pratinjau
                                </a>
                            @else
                                <button id="checkoutBtn" class="btn btn-success btn-lg fw-bold rounded-pill py-3 shadow">
                                    Belajar Sekarang
                                </button>
                            @endif

                            <div class="mt-2">
                                <a href="#silabus-kelas" class="btn btn-primary w-100 rounded-pill py-2 text-light fw-semibold mb-2">
                                    <i class="bi bi-list-ul me-2"></i> Lihat Silabus
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="bg-light p-3 text-center rounded-bottom-4 border-top">
                        <small class="text-muted"><i class="bi bi-shield-check me-1"></i>Diskusi langsung dengan ahli</small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

    <!-- Deskripsi Kelas -->
  <section id="informasi-kelas" class="section py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="mb-5" data-aos="fade-up">
                    <h4 class="fw-bold mb-3 d-flex align-items-center">
                        <span class="badge bg-primary me-2" style="width: 10px; height: 25px; border-radius: 5px;"></span>
                        Tentang Kelas
                    </h4>
                    <p class="text-secondary leading-relaxed">{{ $course->course->description }}</p>

                    <h5 class="text-dark fw-bold mt-4 mb-3">Apa yang akan kamu pelajari?</h5>
                    <p class="text-secondary">{{ $course->course->purpose }}</p>
                </div>

                <div class="p-4 rounded-4 border-0 shadow-sm bg-white" data-aos="fade-up">
                    <h4 class="fw-bold mb-4">Instruktur Ahli</h4>
                    <div class="d-flex align-items-center gap-4">
                        <div class="position-relative">
                            <img src="{{ $course->instructor->photo_profile }}" alt="Instructor"
                                 class="rounded-circle border border-4 border-light shadow-sm"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            <div class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" style="width: 18px; height: 18px;"></div>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $course->instructor->full_name }}</h5>
                            <p class="mb-2 small fw-semibold">{{ $course->instructor->instructor->education }}</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-light text-primary px-3 py-2 rounded-pill">Top Rated Tutor</span>
                                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">Industry Expert</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="sticky-top" style="top: 100px; z-index: 10;">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4 bg-white">
                            <div class="mb-4">
                                <h6 class="fw-bold text-uppercase small text-muted mb-3" style="letter-spacing: 1px;">Metode Belajar</h6>
                                <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light">
                                    <i class="bi bi-clock-history fs-3 text-primary"></i>
                                    <div>
                                        <p class="fw-bold mb-0">Self-paced Learning</p>
                                        <small class="text-muted">Tentukan waktu belajarmu sendiri secara fleksibel.</small>
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold text-uppercase small text-muted mb-3" style="letter-spacing: 1px;">Fasilitas Kelas</h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="p-3 border rounded-3 text-center h-100">
                                        <i class="bi bi-play-btn fs-3 text-danger d-block mb-2"></i>
                                        <span class="small fw-bold">Video Materi</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 border rounded-3 text-center h-100">
                                        <i class="bi bi-file-earmark-pdf fs-3 text-info d-block mb-2"></i>
                                        <span class="small fw-bold">E-Book</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 border rounded-3 text-center h-100">
                                        <i class="bi bi-patch-check fs-3 text-success d-block mb-2"></i>
                                        <span class="small fw-bold">Diskusi dengan ahli</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 border rounded-3 text-center h-100">
                                        <i class="bi bi-chat-dots fs-3 text-warning d-block mb-2"></i>
                                        <span class="small fw-bold">Konsultasi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Faq Section -->
   <section id="silabus-kelas" class="section py-5 bg-light">
    <div class="container section-title text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold">Silabus Kelas</h2>
        <p class="text-muted">Langkah demi langkah menjadi ahli di bidang ini</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto" data-aos="fade-up" data-aos-delay="100">
                <div class="accordion accordion-flush shadow-sm rounded-4 overflow-hidden" id="syllabusAccordion">

                    @if ($content && count($content) > 0)
                        @foreach ($content as $index => $row)
                            <div class="accordion-item border-bottom">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }} py-4 px-4"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#content-{{ $index }}">

                                        <div class="d-flex align-items-center w-100">
                                            <span class="badge rounded-pill bg-primary-subtle text-primary me-3 px-3 py-2">
                                                {{ $index + 1 }}
                                            </span>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-bold mb-0 text-dark">{{ $row->content_title }}</h6>
                                            </div>
                                        </div>
                                    </button>
                                </h2>

                                <div id="content-{{ $index }}"
                                     class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                     data-bs-parent="#syllabusAccordion">
                                    <div class="accordion-body py-4 px-5 text-secondary" style="line-height: 1.8; background-color: #fcfcfc;">
                                        <p class="mb-0">{{ $row->content_description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center p-5 bg-white rounded-4 shadow-sm">
                            <i class="bi bi-journal-x fs-1 text-muted d-block mb-3"></i>
                            <h5 class="text-muted">Belum ada konten silabus tersedia.</h5>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section><!-- /Faq Section -->

    <section id="testimonials" class="testimonials section py-5 bg-white">
    <div class="container section-title text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold">Apa Kata Alumni?</h2>
        <p class="text-muted">Mereka telah meningkatkan skillnya di kelas ini</p>
    </div>

    <div class="container">
        @if ($ratings->data != null)
            <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
                @foreach ($ratings->data as $row)
                    <div class="col" data-aos="fade-up">
                        <div class="card h-100 border-0 shadow-sm p-4 rounded-4 bg-light">
                            <div class="card-body">
                                <div class="mb-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star-fill {{ $i <= $row->rating ? 'text-warning' : 'text-secondary opacity-25' }} small"></i>
                                    @endfor
                                </div>

                              <p class="text-dark italic mb-4" style="font-style: italic;">
    @if($row->description)
        "{{ Str::limit($row->description, 150) }}"
    @endif
</p>

                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold rounded-circle" style="width: 45px; height: 45px; font-size: 0.9rem;">
                                        {{ strtoupper(substr($row->student_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">{{ $row->student_name }}</h6>
                                        <small class="text-muted" style="font-size: 0.8rem;">Alumni Siswa</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-chat-left-dots fs-1 text-muted opacity-25"></i>
                <p class="text-muted mt-3">Belum ada ulasan untuk kelas ini.</p>
            </div>
        @endif

        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination pagination-sm justify-content-center custom-pagination">
                {{-- Previous --}}
                <li class="page-item {{ $ratings->pagination->page <= 1 ? 'disabled' : '' }}">
                    <a class="page-link rounded-circle mx-1" href="{{ $ratings->pagination->page > 1 ? route('detail.kelas', ['courseId' => $course->course->id, 'page' => $ratings->pagination->page - 1]) : '#' }}">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>

                {{-- Numbers --}}
                @for ($i = 1; $i <= $ratings->pagination->total_page; $i++)
                    <li class="page-item {{ $ratings->pagination->page === $i ? 'active' : '' }}">
                        <a class="page-link rounded-circle mx-1" href="{{ route('detail.kelas', ['courseId' => $course->course->id, 'page' => $i]) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Next --}}
                <li class="page-item {{ $ratings->pagination->page >= $ratings->pagination->total_page ? 'disabled' : '' }}">
                    <a class="page-link rounded-circle mx-1" href="{{ $ratings->pagination->page < $ratings->pagination->total_page ? route('detail.kelas', ['courseId' => $course->course->id, 'page' => $ratings->pagination->page + 1]) : '#' }}">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if ($isLogin == 'y')
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('CLIENT_KEY') }}"></script>
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
                            console.log(response);
                            gOverlay.hide();

                            const token = response.data.midtrans_snap_token;

                            if (token && token !== "") {
                                // Kalau token ada → jalankan Snap
                                snap.pay(token, {
                                    onSuccess: function(result) {
                                        console.log("Pembayaran sukses:", result);
                                    },
                                    onPending: function(result) {
                                        console.log("Menunggu pembayaran:", result);
                                    },
                                    onError: function(result) {
                                        console.log("Pembayaran gagal:", result);
                                    },
                                    onClose: function() {
                                        console.log(
                                            "Popup ditutup tanpa menyelesaikan pembayaran"
                                            );
                                    }
                                });
                            } else {
                                // Kalau token kosong → tampilkan Swal berhasil
                                Swal.fire('Berhasil', response.message || 'Invoice berhasil dibuat',
                                    'success');
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

@php
    if ($course) {
        // Gunakan null coalescing untuk menghindari kesalahan count()
        $courseContents = $courseContents ?? []; // Pastikan ini adalah array

        // Count total classes and completed ones
        $totalClasses = count($courseContents);
        $completedClasses = 0;

        foreach ($courseContents as $courseContentSidebar) {
            if ($courseContentSidebar->is_completed) {
                $completedClasses++;
            }
        }

        $completionPercentage = $totalClasses > 0 ? floor(($completedClasses / $totalClasses) * 100) : 0; // Use floor or round as needed
    } else {
        $totalClasses = 0;
        $completedClasses = 0; // Pastikan ini didefinisikan meskipun $course tidak ada
        $completionPercentage = 0; // Pastikan ini didefinisikan meskipun $course tidak ada
    }
@endphp

@extends('layout.userLayout')
@section('title', isset($courseContent) ? $courseContent->content_title : $title)


@section('filter')
    <!-- Filter Dropdown for Course Content -->
    <div class="filter-dropdown d-md-none d-sm-block ms-md-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                Materi
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @if (isset($courseContents))
                    @foreach ($courseContents as $courseContentSidebar)
                        <li>
                            <a href="?selectedCourseContentId={{ $courseContentSidebar->content_id }}"
                                class="dropdown-item {{ $selectedCourseContentId == $courseContentSidebar->content_id ? 'active' : '' }}"
                                {{ $courseContentSidebar->is_completed == false ? ($selectedCourseContentId == $courseContentSidebar->content_id ? '' : 'disabled') : '' }}>
                                {{ $courseContentSidebar->courseDetail->content_title }}
                            </a>
                        </li>
                    @endforeach
                @endif
                <li><a href="/user/diskusi-kelas/{{ $course->course->id }}" class="dropdown-item">Diskusi</a></li>

                <!-- Tambahan Lihat Ulasan -->
                <li>
                    @if (isset($userRate))
                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reviewModal"
                            disabled>
                            Lihat Ulasan
                        </a>
                    @else
                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reviewModal"
                            disabled>
                            Tambah Ulasan
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    <!-- Modal untuk Lihat dan Tambah Ulasan -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">
                        @if (isset($userRate) && $userRate != null)
                            Lihat Ulasan
                        @else
                            Tambah Ulasan
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (isset($userRate) && $userRate != null)
                        <!-- Tampilkan ulasan jika sudah ada -->
                        <div class="review-content">
                            <p><strong>Ulasan:</strong></p>
                            <p>{{ $userRate->description }}</p>
                            <div class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $userRate->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    @else
                        <!-- Form untuk ulasan dan rating -->
                        <div class="form-floating mt-2 mb-1">
                            <textarea class="form-control" id="descRateMobile" placeholder="Tulis ulasan Anda di sini..." rows="4"></textarea>
                            <label for="descRateMobile">Ulasan</label>
                        </div>
                        <div class="rating text-center">
                            <input type="radio" id="star5Mobile" name="ratingMobile" value="5">
                            <label for="star5Mobile" title="5 star"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star4Mobile" name="ratingMobile" value="4">
                            <label for="star4Mobile" title="4 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star3Mobile" name="ratingMobile" value="3">
                            <label for="star3Mobile" title="3 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star2Mobile" name="ratingMobile" value="2">
                            <label for="star2Mobile" title="2 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star1Mobile" name="ratingMobile" value="1">
                            <label for="star1Mobile" title="1 star"><i class="fas fa-star"></i></label>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if (!isset($userRate) || $userRate == null)
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary">Kirim Ulasan</button>
                    @else
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection


@section('content')

    <style>
        /* Hide the actual radio button */

        /* Default state for the label */
        .custom-radio-option label {
            /* No border initially */
            cursor: pointer;
            transition: all 0.3s ease;
            /* Smooth transition */
        }


        /* When the radio input is checked, apply a transparent effect */
        input[type="radio"]:checked+label {
            background-color: rgba(27, 229, 0, 0.2);
            /* Semi-transparent green background */
            color: rgba(0, 0, 0, 1);
            /* Slightly transparent white text */
            /* Transparent green border */
            transition: all 0.3s ease;
            /* Smooth transition */
        }

        .rating {
            display: flex;
            justify-content: flex-end;
            transform: scaleX(-1);
        }

        .rating input {
            display: none;
            /* Sembunyikan input radio */
        }

        .rating label {
            cursor: pointer;
            font-size: 2rem;
            /* Ukuran ikon bintang */
            color: #ccc;
            /* Warna bintang tidak terpilih */
        }

        .rating input:checked~label {
            color: #f39c12;
            /* Warna bintang terpilih */
        }

        .rating label:hover,
        .rating label:hover~label {
            color: #f39c12;
            /* Warna bintang saat hover */
        }

        /* Menyediakan warna kuning untuk bintang yang terpilih */
        .rating input:checked+label,
        .rating input:checked+label~label {
            color: #f39c12;
            /* Warna kuning */
        }

        #showStar {
            color: #f39c12;
        }

        /* Styling List Group Utama */
        .list-group-item {
            border-left: 4px solid transparent !important;
            margin-bottom: 2px;
        }

        /* Styling saat materi Aktif */
        .active-materi {
            background-color: #eef4ff !important;
            color: #0d6efd !important;
            border-left: 4px solid #0d6efd !important;
        }

        /* Efek Hover */
        .list-group-item-action:hover:not(:disabled) {
            background-color: #f8f9fa;
            padding-left: 1.75rem !important;
            /* Efek geser sedikit */
        }

        /* Styling Materi Terkunci */
        .list-group-item:disabled {
            background-color: #ffffff;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .list-group-item:disabled .status-icon {
            filter: grayscale(1);
        }

        /* Animasi Icon Play */
        .active-materi .bi-play-circle-fill {
            animation: pulse-blue 2s infinite;
        }

        @keyframes pulse-blue {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .text-wrap-custom {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Teks akan tampil maksimal 2 baris, lalu ... */
            -webkit-box-orient: vertical;
            overflow: hidden;
            white-space: normal;
            /* Mengizinkan teks turun ke bawah */
            line-height: 1.4;
            /* Jarak antar baris agar tidak rapat */
            font-size: 0.95rem;
            /* Ukuran sedikit lebih kecil agar pas di sidebar */
            word-break: break-word;
            /* Memutus kata yang terlalu panjang jika perlu */
        }

        /* Jika ingin benar-benar tampil SEMUA tanpa batas baris, gunakan ini: */
        .text-reveal-all {
            display: block;
            white-space: normal;
            word-break: break-word;
            line-height: 1.4;
            padding-right: 5px;
        }

        /* Menghilangkan border default iframe yang sering muncul di beberapa browser */
        iframe {
            border: none;
            width: 100%;
            height: 100%;
        }

        /* Memastikan container video tidak terpotong oleh overflow parent */
        .video-container {
            position: relative;
            width: 100%;
            /* Menghindari flicker saat loading */
            min-height: 200px;
            background-color: #000;
        }

        /* Efek khusus untuk mobile agar video "penuh" ke pinggir jika diinginkan */
        @media (max-width: 576px) {
            .video-container {
                margin-left: -12px;
                /* Sesuaikan dengan padding container Anda */
                margin-right: -12px;
                border-radius: 0;
                /* Opsional: video jadi kotak penuh di HP agar lebih lega */
            }
        }

        /* Container utama video agar tidak terpotong */
        .video-wrapper {
            position: relative;
            background-color: #000;
            /* Memberikan kesan kedalaman */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        }

        /* Memperbaiki rasio video di mobile agar tidak terlalu kecil */
        @media (max-width: 576px) {
            .video-wrapper {
                margin-left: -0.5rem;
                /* Menarik sedikit ke tepi agar lebih luas */
                margin-right: -0.5rem;
                border-radius: 12px;
                /* Mengurangi radius sedikit di layar kecil */
            }
        }

        /* Mencegah video lokal menonjol keluar dari radius */
        video {
            object-fit: contain;
            /* Menjaga rasio asli video di dalam box */
            background: #000;
        }

        /* Mempercantik tampilan artikel/teks di bawah video */
        .article-container {
            line-height: 1.8;
            font-size: 1.05rem;
            color: #444;
        }

        .article-container img {
            max-width: 100%;
            /* Agar gambar di dalam artikel tidak pecah/melebar */
            height: auto;
            border-radius: 10px;
        }

        /* Mengatur rasio khusus PDF agar tidak terlalu pendek di Desktop */
    @media (min-width: 992px) {
        .pdf-container .ratio-4x3 {
            --bs-aspect-ratio: 75%; /* Rasio 4:3 standar */
            min-height: 800px; /* Memaksa tinggi minimal agar enak dibaca */
        }
    }

    /* Di Mobile, biarkan mengikuti rasio agar tidak melebihi layar */
    @media (max-width: 768px) {
        .pdf-container .ratio-4x3 {
            min-height: 500px;
        }
    }

    .pdf-container iframe {
        background-color: #525659; /* Warna abu-abu gelap khas viewer PDF */
    }
    </style>


    <div class="container-fluid">


        <div class="progress-wrapper mt-4 d-md-none d-sm-block">
            <div class="d-flex justify-content-between align-items-end mb-2">
                <span class="fw-bold text-dark small">Progres Belajar</span>
                <span class="fw-bold text-success" style="font-size: 0.9rem;">
                    {{ $completionPercentage }}% <span class="text-muted fw-normal">Selesai</span>
                </span>
            </div>

            <div class="progress rounded-pill shadow-sm" style="height: 12px; background-color: #e9ecef;">
                <div class="progress-bar progress-bar-striped progress-bar-animated rounded-pill" role="progressbar"
                    style="width: {{ $completionPercentage }}%; background: linear-gradient(45deg, #28a745, #34ce57);"
                    aria-valuenow="{{ $completionPercentage }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>

            @if ($completionPercentage == 100)
                <div class="text-center mt-2">
                    <small class="badge bg-success-subtle text-success rounded-pill px-3">
                        <i class="bi bi-patch-check-fill me-1"></i> Kursus Selesai!
                    </small>
                </div>
            @endif
        </div>


        <section class="col-12 mt-2 pb-5">
            @if (isset($course))
                <div class="row">
                    <!-- Kolom untuk Video dan Penjelasan -->
                    <div class="col-md-9">
                        @if (isset($courseContent))
                            <div class="mt-3">
                                <h2 class="fw-bold text-dark mb-2">
                                    {{ $courseContent->content_title }}</h2>
                                @if ($courseContent->content_type == $videoType)
                                    <div class="ratio ratio-16x9 mb-4 shadow-sm rounded-4 overflow-hidden bg-black">
                                        <video poster="{{ $courseContent->video->thumbnail_image }}" controls
                                            controlsList="nodownload" oncontextmenu="return false;" class="w-100 h-100">
                                            <source src="{{ $courseContent->video->video_file }}" type="video/mp4">
                                        </video>
                                    </div>

                                    <div class="article-content mt-3">
                                        {!! $courseContent->video->article_content !!}
                                    </div>
                                @elseif($courseContent->content_type == $addSrcType)
                                    <div class="pdf-container mb-4 shadow-sm rounded-4 overflow-hidden border bg-light"
                                        data-aos="fade-in">
                                        <div class="ratio ratio-4x3">
                                            <iframe src="{{ $courseContent->src->file }}#toolbar=0" title="PDF Document"
                                                class="border-0 w-100 h-100">
                                                <p>Browser Anda tidak mendukung tampilan PDF.
                                                    <a href="{{ $courseContent->src->file }}">Klik di sini untuk
                                                        mengunduh.</a>
                                                </p>
                                            </iframe>
                                        </div>
                                    </div>
                                @elseif($courseContent->content_type == $quizType)
                                    @if (isset($courseContent->quiz->questions))
                                        <div class="quiz-container">
                                            @foreach ($courseContent->quiz->questions as $quiz)
                                                <div class="card p-4 mb-4 shadow-sm border-0 rounded-4 quiz-card">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <span
                                                            class="badge bg-primary-subtle text-primary rounded-pill px-3">Pertanyaan
                                                            {{ $loop->iteration }}</span>
                                                    </div>

                                                    <h5 class="fw-bold text-dark mb-4 lh-base">{{ $quiz->question }}</h5>

                                                    <div class="quiz-options">
                                                        @foreach ($quiz->Options as $option)
                                                            <div class="custom-radio-option mb-3">
                                                                <input class="form-check-input d-none quiz-input"
                                                                    type="radio"
                                                                    id="option-{{ $quiz->index }}-{{ $option->index }}"
                                                                    name="option-{{ $quiz->index }}"
                                                                    value="{{ $option->index }}"
                                                                    onclick="answer('{{ $quiz->index }}', '{{ $option->index }}')">

                                                                <label
                                                                    class="quiz-label d-flex align-items-center p-3 rounded-3 border w-100 mb-0"
                                                                    for="option-{{ $quiz->index }}-{{ $option->index }}"
                                                                    style="cursor: pointer;">
                                                                    <span class="option-letter me-3">
                                                                        {{ chr(64 + $loop->iteration) }} </span>
                                                                    <span class="option-text">{{ $option->name }}</span>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="d-grid d-md-flex justify-content-md-end mt-4">
                                                <button id="submitBtnQuiz"
                                                    class="btn btn-success btn-lg px-5 py-3 rounded-pill fw-bold shadow">
                                                    <i class="bi bi-send-fill me-2"></i> Kirim Jawaban
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="mt-5 pt-4 border-top">
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <button
                                        onclick="window.location.href='?selectedCourseContentId={{ $previousCourseContentId }}'"
                                        {{ $previousCourseContentId == '' ? 'disabled' : '' }}
                                        class="btn btn-outline-secondary rounded-pill px-4 py-2 d-flex align-items-center transition-all shadow-sm">
                                        <i class="bi bi-arrow-left-circle me-2"></i>
                                        <span class="d-none d-md-inline">Materi Sebelumnya</span>
                                        <span class="d-md-none">Kembali</span>
                                    </button>

                                    <button id="nextCourseButton"
                                        onclick="window.location.href='?selectedCourseContentId={{ $nextCourseContentId }}'"
                                        {{ $nextCourseContentId == '' || $courseContent->is_completed == false ? 'disabled' : '' }}
                                        class="btn btn-primary rounded-pill px-4 py-2 d-flex align-items-center shadow transition-all fw-bold">
                                        <span class="ms-1">Materi Selanjutnya</span>
                                        <i class="bi bi-arrow-right-circle ms-2"></i>
                                    </button>
                                </div>

                                @if ($courseContent->is_completed == false)
                                    <div class="text-end mt-2">
                                        <small class="text-danger italic">
                                            <i class="bi bi-info-circle me-1"></i> Selesaikan materi/kuis untuk lanjut.
                                        </small>
                                    </div>
                                @endif
                            </div>
                        @else
                            <p>Belum ada Materi</p>
                        @endif
                    </div>
                    <!-- Kolom untuk Materi Selanjutnya -->
                    <div class="col-md-3 d-none d-lg-block materi-container px-3">

                        <div
                            class="progress-container-desktop d-none d-md-block mb-4 p-4 bg-white shadow-sm rounded-4 border">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="fw-bold mb-1 text-dark">Progres Belajar Anda</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-info-circle me-1"></i>
                                        {{ $completionPercentage == 100 ? 'Luar biasa! Kursus telah selesai.' : 'Yuk selesaikan semua materinya' }}
                                    </p>
                                </div>
                                <div class="col-auto text-end">
                                    <span class="h4 fw-bold text-primary mb-0">{{ $completionPercentage }}%</span>
                                </div>
                            </div>

                            <div class="progress rounded-pill mt-3" style="height: 10px; background-color: #f0f2f5;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated rounded-pill shadow-sm"
                                    role="progressbar"
                                    style="width: {{ $completionPercentage }}%; background: linear-gradient(90deg, #0d6efd, #0dcaf0);"
                                    aria-valuenow="{{ $completionPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>

                        </div>

                        <div class="list-group mt-3 border-0 shadow-sm rounded-4 overflow-hidden">
                            @if (isset($courseContents))
                                @foreach ($courseContents as $index => $courseContentSidebar)
                                    @php
                                        $isActive = $selectedCourseContentId == $courseContentSidebar->content_id;
                                        $isLocked = $courseContentSidebar->is_completed == false && !$isActive;
                                        $isDone = $courseContentSidebar->is_completed == true;
                                    @endphp

                                    <button
                                        onclick='window.location.href="?selectedCourseContentId={{ $courseContentSidebar->content_id }}"'
                                        class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between py-3 px-4 {{ $isActive ? 'active-materi' : '' }}"
                                        {{ $isLocked ? 'disabled' : '' }} style="transition: all 0.2s ease;">

                                        <div class="d-flex align-items-center overflow-hidden">
                                            <div class="status-icon me-3">
                                                @if ($isDone)
                                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                                @elseif($isActive)
                                                    <i class="bi bi-play-circle-fill text-primary fs-5"></i>
                                                @elseif($isLocked)
                                                    <i class="bi bi-lock-fill text-muted opacity-50 fs-5"></i>
                                                @else
                                                    <i class="bi bi-circle text-secondary opacity-50 fs-5"></i>
                                                @endif
                                            </div>

                                            <div class="text-start">
                                                <small class="text-uppercase fw-bold opacity-50 d-block"
                                                    style="font-size: 0.65rem; letter-spacing: 1px;">
                                                    Materi {{ $index + 1 }}
                                                </small>
                                                <span class="fw-semibold d-block text-wrap-custom">
                                                    {{ $courseContentSidebar->courseDetail->content_title }}
                                                </span>
                                            </div>
                                        </div>

                                        @if ($isActive)
                                            <span
                                                class="badge bg-white text-primary rounded-pill small px-2 py-1 shadow-sm">
                                                Dipilih
                                            </span>
                                        @endif
                                    </button>
                                @endforeach
                            @endif

                            <div class="px-3 pb-3 mt-4">
                                <a href="/user/diskusi-kelas/{{ $course->course->id }}"
                                    class="btn btn-primary w-100 py-3 rounded-4 shadow-sm d-flex align-items-center justify-content-center text-white border-0 fw-bold transition-all">
                                    <i class="bi bi-chat-dots-fill me-2"></i>
                                    Diskusi
                                </a>
                            </div>
                        </div>

                        <div class="rating-wrapper p-3 bg-light rounded-4">
                            @if (!isset($userRate))
                                <h6 class="fw-bold mb-3">Berikan Penilaian Anda</h6>

                                <div class="star-rating mb-3 d-flex flex-row-reverse justify-content-end">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating"
                                            value="{{ $i }}" class="d-none">
                                        <label for="star{{ $i }}" title="{{ $i }} stars"
                                            class="star-label">
                                            <i class="fas fa-star fs-3"></i>
                                        </label>
                                    @endfor
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control border-0 shadow-sm" id="descRate" placeholder="Bagaimana pengalaman belajarmu?"
                                        style="height: 120px; border-radius: 15px;"></textarea>
                                    <label for="descRate" class="text-muted">Tulis ulasan singkat...</label>
                                </div>
                            @else
                                <div class="user-review-card bg-white p-3 rounded-4 shadow-sm border">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">Ulasan
                                            Anda</span>
                                        <div class="text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fa{{ $i <= $userRate->rating ? 's' : 'r' }} fa-star"></i>
                                            @endfor
                                            <span class="ms-1 fw-bold text-dark small">({{ $userRate->rating }}.0)</span>
                                        </div>
                                    </div>

                                    <div class="form-floating">
                                        <textarea class="form-control-plaintext bg-light p-3 rounded-3" readonly
                                            style="height: 100px; font-style: italic; resize: none;">"{{ $userRate->description }}"</textarea>
                                        <label class="small text-muted opacity-50">Review yang Anda kirim</label>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>

                </div>
            @else
                <!-- Konten alternatif jika $course tidak ada, jika perlu -->
                <p>Course tidak ditemukan.</p>
            @endif

        </section>
    </div>

    @if (!isset($userRate))
        <script>
            const ratingInputs = document.querySelectorAll('input[name="rating"]');

            ratingInputs.forEach((input) => {
                input.addEventListener('change', function() {
                    const selectedValue = this.value;
                    createOverlay("Proses...");


                    var descRate = $('#descRate').val()

                    var formData = new FormData();
                    formData.append('rating', selectedValue);
                    formData.append('description', descRate);
                    formData.append('studentId', '{{ $userCourse->id }}');



                    $.ajax({
                        url: '{{ route('kelas.rate') }}', // Direct API endpoint
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            gOverlay.hide()
                            Swal.fire({
                                icon: 'success',
                                title: response.data.title,
                                text: response.data.content
                            })
                            setTimeout(() => {
                                window.location.reload()
                            }, 1500); // Delay 1.5 detik sebelum redirect
                        },
                        error: function(xhr, status, error) {
                            gOverlay.hide()
                            Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                        }
                    });

                });
            });
        </script>
    @endif


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if (isset($courseContent))
        @if ($courseContent->content_type == $quizType)
            @if (isset($courseContent->quiz->questions))
                <script>
                    var questionOptionsSelected = []

                    function answer(questionsIndex, indexOptions) {


                        const existingIndex = questionOptionsSelected.findIndex(item => item.index === questionsIndex);
                        if (existingIndex !== -1) {
                            questionOptionsSelected[existingIndex].Option = indexOptions;
                        } else {
                            questionOptionsSelected.push({
                                index: questionsIndex,
                                Option: indexOptions
                            });
                        }
                    }

                    $('#submitBtnQuiz').on('click', function(event) {
                        event.preventDefault(); // Prevent the default form submission

                        var answers = []

                        questionOptionsSelected.sort((a, b) => a.index - b.index);


                        questionOptionsSelected.forEach(item => {
                            answers.push(parseInt(item.Option));
                        });

                        if (questionOptionsSelected.length < '{{ $courseContent->quiz->questionTotal }}' || answers.length <=
                            0) {
                            Swal.fire('Oops!', 'Selesaikan Quiz terlebih dahulu', 'error');
                            return;
                        }



                        createOverlay("Proses...");
                        var formData = new FormData();
                        formData.append('answers', JSON.stringify(answers));
                        formData.append('studentId', '{{ $userCourse->id }}');


                        $.ajax({
                            url: '{{ route('quiz.answer', $courseContent->id) }}', // Direct API endpoint
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                gOverlay.hide()
                                if (response.dataServer.passed_status) {
                                    // If the user passed the quiz
                                    Swal.fire({
                                        icon: 'success',
                                        title: response.data.title,
                                        text: response.data.content
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById('nextCourseButton').click();
                                        }
                                    });
                                } else {
                                    // If the user did not pass the quiz
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.data.title,
                                        text: response.data.content
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Optionally reload the page after confirmation
                                            window.location.reload();
                                        }
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                gOverlay.hide()
                                Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                            }
                        });
                    })
                </script>
            @endif
        @endif
    @endif

@endsection

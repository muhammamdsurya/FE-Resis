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


        #checkoutBtn {
            transition: background-color 0.3s ease;
        }

        #checkoutBtn:hover {
            background-color: #28a745;
        }

        /* CSS for enhanced FAQ section */
        .faq .card {
            transition: transform 0.3s ease;
        }

        .faq .card:hover {
            transform: translateY(-5px);
            /* Lift effect on hover */
            cursor: pointer;
        }

        .faq .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            /* Dark overlay */
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .faq .card:hover .overlay {
            opacity: 1;
            /* Show overlay on hover */
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
    <section id="detail-kelas" class="hero section py-5" style="background-color: #f9f9f9">
        <div class="container my-5">
            <div class="row gy-4 g-4">
                <!-- Left Content: Course Info -->
                <div class="col-lg-9 col-md-8 order-2 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                    <div class="container bg-white p-4 shadow rounded" style="border-radius: 15px">
                        <div class="row align-items-center gy-5">
                            <div class="col-lg-5">
                                <img src="{{ $bundling->thumbnail_image }}" alt="{{ $bundling->name }}"
                                    class="card-img-top rounded" style="height: 200px; object-fit: cover;">

                            </div>
                            <!-- End Image -->

                            <div class="col-lg-7">
                                <div>
                                    <h4 class="fw-bold text-dark">
                                        {{ $bundling->name }}
                                    </h4>
                                    <p class="text-muted my-3">
                                        {{ $bundling->description }}
                                    </p>
                                </div>
                            </div>
                            <!-- End Text -->
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Pricing and Buttons -->
                <div class="col-lg-3 col-md-4 order-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="card text-bg-light shadow-lg border-0 rounded" style="border-radius: 15px">
                        <div class="card-body text-center py-4">
                            <h5 class="card-title text-success fw-bold fs-3">
                                Rp.
                                {{ number_format($bundling->price, 0, ',', '.') }}
                            </h5>
                            @if ($role == 'admin')
                                <a href="{{ route('detail-bundling', ['id' => $bundling->id]) }}"
                                    class="btn btn-success btn-lg mt-3 px-4">Edit kelas</a>
                            @elseif ($role == 'instructor')
                                <a href="{{ route('instructor.detail-kelas', ['id' => $course->course->id]) }}"
                                    class="btn btn-success btn-lg mt-3 px-4">Lihat kelas</a>
                            @else
                                <button id="checkoutBtn" class="btn btn-success btn-lg mt-3 px-4">
                                    Belajar Sekarang
                                </button>
                            @endif

                        </div>
                        <hr class="border border-dark border-1 opacity-20 mx-4" />
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
                        <p class="text-muted">{{ $bundling->description }}</p>
                    </div>

                    <div class="mb-5">
                        <h4 class="fw-bold mb-3">Pengajar</h4>
                        <div class="row g-2"> <!-- Use a row to properly handle column layout -->
                            @php
                                $displayedInstructors = []; // Initialize an array to keep track of displayed instructors
                            @endphp

                            @foreach ($contents as $content)
                                @php
                                    $instructorName = $content->instructor->full_name; // Get the instructor's name
                                @endphp

                                @if (!in_array($instructorName, $displayedInstructors))
                                    <div class="col-lg-4 col-6"> <!-- Each card should be in its own column -->
                                        <div class="card shadow-sm border-0 rounded">
                                            <img src="{{ $content->instructor->photo_profile }}" alt="Instructor"
                                                class="card-img-top rounded-circle mx-auto" width="50" height="50"
                                                style="object-fit: cover; margin-top: 15px;">
                                            <div class="card-body text-center">
                                                <h6 class="fw-bold">{{ $instructorName }}</h6> <!-- Use the variable -->
                                                <p class="text-muted mb-1">
                                                    {{ $content->instructor->instructor->education }}
                                                </p>
                                                <span
                                                    class="badge bg-primary">{{ $content->instructor->instructor->experience }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $displayedInstructors[] = $instructorName; // Add the name to the array to avoid duplicates
                                    @endphp
                                @endif
                            @endforeach

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
                            <li>
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Tentukan sendiri waktu belajar selama masih aktif
                                terdaftar
                            </li>
                        </ul>

                        <!-- Fasilitas Pengajar -->
                        <h4 class="fw-bold mt-4 mb-3">Fasilitas Pengajar</h4>
                        <ul class="list-unstyled text-muted">
                            <li>
                                <i class="bi bi-play-circle-fill text-success me-2"></i>
                                Video Pembelajaran
                            </li>
                            <li>
                                <i class="bi bi-file-earmark-text-fill text-success me-2"></i>
                                Modul Online
                            </li>
                            <li>
                                <i class="bi bi-question-circle-fill text-success me-2"></i>
                                Kuis Interaktif
                            </li>
                            <li>
                                <i class="bi bi-chat-left-dots-fill text-success me-2"></i>
                                Forum Diskusi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Faq Section -->
    <section id="silabus-kelas" class="faq section py-5">
        <!-- Section Title -->
        <div class="container section-title text-center mb-4" data-aos="fade-up">
            <h2 class="fw-bold">Paket Ini Berisi</h2>
            <p class="text-muted">Kelas kelas yang sesuai untuk paket pembelajaran kamu</p>
        </div>
        <!-- End Section Title -->

        <div class="container">
            <div class="row gx-2 gy-4">
                @if ($contents)
                    @foreach ($contents as $content)
                        <div class="col-lg-3 col-md-4 col-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <a href="{{ route('detail.kelas', ['courseId' => $content->course->id]) }}"
                                class="text-decoration-none">
                                <div class="card h-100 shadow border-0 position-relative"
                                    style="border-radius: 15px; overflow: hidden">
                                    <img src="{{ $content->course->thumbnail_image ?? 'assets/img/values-1.png' }}"
                                        class="card-img-top" alt="{{ $content->course->name }}"
                                        style="height: 100px; object-fit: cover; border-radius: 15px 15px 0 0;" />
                                    <div class="card-body">
                                        <div class="header-card d-flex justify-content-between mb-2">
                                            <p class="badge bg-primary fs-6 mb-0">
                                                {{ $content->course->name }}
                                            </p>
                                        </div>

                                        <h5 class="card-title fw-bold text-dark">
                                            {{ $content->course->name }}
                                        </h5>
                                        <h6 class="text-success fw-bold mb-3">
                                            Rp {{ number_format($content->course->price, 0, ',', '.') }}
                                        </h6>
                                        <p class="card-text text-muted mb-0">
                                            {{ Str::limit($content->course->description, 10) }} {{-- Limit description to avoid overflow --}}
                                        </p>
                                    </div>

                                    <!-- Dark overlay on hover -->
                                    <div class="overlay d-flex align-items-center justify-content-center">
                                        <div class="text-center">
                                            <p class="text-white fw-bold fs-5">
                                                Lihat Detail
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <p>Belum ada kelas</p>
                @endif
            </div>
        </div>
    </section>
    <!-- /Faq Section -->


    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2 class="fw-bold">Testimoni</h2>
            <p class="text-muted">Pengalaman dari mereka tentang kelas ini</p>
        </div>
        <!-- End Section Title -->
        <div class="container">
            @foreach ($ratings as $rating)
                @if (!empty($rating->data))
                    <!-- This checks if 'data' is not empty or null -->
                    @foreach ($rating->data as $row)
                        <div class="rating-box">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5>{{ $row->student_name }}</h5>
                                    <p class="mb-0">{{ $row->description }} stars</p>
                                </div>

                                <div class="rating-stars fs-3">
                                    @for ($i = 1; $i <= $row->rating; $i++)
                                        <i class="bi bi-star-fill text-warning me-1"></i>
                                    @endfor
                                </div>

                            </div>
                        </div>
                    @endforeach

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Button -->
                            @if ($rating->pagination->page > 1)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ route('detail.bundling', ['page' => $rating->pagination->page - 1]) }}">Previous</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                            @endif

                            <!-- Page Numbers -->
                            @for ($i = 1; $i <= $rating->pagination->total_page; $i++)
                                <li class="page-item {{ $rating->pagination->page === $i ? 'active' : '' }}">
                                    <a class="page-link"
                                        href="{{ route('detail.bundling', ['courseBundleId' => $bundling->id, 'page' => $i]) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            <!-- Next Button -->
                            @if ($rating->pagination->page < $rating->pagination->total_page)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ route('detail.bundling', ['courseBundleId' => $bundling->id, 'page' => $ratings->pagination->page + 1]) }}">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link">Next</a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @else
                    <p>Belum ada rating</p>
                @endif
            @endforeach


        </div>
    </section>
    <!-- /Testimonials Section -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if ($isLogin == 'y')
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"></script>
    @endif
    <script>
        $('#checkoutBtn').on('click', function(event) {
            event.preventDefault();


            if ('{{ $isLogin }}' == 'y') {

                $.ajax({
                    url: '{{ route('user.checkout') }}', // Direct API endpoint
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    data: JSON.stringify({
                        bundleId: '{{ $bundling->id }}'
                    }),
                    success: function(response) {

                        // Swal.fire('Berhasil', response.data.message, 'success');
                        if (response.data.midtrans_snap_token) {
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

            } else {
                document.location.href = '/login'
            }
        })
    </script>
@endsection

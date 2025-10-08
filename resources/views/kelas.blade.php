@extends('layout.layout')

@section('content')
    <style>
        .card {
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            cursor: pointer;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5) !important;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 15px;
        }

        .card:hover .overlay {
            opacity: 1;
        }

        .overlay p {
            margin: 0;
        }
    </style>
    <section class="section">
        <div class="container mt-5 section-title" data-aos="fade-up">
            <p>Kelas Kami<br></p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gx-2 gy-4">
                @if ($pagination ?? false)
                    @if ($courses->data)
                        @foreach ($courses->data as $course)
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="{{ route('detail.kelas', ['courseId' => $course->course->id]) }}">
                                    <div class="card h-100 shadow border-0 position-relative"
                                        style="border-radius: 15px; overflow: hidden;">
                                        <img src="{{ $course->course->thumbnail_image }}" class="card-img-top"
                                            alt="..." style="height: 150px; object-fit: cover;">
                                        <div class="card-body">
                                            <div class="header-card d-flex justify-content-between align-items-center mb-2">
                                                <div class="rating d-flex align-items-center me-2">
                                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                                    <span class="text-muted fs-6">{{ $course->course->rating }}</span>
                                                </div>
                                                <span
                                                    class="badge bg-primary small text-wrap text-truncate text-center px-2 py-1"
                                                    style="max-width: 120px;">
                                                    {{ $course->course_category->name }}
                                                </span>
                                            </div>

                                            <h5 class="card-title fw-bold fs-6 text-dark">{{ $course->course->name }}</h5>
                                            <h6 class="text-success fw-bold mb-3">Rp
                                                {{ number_format($course->course->price, 0, ',', '.') }}</h6>
                                            <p class="card-text text-muted">
                                                {{ Str::limit($course->course->description, 50) }}
                                            </p>
                                        </div>

                                        <!-- Dark overlay on hover -->
                                        <div class="overlay d-flex align-items-center justify-content-center">
                                            <div class="text-center">
                                                <p class="text-white fw-bold fs-5">Lihat Detail</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="container text-center">
                            <h4 class="text-dark">Belum ada Kelas</h4>
                        </div>
                    @endif
                @else
                    @foreach ($courses as $course)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="{{ route('detail.kelas', ['courseId' => $course->id]) }}">
                                <div class="card h-100 shadow border-0 position-relative"
                                    style="border-radius: 15px; overflow: hidden;">
                                    <img src="{{ $course->thumbnail_image }}" class="card-img-top" alt="..."
                                        style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <div class="header-card d-flex justify-content-between align-items-center mb-2">
                                            <div class="rating d-flex align-items-center me-2">
                                                <i class="bi bi-star-fill text-warning me-1"></i>
                                                <span class="text-muted fs-6">{{ $course->course->rating }}</span>
                                            </div>
                                            <span
                                                class="badge bg-primary small text-wrap text-truncate text-center px-2 py-1"
                                                style="max-width: 120px;">
                                                {{ $course->course_category->name }}
                                            </span>
                                        </div>

                                        <h5 class="card-title fw-bold fs-6 text-dark">{{ $course->course->name }}</h5>
                                        <h6 class="text-success fw-bold mb-3">Rp
                                            {{ number_format($course->course->price, 0, ',', '.') }}</h6>
                                        <p class="card-text text-muted">
                                            {{ Str::limit($course->course->description, 50) }}
                                        </p>
                                    </div>

                                    <!-- Dark overlay on hover -->
                                    <div class="overlay d-flex align-items-center justify-content-center">
                                        <div class="text-center">
                                            <p class="text-white fw-bold fs-5">Lihat Detail</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif

                @if ($pagination ?? false)
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Button -->
                            @if ($pagination->page > 1)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ route('kelas', ['page' => $pagination->page - 1]) }}">Previous</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                            @endif

                            <!-- Page Numbers -->
                            @for ($i = 1; $i <= $pagination->total_page; $i++)
                                <li class="page-item {{ $pagination->page === $i ? 'active' : '' }}">
                                    <a class="page-link"
                                        href="{{ route('kelas', ['page' => $i]) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            <!-- Next Button -->
                            @if ($pagination->page < $pagination->total_page)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ route('kelas', ['page' => $pagination->page + 1]) }}">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link">Next</a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif


            </div>
            <a href="{{ route('kelas', ['free' => 'trial']) }}" class="btn btn-secondary btn-sm">Coba kelas gratis</a>
        </div>

    @endsection

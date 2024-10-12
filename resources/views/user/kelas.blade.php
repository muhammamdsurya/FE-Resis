@extends('layout.userLayout')
@section('title', $title)

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
    <div class="container-fluid mt-3">
        <div id="coursesContainer" class="row g-2 mb-5">
            @if ($userCourses->data && count($userCourses->data) > 0)
                @if ($userCourses->pagination ?? false)
                    @foreach ($userCourses->data as $userCourse)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="/user/detail-kelas/{{ $userCourse->course->id }}" class="fs-6 text-decoration-none">
                                <div class="card h-100 shadow border-0 position-relative"
                                    style="border-radius: 15px; overflow: hidden;">
                                    <img src="{{ $userCourse->course->thumbnail_image }}" class="card-img-top"
                                        alt="..." style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <div class="header-card d-flex justify-content-between mb-3">
                                            <p class="text-muted fs-6 mb-0"><i class="fas fa-star text-warning me-1"></i>4.9
                                            </p>
                                            <p class="badge bg-primary fs-6 mb-0">{{ $userCourse->course_category->name }}
                                            </p>
                                        </div>
                                        <h5 class="card-title fw-bold text-dark">{{ $userCourse->course->name }}</h5>
                                        <p class="card-text text-muted">
                                            {{ Str::limit($userCourse->course->description, 50) }}
                                        </p>
                                    </div>

                                    <!-- Dark overlay on hover -->
                                    <div class="overlay d-flex align-items-center justify-content-center">
                                        <div class="text-center">
                                            <p class="text-white fw-bold fs-5">Lanjutkan</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    @foreach ($userCourses->data as $userCourse)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="/user/detail-kelas/{{ $userCourse->course->id }}" class="fs-6 text-decoration-none">
                                <div class="card h-100 shadow border-0 position-relative"
                                    style="border-radius: 15px; overflow: hidden;">
                                    <img src="{{ $userCourse->course->thumbnail_image }}" class="card-img-top"
                                        alt="..." style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <div class="header-card d-flex justify-content-between mb-3">
                                            <p class="text-muted fs-6 mb-0"><i class="fas fa-star text-warning me-1"></i>4.9
                                            </p>
                                            <p class="badge bg-primary fs-6 mb-0">{{ $userCourse->course_category->name }}
                                            </p>
                                        </div>
                                        <h5 class="card-title fw-bold text-dark">{{ $userCourse->course->name }}</h5>
                                        <p class="card-text text-muted">
                                            {{ Str::limit($userCourse->course->description, 50) }}
                                        </p>
                                    </div>

                                    <!-- Dark overlay on hover -->
                                    <div class="overlay d-flex align-items-center justify-content-center">
                                        <div class="text-center">
                                            <p class="text-white fw-bold fs-5">Lanjutkan</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            @else
                <div class="col-12 text-center">
                    <h5>Kamu belum membeli kelas</h5>
                    <a href="{{ route('kelas') }}" class="btn btn-primary mt-3">
                        Beli Kelas
                    </a>
                </div>
            @endif
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <!-- Previous Button -->
                @if ($userCourses->pagination->page > 1)
                    <li class="page-item">
                        <a class="page-link"
                            href="{{ route('user.kelas', ['page' => $userCourses->pagination->page - 1]) }}">Previous</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                @endif

                <!-- Page Numbers -->
                @for ($i = 1; $i <= $userCourses->pagination->total_page; $i++)
                    <li class="page-item {{ $userCourses->pagination->page === $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('user.kelas', ['page' => $i]) }}">{{ $i }}</a>
                    </li>
                @endfor

                <!-- Next Button -->
                @if ($userCourses->pagination->page < $userCourses->pagination->total_page)
                    <li class="page-item">
                        <a class="page-link"
                            href="{{ route('user.kelas', ['page' => $userCourses->pagination->page + 1]) }}">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

@endsection

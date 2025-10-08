@extends('layout.userLayout')
@section('title', $title)

@section('filter')
    <div class="position-relative">
        <div class="position-relative">
            <div class="row mb-3 text-center">
                <!-- Tombol grid untuk desktop (di atas layar md) -->
                <div class="d-grid gap-2 d-none d-md-block">
                    <button class="btn btn-{{ $filter == 'all' ? 'primary' : 'secondary' }}" type="button"
                        onclick="window.location.href='?filter=all'">Semua</button>
                    <button class="btn btn-{{ $filter == 'active' ? 'primary' : 'secondary' }}" type="button"
                        onclick="window.location.href='?filter=active'">Aktif</button>
                    <button class="btn btn-{{ $filter == 'expired' ? 'primary' : 'secondary' }}" type="button"
                        onclick="window.location.href='?filter=expired'">Expired</button>
                </div>

                <!-- Dropdown untuk mobile (di bawah layar md) -->
                <div class="dropdown d-md-none">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Filter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        <li>
                            <a class="dropdown-item {{ $filter == 'all' ? 'active' : '' }}" href="?filter=all">Semua</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ $filter == 'active' ? 'active' : '' }}"
                                href="?filter=active">Aktif</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ $filter == 'expired' ? 'active' : '' }}"
                                href="?filter=expired">Expired</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>



@endsection

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
            @if ($filter == 'expired')
                @if ($userCourses->data && count($userCourses->data) > 0)
                    <!-- Loop through the expired courses -->
                    @foreach ($userCourses->data as $userCourse)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="/user/detail-kelas/{{ $userCourse->course->id }}" class="fs-6 text-decoration-none">
                                <div class="card h-100 shadow border-0 position-relative"
                                    style="border-radius: 15px; overflow: hidden;">
                                    <img src="{{ $userCourse->course->thumbnail_image }}" class="card-img-top"
                                        alt="..." style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <div class="header-card d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-star text-warning me-1"></i>
                                                <span class="text-muted fs-6">{{ $userCourse->course->rating }}</span>
                                            </div>
                                            <span class="badge bg-primary small px-3 py-1 text-center"
                                                style="white-space: normal;">
                                                {{ $userCourse->course_category->name }}
                                            </span>
                                        </div>

                                        <h5 class="card-title fw-bold text-dark mb-1">{{ $userCourse->course->name }}</h5>
                                        <p class="card-text text-muted mb-0">
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
                    <!-- No expired classes -->
                    <div class="col-12 text-center">
                        <h5>Tidak ada kelas expired</h5>
                    </div>
                @endif
            @else
                <!-- Filter is not expired -->
                @if ($userCourses->data && count($userCourses->data) > 0)
                    <!-- Loop through available classes -->
                    @foreach ($userCourses->data as $userCourse)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="/user/detail-kelas/{{ $userCourse->course->id }}" class="fs-6 text-decoration-none">
                                <div class="card h-100 shadow border-0 position-relative"
                                    style="border-radius: 15px; overflow: hidden;">
                                    <img src="{{ $userCourse->course->thumbnail_image }}" class="card-img-top"
                                        alt="..." style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <div class="header-card d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-star text-warning me-1"></i>
                                                <span class="text-muted fs-6">{{ $userCourse->course->rating }}</span>
                                            </div>
                                            <span class="badge bg-primary small px-3 py-1 text-center"
                                                style="white-space: normal;">
                                                {{ $userCourse->course_category->name }}
                                            </span>
                                        </div>

                                        <h5 class="card-title fw-bold text-dark mb-1">{{ $userCourse->course->name }}</h5>
                                        <p class="card-text text-muted mb-0">
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
                    <!-- No available classes -->
                    <div class="col-12 text-center">
                        <h5>Kamu belum membeli kelas</h5>
                        <a href="{{ route('kelas') }}" class="btn btn-primary mt-3">
                            Beli Kelas
                        </a>
                    </div>
                @endif
            @endif
        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <!-- Previous Button -->
                @if ($userCourses->pagination->page > 1)
                    <li class="page-item">
                        <a class="page-link"
                            href="/user/kelas?filter={{ $filter }}&page={{ $userCourses->pagination->page + 1 }}">Previous</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                @endif

                <!-- Page Numbers -->
                @for ($i = 1; $i <= $userCourses->pagination->total_page; $i++)
                    <li class="page-item {{ $userCourses->pagination->page === $i ? 'active' : '' }}">
                        <a class="page-link"
                            href="/user/kelas?filter={{ $filter }}&page={{ $i }}">{{ $i }}</a>
                    </li>
                @endfor

                <!-- Next Button -->
                @if ($userCourses->pagination->page < $userCourses->pagination->total_page)
                    <li class="page-item">
                        <a class="page-link"
                            href="/user/kelas?filter={{ $filter }}&page={{ $$userCourses->pagination->page - 1 }}">Next</a>
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

@extends('layout.userLayout')

@section('filter')
    <div class="filter-dropdown d-md-none ms-3">
        <div class="dropdown">
            <button class="btn btn-white shadow-sm dropdown-toggle fw-bold" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                <i class="fas fa-filter me-1 text-primary"></i> Filter
            </button>
            <ul class="dropdown-menu border-0 shadow" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item {{ $filter == 'all' ? 'active' : '' }}" href="?filter=all">Semua</a></li>
                <li><a class="dropdown-item {{ $filter == 'active' ? 'active' : '' }}" href="?filter=active">Aktif</a></li>
                <li><a class="dropdown-item {{ $filter == 'expired' ? 'active' : '' }}" href="?filter=expired">Expired</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <style>
        .card-course {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #fff;
            border: none;
        }
        .card-course:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .btn-filter {
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            border: none;
        }
        .btn-filter.active {
            background-color: #007bff !important;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }
        .btn-filter.inactive {
            background-color: #e9ecef;
            color: #6c757d;
        }
        .course-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 123, 255, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            backdrop-filter: blur(2px);
        }
        .card-course:hover .course-overlay {
            opacity: 1;
        }
        .pagination .page-link {
            border: none;
            margin: 0 3px;
            border-radius: 8px;
            color: #6c757d;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff;
        }
    </style>

    <div class="container-fluid p-4" style="background-color: #f4f6f9; min-height: 100vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0" style="color: #343a40;">Kelas Saya</h2>
                <p class="text-muted small">Lanjutkan belajar dan tingkatkan keahlian Anda</p>
            </div>

            <div class="d-none d-md-flex gap-2">
                <a href="?filter=all" class="btn btn-filter {{ $filter == 'all' ? 'active' : 'inactive' }}">Semua</a>
                <a href="?filter=active" class="btn btn-filter {{ $filter == 'active' ? 'active' : 'inactive' }}">Aktif</a>
                <a href="?filter=expired" class="btn btn-filter {{ $filter == 'expired' ? 'active' : 'inactive' }}">Expired</a>
            </div>
        </div>

        <div class="row g-4">
            @if (isset($userCourses->data) && count($userCourses->data) > 0)
                @foreach ($userCourses->data as $userCourse)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card card-course h-100 shadow-sm position-relative">
                            <div class="position-relative">
                                <img src="{{ $userCourse->course->thumbnail_image }}" class="card-img-top"
                                     alt="{{ $userCourse->course->name }}" style="height: 160px; object-fit: cover;">

                                <div class="course-overlay">
                                    <a href="/user/detail-kelas/{{ $userCourse->course->id }}" class="btn btn-light fw-bold px-4 shadow-sm" style="border-radius: 50px;">
                                        Lanjutkan <i class="fas fa-play-circle ms-1"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-soft-primary text-primary px-2 py-1" style="font-size: 0.65rem; background-color: #e7f1ff;">
                                        {{ $userCourse->course_category->name }}
                                    </span>
                                    <div class="small">
                                        <i class="fas fa-star text-warning"></i>
                                        <span class="text-muted fw-bold">{{ $userCourse->course->rating }}</span>
                                    </div>
                                </div>

                                <h6 class="card-title fw-bold text-dark mb-2">{{ Str::limit($userCourse->course->name, 40) }}</h6>
                                <p class="card-text text-muted small mb-0">
                                    {{ Str::limit($userCourse->course->description, 55) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <img src="https://illustrations.popsy.co/gray/course-app.svg" alt="Empty" style="width: 220px;" class="mb-3 opacity-50">
                    <h5 class="text-muted fw-bold">
                        {{ $filter == 'expired' ? 'Tidak ada kelas yang expired' : 'Kamu belum memiliki kelas' }}
                    </h5>
                    @if($filter != 'expired')
                        <a href="{{ route('kelas') }}" class="btn btn-primary mt-3 px-4 fw-bold" style="border-radius: 8px;">
                            Cari Kelas Sekarang
                        </a>
                    @endif
                </div>
            @endif
        </div>

        @if(isset($userCourses->pagination) && $userCourses->pagination->total_page > 1)
            <div class="mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $userCourses->pagination->page <= 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="/user/kelas?filter={{ $filter }}&page={{ $userCourses->pagination->page - 1 }}">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $userCourses->pagination->total_page; $i++)
                            <li class="page-item {{ $userCourses->pagination->page === $i ? 'active' : '' }}">
                                <a class="page-link shadow-sm" href="/user/kelas?filter={{ $filter }}&page={{ $i }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $userCourses->pagination->page >= $userCourses->pagination->total_page ? 'disabled' : '' }}">
                            <a class="page-link" href="/user/kelas?filter={{ $filter }}&page={{ $userCourses->pagination->page + 1 }}">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        @endif
    </div>
@endsection

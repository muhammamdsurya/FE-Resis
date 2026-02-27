@extends('layout.userLayout')

@section('content')
<style>
    /* Styling Stat Cards */
    .stat-card {
        border-radius: 15px;
        padding: 20px;
        transition: transform 0.3s ease;
        border: none;
        overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.2;
        position: absolute;
        right: 15px;
        bottom: 10px;
    }

    /* Styling Course Cards (Consistent with previous menus) */
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
    .bg-soft-info { background-color: #e0f7fa; color: #00838f; }
    .bg-soft-warning { background-color: #fff8e1; color: #ff8f00; }
</style>

<div class="container-fluid p-4" style="background-color: #f4f6f9; min-height: 100vh;">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">Halo, {{$full_name}}! 👋</h2>
            <p class="text-muted">Senang melihat Anda kembali. Mari lanjutkan progres belajar hari ini.</p>
        </div>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-lg-3 col-6">
            <div class="card stat-card bg-primary text-white shadow-sm">
                <div class="inner position-relative">
                    <h3 class="fw-bold">{{ count($userCourses->data ?? []) }}</h3>
                    <p class="mb-0">Total Kelas Saya</p>
                    <i class="fas fa-book-reader stat-icon"></i>
                </div>
                <a href="{{ route('user.kelas') }}" class="text-white text-decoration-none mt-3 d-inline-block small">
                    Detail Kelas <i class="fas fa-chevron-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card stat-card bg-soft-warning shadow-sm">
                <div class="inner position-relative text-dark">
                    <h3 class="fw-bold text-warning">{{ count($expired->data ?? []) }}</h3>
                    <p class="mb-0">Kelas Expired</p>
                    <i class="fas fa-history stat-icon"></i>
                </div>
                <a href="{{ route('user.kelas', ['filter' => 'expired']) }}" class="text-warning text-decoration-none mt-3 d-inline-block small">
                    Lihat Histori <i class="fas fa-chevron-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-dark m-0">
                <i class="fas fa-play-circle text-primary me-2"></i>Sedang Dipelajari
            </h4>
        </div>

        @if ($userCourses->data && count($userCourses->data) > 0)
            <div class="row g-4">
                @foreach ($userCourses->data as $index => $userCourse)
                    @if ($index < 4)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-course h-100 shadow-sm position-relative">
                                <div class="position-relative">
                                    <img src="{{ $userCourse->course->thumbnail_image }}" class="card-img-top"
                                         alt="..." style="height: 160px; object-fit: cover;">

                                    <div class="course-overlay">
                                        <a href="/user/detail-kelas/{{ $userCourse->course->id }}"
                                           class="btn btn-light fw-bold px-4 shadow-sm" style="border-radius: 50px;">
                                            Lanjutkan <i class="fas fa-play-circle ms-1"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge px-2 py-1" style="font-size: 0.65rem; background-color: #e7f1ff; color: #007bff;">
                                            {{ $userCourse->course_category->name }}
                                        </span>
                                        <div class="small">
                                            <i class="fas fa-star text-warning"></i>
                                            <span class="text-muted fw-bold">{{ $userCourse->course->rating }}</span>
                                        </div>
                                    </div>
                                    <h6 class="card-title fw-bold text-dark mb-1">{{ $userCourse->course->name }}</h6>
                                    <p class="card-text text-muted small mb-0">
                                        {{ Str::limit($userCourse->course->description, 50) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            @if (count($userCourses->data) > 4)
                <div class="text-center mt-5">
                    <a href="{{ route('user.kelas') }}" class="btn btn-outline-primary px-5 fw-bold shadow-sm" style="border-radius: 10px;">
                        Lihat Semua Kelas Saya <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @endif
        @else
            <div class="col-12 text-center py-5 bg-white shadow-sm rounded-4 mt-2">
                <img src="https://illustrations.popsy.co/gray/home-office.svg" alt="Empty" style="width: 180px;" class="mb-3 opacity-75">
                <h5 class="text-muted">Anda belum memiliki kelas aktif</h5>
                <a href="{{ route('kelas') }}" class="btn btn-primary mt-3 px-4 fw-bold" style="border-radius: 8px;">
                    Mulai Belajar Sekarang
                </a>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('message'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('message') }}',
                icon: 'success',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Opps!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'Tutup'
            });
        @endif
    });
</script>
@endsection

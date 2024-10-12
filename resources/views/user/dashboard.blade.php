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
    <div class="container-fluid mt-2">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ count($userCourses->data) }}</h3>

                        <p>Jumlah Kelas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>10</h3>

                        <p>Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>

                        <p>Diskusi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Example in a Blade template -->
            <!-- Left col -->
            <section class="col-12">
                <div class="card-header mb-3">
                    <h3 class="card-title">
                        <i class="fas fa-book-reader mr-1"></i>
                        Sedang Dipelajari
                    </h3>
                </div><!-- /.card-header -->
                <div class="container-fluid mt-3">
                    <div id="coursesContainer" class="row g-2 mb-5">
                        @if ($userCourses->data && count($userCourses->data) > 0)
                            @if (count($userCourses->data) > 0 || count($userCourses->data) <= 4)
                                @foreach ($userCourses->data as $userCourse)
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <a href="/user/detail-kelas/{{ $userCourse->course->id }}"
                                            class="fs-6 text-decoration-none">
                                            <div class="card h-100 shadow border-0 position-relative"
                                                style="border-radius: 15px; overflow: hidden;">
                                                <img src="{{ $userCourse->course->thumbnail_image }}" class="card-img-top"
                                                    alt="..." style="height: 150px; object-fit: cover;">
                                                <div class="card-body">
                                                    <div class="header-card d-flex justify-content-between mb-3">
                                                        <p class="text-muted fs-6 mb-0"><i
                                                                class="fas fa-star text-warning me-1"></i>4.9
                                                        </p>
                                                        <p class="badge bg-primary fs-6 mb-0">
                                                            {{ $userCourse->course_category->name }}
                                                        </p>
                                                    </div>
                                                    <h5 class="card-title fw-bold text-dark">{{ $userCourse->course->name }}
                                                    </h5>
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
                            <div class="row">
                                <div class="col-12 text-center">
                                    <a href="{{ route('user.kelas') }}" class="btn btn-primary mt-3">
                                        Lihat kelas lainnya
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="col-12 text-center">
                                <h5>Kamu belum membeli kelas</h5>
                                <a href="{{ route('kelas') }}" class="btn btn-primary mt-3">
                                    Beli Kelas
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('message'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('message') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endsection

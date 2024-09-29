@extends('layout.layout')

@section('content')
    <style>
        .card {
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
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
            <div class="row gx-3 gy-4">
                @foreach ($courses->data as $course)
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="{{route('detail.kelas', ['courseId' => $course->course->id])}}">
                            <div class="card h-100 shadow border-0 position-relative"
                                style="border-radius: 15px; overflow: hidden;">
                                <img src="assets/img/values-1.png" class="card-img-top" alt="..."
                                    style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <div class="header-card d-flex justify-content-between mb-3">
                                        <p class="text-muted fs-6 mb-0"><i class="bi bi-star-fill text-warning me-1"></i>4.9
                                        </p>
                                        <p class="badge bg-primary fs-6 mb-0">{{ $course->course_category->name }}</p>
                                    </div>

                                    <h5 class="card-title fw-bold text-dark">{{ $course->course->name }}</h5>
                                    <h6 class="text-success fw-bold mb-3">Rp
                                        {{ number_format($course->course->price, 0, ',', '.') }}</h6>
                                    <p class="card-text text-muted">{{ $course->course->description }}</p>
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


                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li id="btnIncrementPagination" class="page-item"><button class="page-link">Previous</button></li>
                        @for ($i = 1; $i <= $courses->pagination->total_page; $i++)
                            <li class="page-item"><button class="page-link">{{ $i }}</button></li>
                        @endfor
                        <li id="btnDecrementPagination" class="page-item"><button class="page-link">Next</button></li>
                    </ul>
                </nav>


            </div>
        </div>
    @endsection

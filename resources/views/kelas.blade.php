@extends('layout.layout')

@section('content')
    <section class="section">
        <div class="container mt-5 section-title" data-aos="fade-up">
            <p>Kelas Kami<br></p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div id="coursesContainer" class="row g-2">
                @foreach ($courses as $item)
                    <div class="col-lg-3 col-md-4 col-6 mb-4">
                        <a href="detail-kelas/{{ $item['course']['id'] }}" class="text-decoration-none">
                            <div class="card shadow border-light rounded">
                                <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top"
                                    alt="{{ $item['course']['name'] }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="fs-6 mb-0"><i class="bi bi-star-fill text-warning me-1"></i>
                                            {{ $item['course']['rating'] }}
                                        </p>
                                        <p class="fs-6 mb-0 text-muted">{{ $item['course_category']['name'] }}</p>
                                    </div>
                                    <h5 class="card-title mt-2">{{ $item['course']['name'] }}</h5>
                                    <p class="mt-2">{{ $item['course']['description'] }}</p>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <!-- Previous Button -->
                        @if ($pagination['page'] > 1)
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ route('kelas', ['page' => $pagination['page'] - 1]) }}">Previous</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link">Previous</a>
                            </li>
                        @endif

                        <!-- Page Numbers -->
                        @for ($i = 1; $i <= $pagination['total_page']; $i++)
                            <li class="page-item {{ $pagination['page'] == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ route('kelas', ['page' => $i]) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Next Button -->
                        @if ($pagination['page'] < $pagination['total_page'])
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ route('kelas', ['page' => $pagination['page'] + 1]) }}">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link">Next</a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    @endsection

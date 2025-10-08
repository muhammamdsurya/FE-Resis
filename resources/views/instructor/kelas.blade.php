@extends('layout.InstLayout')
@section('title', $title)

@section('content')


    <style>
        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            filter: brightness(0.9);
            /* Darkens the card on hover */
        }

        .card img {
            height: 100px;
            object-fit: cover;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card .card-body {
            background-color: #fff;
        }

        .text-muted {
            font-size: 0.875rem;
        }

        .card .text-warning {
            font-size: 1rem;
        }
    </style>

    <div class="container mt-3">
        <div class="row mb-3">
            <div class="col-7">
                <div class="search-form" style="width: 100%">
                    <form class="d-flex" role="search" method="GET" action="{{ route('instructor.kelas') }}">
                        <input id="searchInput" class="form-control" type="search" placeholder="Cari Kelas..."
                            name="q" aria-label="Search" value="{{ request('q') }}">
                        <button type="submit" class="btn btn-primary ml-2">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="coursesContainer" class="row gx-2 gy-0">
            @if (empty($courses['data']))
                <div class="col-12 text-center">
                    <h4>Data kelas kosong</h4>
                </div>
            @endif
            {{-- Jika tidak ada pagination --}}
            @if ($courses['data'] != null)
                @foreach ($courses['data'] as $item)
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="{{ route('instructor.detail-kelas', ['id' => $item['course']['id']]) }}"
                            class="text-decoration-none">
                            <div class="card shadow-sm border-light rounded">
                                <img src="{{ $item['course']['thumbnail_image'] }}" class="card-img-top"
                                    alt="{{ $item['course']['thumbnail_image'] }}"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="rating d-flex align-items-center me-2">
                                            <i class="fas fa-star text-warning me-1"></i>
                                            <span class="fs-6 mb-0 text-muted">{{ $item['course']['rating'] }}</span>
                                        </div>
                                        <span class="badge bg-primary small text-center px-2 py-1"
                                            style="white-space: normal;">
                                            {{ $item['course_category']['name'] }}
                                        </span>
                                    </div>

                                    <h5 class="card-title fw-bold fs-6 mt-2">
                                        {{ $item['course']['name'] }}
                                    </h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>


        @if ($pagination ?? false)
            <!-- Tampilkan pagination hanya jika pagination tersedia -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <!-- Previous Button -->
                    @if ($pagination['page'] > 1)
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ route('instructor.kelas', ['page' => $pagination['page'] - 1]) }}">Previous</a>
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
                                href="{{ route('instructor.kelas', ['page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Button -->
                    @if ($pagination['page'] < $pagination['total_page'])
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ route('instructor.kelas', ['page' => $pagination['page'] + 1]) }}">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link">Next</a>
                        </li>
                    @endif
                </ul>
            </nav>
        @endif

    @endsection

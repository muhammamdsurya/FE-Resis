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
            <p>Paket Bundling<br></p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gx-2 gy-4">
                @if ($bundling->data)
                    @foreach ($bundling->data as $bundling)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="{{ route('detail.bundling', ['courseBundleId' => $bundling->id]) }}">
                                <div class="card h-100 shadow border-0 position-relative"
                                    style="border-radius: 15px; overflow: hidden;">
                                    <img src="{{ $bundling->thumbnail_image }}" class="card-img-top" alt="..."
                                        style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <div class="header-card d-flex justify-content-between mb-3">
                                            <h6 class="text-success fw-bold mb-3">Rp
                                                {{ number_format($bundling->price, 0, ',', '.') }}</h6>
                                        </div>

                                        <h5 class="card-title fw-bold text-dark">{{ $bundling->name }}</h5>

                                        <p class="card-text text-muted">{{ Str::limit($bundling->description, 50) }}</p>
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
                        <h4 class="text-dark">Belum ada paket bundling</h4>
                    </div>
                @endif

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <!-- Previous Button -->
                        @if ($pagination->page > 1)
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ route('bundling', ['page' => $pagination->page - 1]) }}">Previous</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link">Previous</a>
                            </li>
                        @endif

                        <!-- Page Numbers -->
                        @for ($i = 1; $i <= $pagination->total_page; $i++)
                            <li class="page-item {{ $pagination->page === $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ route('bundling', ['page' => $i]) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Next Button -->
                        @if ($pagination->page < $pagination->total_page)
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ route('bundling', ['page' => $pagination->page + 1]) }}">Next</a>
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

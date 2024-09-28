@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <style>
        .bundle-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }


        .bundle-card:hover {
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

        .text-muted {
            font-size: 0.875rem;
        }
    </style>

    <div class="container mt-3">
        <div class="row mb-3">
            <div class="col-7">
                <div class="search-form" style="width: 100%">
                    <form class="d-flex" role="search">
                        <input id="searchInput" class="form-control" type="search" placeholder="Cari Paket.."
                            aria-label="Search">
                    </form>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-end">
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#modal-bundling">
                    <i class="fas fa-plus mr-1"></i>Tambah
                </button>
            </div>
        </div>

        <!-- Card Grid -->
        <div class="row g-2">
            @foreach ($bundles as $row)
                <div class="col-6 col-lg-3 col-md-4 col-sm-6">
                    <a href="detail-bundling/{{ $row['id'] }}" class="text-decoration-none">
                        <div class="card bundle-card shadow-sm" style="width: 100%;">
                            <img src="{{ $row['thumbnail_image'] }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <div class="header-card d-flex justify-content-between">
                                    <p class="ml-auto fs-6 price">Rp{{ number_format($row['price'], 0, ',', '.') }}</p>
                                </div>
                                <h5 class="card-title">{{ $row['name'] }}</h5>
                                <p class="card-text">{{ $row['description'] }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            <nav aria-label="Page navigation example pb-3">
                <ul class="pagination justify-content-center">
                    <!-- Previous Button -->
                    @if ($pagination['page'] > 1)
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ route('admin.bundling', ['page' => $pagination['page'] - 1]) }}">Previous</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>
                    @endif

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $pagination['total_page']; $i++)
                        <li class="page-item {{ $pagination['page'] == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ route('admin.bundling', ['page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Button -->
                    @if ($pagination['page'] < $pagination['total_page'])
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ route('admin.bundling', ['page' => $pagination['page'] + 1]) }}">Next</a>
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

    <!-- Modal -->
    <div class="modal fade" id="modal-bundling" tabindex="-1" aria-labelledby="modal-defaultLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-defaultLabel">Tambah Bundling</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('bundle.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="bundleName" placeholder="Nama Bundling"
                                        name="name" required>
                                    <label for="bundleName">Nama Bundling</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="bundlePrice" placeholder="Harga"
                                        name="price" required>
                                    <label for="bundlePrice">Harga</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea class="form-control" id="bundleDescription" placeholder="Deskripsi" name="description" style="height: 100px"
                                    required></textarea>
                                <label for="bundleDescription">Deskripsi</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bundleImage" class="form-label">Upload Gambar</label>
                            <input type="file" class="form-control" id="bundleImage" name="image" accept="image/*"
                                required>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert2 CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

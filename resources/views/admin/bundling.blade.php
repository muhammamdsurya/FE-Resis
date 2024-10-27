@extends('layout.adminLayout')
@section('title', $title)


@section('buttons')
    <a href="{{ route('admin.dataBundling.download') }}" class="btn btn-primary mb-0 d-flex align-items-center">
        <i class="fas fa-download d-inline me-1 "></i> <!-- Ikon untuk mobile -->
        <span class="d-none d-lg-inline">Download CSV</span> <!-- Teks untuk desktop -->
    </a>
@endsection

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
                    <form class="d-flex" role="search" method="GET" action="{{ route('admin.bundling') }}">
                        <input id="searchInput" class="form-control" type="search" placeholder="Cari Bundling..."
                            name="q" aria-label="Search" value="{{ request('q') }}">
                        <button type="submit" class="btn btn-primary ml-2 d-flex align-items-center">
                            <i class="fas fa-search"></i> <!-- Ikon pencarian -->
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-end">
                <button type="button" class="btn btn-success d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#modal-bundling">
                    <i class="fas fa-plus d-inline me-1"></i><span class="d-none d-lg-inline">Tambah</span>
                </button>
            </div>
        </div>

        <div id="coursesContainer" class="row gx-2 gy-0">
            @if ($bundles['data'])
                @if ($pagination ?? false) {{-- Jika ada pagination --}}
                    @foreach ($bundles['data'] as $item)
                        {{-- Akses data dari bundles['data'] --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="{{ route('detail-bundling', ['id' => $item['id']]) }}" class="text-decoration-none">
                                <div class="card bundle-card shadow-sm" style="width: 100%;">
                                    <img src="{{ $item['thumbnail_image'] }}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <div class="header-card d-flex justify-content-between">
                                            <p class="ml-auto fs-6 price">Rp{{ number_format($item['price'], 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <h5 class="card-title">{{ $item['name'] }}</h5>
                                        <p class="card-text">{{ Str::limit($item['description'], 20) }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            @else
                <div class="col-12 text-center">
                    <h4>Data kelas kosong</h4>
                </div>
            @endif
            {{-- Jika tidak ada pagination --}}
            @if ($bundles['data'] != null)
                @foreach ($bundles['data'] as $item)
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="{{ route('detail-bundling', ['id' => $item['id']]) }}" class="text-decoration-none">
                            <div class="card bundle-card shadow-sm" style="width: 100%;">
                                <img src="{{ $item['thumbnail_image'] }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <div class="header-card d-flex justify-content-between">
                                        <p class="ml-auto fs-6 price">Rp{{ number_format($item['price'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <h5 class="card-title">{{ $item['name'] }}</h5>
                                    <p class="card-text">{{ $item['description'] }}</p>
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
                            <a class="page-link"
                                href="{{ route('admin.bundling', ['page' => $i]) }}">{{ $i }}</a>
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
        @endif

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
                    <form id="bundlingPost" method="POST" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" id="priceInput" placeholder="Harga"
                                        name="price" required>
                                    <label for="priceInput">Harga</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea class="form-control" id="bundleDescription" placeholder="Deskripsi" name="description"
                                    style="height: 100px" required></textarea>
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
        document.getElementById('priceInput').addEventListener('input', function(e) {
            var value = e.target.value;
            value = value.replace(/\D/g, ''); // Menghapus karakter selain angka
            value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
            e.target.value = value.replace('Rp', '')
                .trim(); // Menghilangkan 'Rp' dan hanya menampilkan angka dengan titik
        });

        // Pastikan format angka asli diambil saat form dikirim
        document.querySelector('form').addEventListener('submit', function() {
            var priceInput = document.getElementById('priceInput');
            priceInput.value = priceInput.value.replace(/\./g, ''); // Menghapus titik sebelum dikirimkan ke server
        });

        $('#bundlingPost').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman default

            // Membuat objek FormData
            const formData = new FormData(this);

            // Melihat isi FormData
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }
            false;
            createOverlay('Proses...'); // Tampilkan overlay

            // Mengirim data formulir menggunakan AJAX
            $.ajax({
                url: '{{ route('bundle.post') }}', // Menggunakan URL dari atribut action
                type: 'POST',
                data: formData, // Mengambil data dari formulir
                processData: false, // Mencegah jQuery mengubah data
                contentType: false, // Mencegah jQuery menetapkan konten
                success: function(response) {
                    gOverlay.hide();
                    console.log(response);
                    // Lakukan sesuatu setelah berhasil
                    Swal.fire('Sukses!', 'Data berhasil ditambahkan.', 'success');
                    // Reload halaman atau arahkan ke halaman lain jika diperlukan
                    location.reload();
                },
                error: function(xhr, status, error) {
                    gOverlay.hide();
                    console.error('Error:', xhr.responseText);
                    // Menampilkan pesan error
                    Swal.fire('Error!',
                        'Terjadi kesalahan saat mengirim data. Silakan coba lagi.',
                        'error');
                },
            });
        });
    </script>



@endsection

@extends('layout.adminLayout')
@section('title', $title)


@section('content')

    <style>
        .course-card-modern {
            border-radius: 20px !important;
            transition: all 0.3s ease;
            border: none !important;
        }

        .course-card-modern:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08) !important;
        }

        .img-wrapper-custom {
            position: relative;
            padding-top: 56.25%;
            /* 16:9 Ratio */
            overflow: hidden;
            border-radius: 20px 20px 0 0;
        }

        .img-wrapper-custom img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .text-limit-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.8rem;
            line-height: 1.4;
        }

        .badge-soft-primary {
            background-color: #eef4ff;
            color: #0d6efd;
            font-weight: 500;
            font-size: 11px;
        }

        .pagination {
            gap: 8px;
            /* Memberi jarak antar kotak nomor */
        }

        .pagination .page-item .page-link {
            border: none;
            border-radius: 10px !important;
            /* Membuat kotak agak membulat */
            color: #6c757d;
            padding: 8px 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            /* Warna utama biru */
            color: white;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
            transform: translateY(-2px);
        }

        .pagination .page-item:not(.active):hover .page-link {
            background-color: #e9ecef;
            color: #0d6efd;
            transform: translateY(-2px);
        }

        .pagination .page-item.disabled .page-link {
            background-color: transparent;
            opacity: 0.5;
            border: 1px solid #eee;
        }
    </style>

    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0" style="color: #343a40;">Data Kelas</h2>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-7">
                <div class="search-form" style="width: 100%">
                    <form class="d-flex" role="search" method="GET" action="{{ route('admin.kelas') }}">
                        <input id="searchInput" class="form-control" type="search" placeholder="Cari Kelas..."
                            name="q" aria-label="Search" value="{{ request('q') }}">
                        <button type="submit" class="btn btn-primary ml-2 d-flex align-items-center">
                            <i class="fas fa-search"></i> <!-- Ikon pencarian -->
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-end align-items-center gap-1">
                <a href="{{ route('admin.dataCourse.download') }}" class="btn btn-primary mb-0 d-flex align-items-center">
                    <i class="fas fa-download d-inline me-1 "></i> <!-- Ikon untuk mobile -->
                    <span class="d-none d-lg-inline">Download CSV</span> <!-- Teks untuk desktop -->
                </a>
                <button type="button" class="btn btn-info d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#modal-kelas">
                    <i class="fas fa-book d-inline me-1"></i> <!-- Ikon Kelas untuk mobile -->
                    <span class="d-none d-lg-inline">Kelas</span> <!-- Teks Kelas untuk desktop -->
                </button>
                <button type="button" class="btn btn-success d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#modal-default">
                    <i class="fas fa-graduation-cap d-inline me-1"></i> <!-- Ikon Jenjang untuk mobile -->
                    <span class="d-none d-lg-inline">Jenjang</span> <!-- Teks Jenjang untuk desktop -->
                </button>
            </div>
        </div>


        <div id="coursesContainer" class="row g-4">
            @php
                // Normalisasi data untuk menangani kedua kondisi (pagination vs biasa)
                $dataItems = $pagination ?? false ? $courses['data'] ?? [] : $courses ?? [];
            @endphp

            @forelse($dataItems as $item)
                @php
                    // Mapping variabel agar konsisten
                    $c = $pagination ?? false ? $item['course'] : $item;
                    $cat = $pagination ?? false ? $item['course_category'] : $item['course_category'] ?? null;
                    $instruktur = $item['instructor'] ?? null;
                @endphp

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm course-card-modern">
                        <div class="img-wrapper-custom">
                            <img src="{{ $c['thumbnail_image'] }}" alt="Course Thumbnail">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-white text-dark shadow-sm rounded-pill py-1 px-2">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <span class="small fw-bold">{{ $c['rating'] > 0 ? $c['rating'] : 'New' }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-3 d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge badge-soft-primary px-2 py-1 rounded">
                                    {{ $cat['name'] ?? 'General' }}
                                </span>
                            </div>

                            <h6 class="fw-bold text-dark text-limit-2 mb-3">
                                {{ $c['name'] }}
                            </h6>

                            @if ($instruktur)
                                <div class="d-flex align-items-center mb-3 mt-auto">
                                    <img src="{{ $instruktur['photo_profile'] ?? 'https://ui-avatars.com/api/?name=' . $instruktur['full_name'] }}"
                                        class="rounded-circle me-2" width="25" height="25"
                                        style="object-fit: cover;">
                                    <small class="text-muted text-truncate">{{ $instruktur['full_name'] }}</small>
                                </div>
                            @endif

                            <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-bold text-primary">
                                        Rp{{ number_format($c['price'] ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                                <a href="{{ route('detail-kelas', ['id' => $c['id']]) }}"
                                    class="btn btn-primary rounded-pill btn-sm px-3 fw-bold shadow-sm">
                                    Detail <i class="fas fa-arrow-right ms-1" style="font-size: 10px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-light rounded-4 border border-dashed">
                        <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada kelas yang ditemukan</h5>
                    </div>
                </div>
            @endforelse
        </div>


        @if ($pagination ?? false)
            <nav aria-label="Page navigation" class="mt-5">
                <ul class="pagination justify-content-center align-items-center">

                    <li class="page-item {{ $pagination['page'] <= 1 ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ $pagination['page'] > 1 ? route('admin.kelas', ['page' => $pagination['page'] - 1]) : '#' }}"
                            aria-label="Previous">
                            <i class="fas fa-chevron-left small"></i>
                        </a>
                    </li>

                    @php
                        $start = max(1, $pagination['page'] - 2);
                        $end = min($pagination['total_page'], $pagination['page'] + 2);
                    @endphp

                    @if ($start > 1)
                        <li class="page-item d-none d-md-block">
                            <a class="page-link" href="{{ route('admin.kelas', ['page' => 1]) }}">1</a>
                        </li>
                        @if ($start > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        <li class="page-item {{ $pagination['page'] == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ route('admin.kelas', ['page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($end < $pagination['total_page'])
                        @if ($end < $pagination['total_page'] - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item d-none d-md-block">
                            <a class="page-link"
                                href="{{ route('admin.kelas', ['page' => $pagination['total_page']]) }}">{{ $pagination['total_page'] }}</a>
                        </li>
                    @endif

                    <li class="page-item {{ $pagination['page'] >= $pagination['total_page'] ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ $pagination['page'] < $pagination['total_page'] ? route('admin.kelas', ['page' => $pagination['page'] + 1]) : '#' }}"
                            aria-label="Next">
                            <i class="fas fa-chevron-right small"></i>
                        </a>
                    </li>

                </ul>
            </nav>
        @endif

        <!-- Modal Jenjang -->
        <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="modal-defaultLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-defaultLabel">Tambah Jenjang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <input type="text" class="form-control" id="levelInput" placeholder="Masukan Jenjang"
                                    name="name">
                                <button type="button" id="tambahJenjang" class="btn btn-primary ml-2">
                                    <i class="fas fa-plus p-1"></i>
                                </button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="categoriesTable" class="table table-hover table-striped table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Jenjang</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="categoriesBody">
                                    <!-- Data will be populated here by AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Kelas -->
        <div class="modal fade" id="modal-kelas" tabindex="-1" aria-labelledby="modal-defaultLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-defaultLabel">Tambah Kelas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="kelasForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nameInput"
                                            placeholder="Nama Kelas" name="name" required>
                                        <label for="nameInput">Nama Kelas</label>
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

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="categorySelect" name="category_id" required>
                                            <option value="" disabled selected>Pilih Jenjang</option>
                                            <!-- Options should be populated dynamically -->
                                        </select>
                                        <label for="categorySelect">Jenjang</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="instructorSelect" name="instructor_id" required>
                                            <option value="" disabled selected>Pilih Instruktur</option>
                                            <!-- Options should be populated dynamically -->
                                        </select>
                                        <label for="instructorSelect">Instruktur</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="purposeInput" placeholder="Tujuan" name="purpose" rows="3" required></textarea>
                                        <label for="purposeInput">Tujuan</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="descriptionInput" placeholder="Deskripsi" name="description" rows="3"
                                            required></textarea>
                                        <label for="descriptionInput">Deskripsi</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="thumbnailInput" class="form-label">Thumbnail</label>
                                <input type="file" class="form-control" id="thumbnailInput" name="image"
                                    accept="image/*" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap Modal HTML -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editCategoryForm">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="categoryName" required>
                            </div>
                            <input type="hidden" id="categoryId">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                        <button type="button" class="btn btn-primary" id="saveCategoryBtn">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
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
    </script>

    <script>
        $(document).ready(function() {
            let categoriesData = {!! $categories !!};
            let instructorsData = {!! $instructors !!};

            // Get the select element
            const categorySelect = document.getElementById('categorySelect');
            const instructorSelect = document.getElementById('instructorSelect');

            // Populate the select element with options
            if (categoriesData != null) {
                categoriesData.forEach(category => {
                    if (category) {
                        // Create a new option element
                        let option = document.createElement('option');
                        option.value = category.id; // Set the value to the category ID
                        option.textContent = category.name; // Set the display text to the category name

                        // Append the option to the select element
                        categorySelect.appendChild(option);
                    } else {
                        // Create a new option element
                        let option = document.createElement('option');
                        option.value = 'Belum ada Kategori'; // Set the value to the category ID
                        option.textContent =
                            'Belum ada Kategori'; // Set the display text to the category name

                        // Append the option to the select element
                        categorySelect.appendChild(option);
                    }
                });
            }

            // Populate the select element with options
            // Assuming `instructorsData` is an array of objects, each containing an 'instructor' object.
            if (instructorsData != null) {


                instructorsData.forEach(item => {
                    const instructor = item.instructor; // Access the 'instructor' object inside the item

                    // Check if the instructor object exists
                    if (instructor) {
                        // Create a new option element
                        let option = document.createElement('option');
                        option.value = instructor.id; // Set the value to the instructor ID
                        option.textContent = item
                            .full_name; // Set the display text to the instructor's full name

                        // Append the option to the select element
                        instructorSelect.appendChild(option);

                    } else {
                        // Create a new option element
                        let option = document.createElement('option');
                        option.value = 'Belum ada Instruktur'; // Set the value to the instructor ID
                        option.textContent =
                            'Belum ada Instruktur'; // Set the display text to the instructor's full name

                        // Append the option to the select element
                        instructorSelect.appendChild(option);
                    }
                });
            }

            // Fungsi untuk memuat kategori ke dalam tabel
            const loadCategories = () => {
                $('#categoriesBody').empty(); // Bersihkan konten tabel sebelumnya

                // Periksa apakah ada data di categoriesData
                if (categoriesData != null) {
                    // Jika data tersedia, tambahkan setiap kategori ke dalam tabel
                    categoriesData.forEach((category, index) => {
                        $('#categoriesBody').append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${category.name}</td>
                    <td>
                        <button class="btn btn-warning edit-btn btn-sm" data-id="${category.id}">
                            <i class="fas fa-edit"></i> <!-- Ikon Edit -->
                            <span class="d-none d-sm-inline ml-1">Edit</span> <!-- Teks untuk desktop -->
                        </button>
                        <button class="btn btn-danger delete-btn btn-sm" data-id="${category.id}">
                            <i class="fas fa-trash"></i> <!-- Ikon Hapus -->
                            <span class="d-none d-sm-inline ml-1">Hapus</span> <!-- Teks untuk desktop -->
                        </button>
                    </td>
                </tr>
            `);
                    });
                } else {
                    // Jika tidak ada data, tambahkan baris placeholder
                    $('#categoriesBody').append(`
            <tr>
                <td colspan="3" class="text-center">Belum ada jenjang</td>
            </tr>
        `);
                }
            };

            loadCategories();

            $('#kelasForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah pengiriman default

                // Membuat objek FormData
                const formData = new FormData(this);


                createOverlay('Proses...'); // Tampilkan overlay

                // Mengirim data formulir menggunakan AJAX
                $.ajax({
                    url: '{{ route('kelas.post') }}', // Menggunakan URL dari atribut action
                    type: 'POST',
                    data: formData, // Mengambil data dari formulir
                    processData: false, // Mencegah jQuery mengubah data
                    contentType: false, // Mencegah jQuery menetapkan konten
                    success: function(response) {
                        gOverlay.hide();
                        // Lakukan sesuatu setelah berhasil
                        Swal.fire('Sukses!', response.message, 'success');
                        // Reload halaman atau arahkan ke halaman lain jika diperlukan
                        // Tunggu 1.5 detik sebelum reload
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
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
            // Handle the Edit button click
            $('#categoriesBody').on('click', '.edit-btn', function() {
                const categoryId = $(this).data('id');
                const row = $(this).closest('tr');

                // Get the current category name from the row
                const categoryName = row.find('td:nth-child(2)').text();

                // Populate the modal form
                $('#categoryName').val(categoryName);
                $('#categoryId').val(categoryId);

                // Show the modal
                $('#editCategoryModal').modal('show');
            });

            $('#saveCategoryBtn').on('click', function() {
                const newName = $('#categoryName').val();
                const categoryId = $('#categoryId').val();
                const token = $("meta[name='csrf-token']").attr("content");

                // Make an AJAX request to update the category
                createOverlay("Proses...");
                $.ajax({
                    url: `/admin/kelas/${categoryId}/edit`,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: {
                        "name": newName
                    },
                    success: function(response) {
                        gOverlay.hide()
                        $('#editCategoryModal').modal('hide'); // Hide the modal
                        Swal.fire('Berhasil!', 'Kategori berhasil diupdate.',
                            'success');
                        // Tunggu 1.5 detik sebelum reload
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    },
                    error: function(xhr, status, error) {
                        gOverlay.hide()
                        console.error('Error updating category:', xhr.responseText);
                        Swal.fire('Error!',
                            'Terjadi kesalahan saat memperbarui kategori.',
                            'error');
                    }
                });
            });

            $('#tambahJenjang').on('click', function(event) {
                event.preventDefault();
                console.log("klik");
                const levelInput = $('#levelInput');
                const level = levelInput.val().trim();

                if (level === '') {
                    Swal.fire('Oops!', 'Masukkan jenjang terlebih dahulu!', 'error');
                    return;
                }

                const data = {
                    name: level
                };


                // Make the AJAX request to add a new category
                createOverlay("Proses...");
                $.ajax({
                    url: '{{ route('categories.post') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content")
                    },
                    data: data,
                    success: function(response) {
                        gOverlay.hide()
                        Swal.fire('Berhasil', 'Jenjang berhasil ditambahkan!',
                            'success');
                        // Tunggu 1.5 detik sebelum reload
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    },
                    error: function(xhr, status, error) {
                        gOverlay.hide()
                        console.error('Error adding category:', xhr.responseText);
                        Swal.fire('Oops!',
                            'Terjadi kesalahan saat menambahkan jenjang!',
                            'error');
                    }
                });
            });

            $('#categoriesBody').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                const token = $("meta[name='csrf-token']").attr("content");
                const categoryId = $(this).data('id');

                Swal.fire({
                    text: "Apa kamu yakin menghapus ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make an AJAX request to delete the category
                        createOverlay("Proses...");
                        $.ajax({
                            url: `/admin/kelas/${categoryId}/destroy`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            success: function(response) {
                                gOverlay.hide()
                                Swal.fire('Dihapus!',
                                    'Kategori berhasil dihapus.',
                                    'success');
                                // Tunggu 1.5 detik sebelum reload
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            },
                            error: function(xhr, status, error) {
                                gOverlay.hide()
                                Swal.fire('Error!',
                                    'Terjadi kesalahan saat menghapus kategori.',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>


@endsection

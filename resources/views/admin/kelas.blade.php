@extends('layout.adminLayout')
@section('title', $title)


@section('buttons')
    <a href="{{ route('admin.dataCourse.download') }}" class="btn btn-primary mb-0 d-flex align-items-center">
        <i class="fas fa-download d-inline me-1 "></i> <!-- Ikon untuk mobile -->
        <span class="d-none d-lg-inline">Download CSV</span> <!-- Teks untuk desktop -->
    </a>
@endsection

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

        .card .card-body {
            background-color: #fff;
        }

        .card .text-warning {
            font-size: 1rem;
        }
    </style>

    <div class="container mt-3">
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


        <div id="coursesContainer" class="row gx-2 gy-0">
            @if ($pagination ?? false) {{-- Jika ada pagination --}}
                @if ($courses['data'])
                    @foreach ($courses['data'] as $item)
                        {{-- Akses data dari courses['data'] --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="{{ route('detail-kelas', ['id' => $item['course']['id']]) }}"
                                class="text-decoration-none">
                                <div class="card shadow-sm border-light rounded">
                                    <img src="{{ $item['course']['thumbnail_image'] }}" class="card-img-top"
                                        alt="{{ $item['course']['thumbnail_image'] }}">
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
                @else
                    <div class="col-12 text-center">
                        <h4>Data kelas kosong</h4>
                    </div>
                @endif
            @else
                {{-- Jika tidak ada pagination --}}
                @if ($courses != null)
                    @foreach ($courses as $item)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="{{ route('detail-kelas', ['id' => $item['id']]) }}" class="text-decoration-none">
                                <div class="card shadow-sm border-light rounded">
                                    <img src="{{ $item['thumbnail_image'] }}" class="card-img-top"
                                        alt="{{ $item['thumbnail_image'] }}">
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
                                href="{{ route('admin.kelas', ['page' => $pagination['page'] - 1]) }}">Previous</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>
                    @endif

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $pagination['total_page']; $i++)
                        <li class="page-item {{ $pagination['page'] == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ route('admin.kelas', ['page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Button -->
                    @if ($pagination['page'] < $pagination['total_page'])
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ route('admin.kelas', ['page' => $pagination['page'] + 1]) }}">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link">Next</a>
                        </li>
                    @endif
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

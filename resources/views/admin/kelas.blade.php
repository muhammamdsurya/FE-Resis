@extends('layout.adminLayout')
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

    <div class="container-fluid mt-3">
        <div class="row mb-3">
            <div class="col-7">
                <div class="search-form" style="width: 100%">
                    <form class="d-flex" role="search" method="GET" action="{{ route('admin.kelas') }}">
                        <input id="searchInput" class="form-control" type="search" placeholder="Tambah Kelas..."
                            name="q" aria-label="Search" value="{{ request('q') }}">
                        <button type="submit" class="btn btn-primary ml-2">Search</button>
                    </form>

                </div>
            </div>
            <div class="col-5 d-flex justify-content-end gap-1 pl-2">
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#modal-kelas">
                    <i class="fas fa-plus mr-1"></i>Kelas
                </button>
                <button type="button" class="btn btn-success d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#modal-default">
                    <i class="fas fa-plus mr-1"></i>Jenjang
                </button>

                <!-- Modal Jenjang -->
                <div class="modal fade" id="modal-default" tabindex="-1" aria-labelledby="modal-defaultLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-defaultLabel">Tambah Jenjang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <input type="text" class="form-control" id="levelInput"
                                            placeholder="Masukan Jenjang" name="name">

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
                                        <tbody>
                                            <!-- DataTable will handle appending rows dynamically -->
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('kelas.post') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="nameInput"
                                                    placeholder="Class Name" name="name">
                                                <label for="nameInput">Nama Kelas</label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" id="priceInput"
                                                    placeholder="Price" name="price">
                                                <label for="priceInput">Harga</label>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <select class="form-control" id="categorySelect" name="category_id">
                                                    <!-- Options should be populated dynamically -->
                                                </select>
                                                <label for="categorySelect">Jenjang</label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                {{-- <input type="text" name="instructor_id"> --}}
                                                <select class="form-control" id="instructorSelect" name="instructor_id">
                                                    <!-- Options should be populated dynamically -->
                                                </select>
                                                <label for="instructorSelect">Instruktur</label>
                                            </div>
                                        </div>



                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" id="purposeInput" placeholder="Purpose" name="purpose" rows="3"></textarea>
                                                <label for="purposeInput">Tujuan</label>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" id="descriptionInput" placeholder="Description" name="description" rows="3"></textarea>
                                                <label for="descriptionInput">Deskripsi</label>
                                            </div>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="coursesContainer" class="row g-2">
                @if ($pagination ?? false) {{-- Jika ada pagination --}}
                    @foreach ($courses['data'] as $item) {{-- Akses data dari courses['data'] --}}
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="{{ route('admin.detailKelas', ['CourseId' => $item['course']['id']]) }}" class="text-decoration-none">
                                <div class="card shadow-sm border-light rounded">
                                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top"
                                         alt="{{ $item['course']['name'] }}"
                                         style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="fs-6 mb-0">
                                                <i class="fas fa-star text-warning me-1"></i>{{ $item['course']['rating'] }}
                                            </p>
                                            <p class="fs-6 mb-0 text-muted">{{ $item['course_category']['name'] }}</p>
                                        </div>
                                        <h5 class="card-title mt-2">{{ $item['course']['name'] }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else {{-- Jika tidak ada pagination --}}
                    @foreach ($courses as $item)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="{{ route('admin.detailKelas', ['CourseId' => $item['course']['id']]) }}" class="text-decoration-none">
                                <div class="card shadow-sm border-light rounded">
                                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top"
                                         alt="{{ $item['name'] }}"
                                         style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="fs-6 mb-0">
                                                <i class="fas fa-star text-warning me-1"></i>{{ $item['rating'] }}
                                            </p>
                                            <p class="fs-6 mb-0 text-muted">{{ $item['course_category_id'] }}</p>
                                        </div>
                                        <h5 class="card-title mt-2">{{ $item['name'] }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>




            <!-- Bootstrap Modal HTML -->
            <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
                                <a class="page-link"
                                    href="{{ route('admin.kelas', ['page' => $i]) }}">{{ $i }}</a>
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



        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                let categoriesData = {!! $categories !!};
                let instructorsData = {!! $instructors !!};

                // Get the select element
                const categorySelect = document.getElementById('categorySelect');
                const instructorSelect = document.getElementById('instructorSelect');

                // Populate the select element with options
                categoriesData.forEach(category => {
                    // Create a new option element
                    let option = document.createElement('option');
                    option.value = category.id; // Set the value to the category ID
                    option.textContent = category.name; // Set the display text to the category name

                    // Append the option to the select element
                    categorySelect.appendChild(option);
                });

                // Populate the select element with options
                // Assuming `instructorsData` is an array of objects, each containing an 'instructor' object.
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

                        console.log("Instructor:", item.full_name, instructor.id);
                    } else {
                        console.error("Instructor data not found in item:", item);
                    }
                });

                setTimeout(function() {
                    let table = $('#categoriesTable').DataTable({
                        data: categoriesData,
                        pageLength: 5, // Display 2 records per page
                        ordering: true, // Keep ordering functionality
                        searching: false, // Keep search functionality
                        lengthChange: false, // Disable page length options dropdown
                        info: false, // Remove info like "Showing 1 to 2 of 5 entries"
                        paging: true, // Enable pagination
                        columns: [{
                                data: null,
                                render: function(data, type, row, meta) {
                                    return meta.row + 1; // Auto-incrementing number
                                }
                            },
                            {
                                data: 'name' // Assuming 'name' refers to the category name
                            },
                            {
                                data: 'id',
                                render: function(data, type, row) {
                                    return `
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-btn" data-id="${data}">Hapus</a>
                        <a href="javascript:void(0)" class="btn btn-success btn-sm edit-btn" data-id="${data}">Edit</a>
                    `;
                                }
                            }
                        ],
                        dom: 'tip', // 'tip' = Table, Info, Pagination (hides other controls)
                        autoWidth: false, // Automatically adjust column widths to fit the table width
                    });
                    // Handle the Edit button click
                    $('#categoriesTable').on('click', '.edit-btn', function(e) {
                        e.preventDefault(); // Prevent the default anchor behavior

                        // Get the row that contains the clicked button
                        let row = $(this).closest('tr');
                        let rowData = table.row(row).data(); // Get the DataTable row data

                        // Extract the 'name' value and 'id' from the row data
                        let currentName = rowData.name;
                        let post_id = $(this).data('id');

                        // Populate the modal form with the current name and category ID
                        $('#categoryName').val(currentName);
                        $('#categoryId').val(post_id);

                        // Show the modal
                        $('#editCategoryModal').modal('show');
                    });
                }, 100);


                $('#saveCategoryBtn').on('click', function() {
                    // Get the new category name and ID
                    let newName = $('#categoryName').val();
                    let post_id = $('#categoryId').val();
                    let token = $("meta[name='csrf-token']").attr("content");

                    // Make an AJAX request to update the item
                    $.ajax({
                        url: `/admin/kelas/${post_id}`,
                        type: 'PUT',
                        cache: false,
                        data: {
                            "_token": token,
                            "name": newName
                        },
                        success: function(response) {
                            $('#editCategoryModal').modal('hide'); // Hide the modal

                            Swal.fire(
                                'Updated!',
                                'Your category has been updated.',
                                'success'
                            );

                            // Reload the DataTable to reflect changes
                            $('#categoriesTable').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'There was an error updating the category.',
                                'error'
                            );
                        }
                    });
                });


                $('#tambahJenjang').on('click', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    const levelInput = $('#levelInput');

                    // Trim and validate the input
                    const level = levelInput.val().trim();
                    if (level === '') {
                        Swal.fire('Oops!', 'Masukan jenjang terlebih dahulu!.', 'error');
                        return;
                    }

                    const data = {
                        name: level,
                    };

                    // Make the AJAX request directly to the API endpoint
                    $.ajax({

                        url: '{{ route('categories.post') }}', // Direct API endpoint
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        data: JSON.stringify(data),
                        success: function(response) {
                            console.log("data:", response); // Log the response for debugging
                            Swal.fire('Berhasil', 'jenjang berhasil ditambahkan!.', 'success');
                            $('#categoriesTable').DataTable().ajax.reload();

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error); // Log the error for debugging
                            console.error('Response Text:', xhr.responseText);
                            Swal.fire('Oops!', 'jenjang masih kosong!.', 'error');
                        }
                    });

                });


                $('#categoriesTable').on('click', '.delete-btn', function(e) {
                    e.preventDefault(); // Prevent the default anchor behavior

                    let post_id = $(this).data('id');
                    let token = $("meta[name='csrf-token']").attr("content");

                    if ($(this).hasClass('delete-btn')) {
                        // Handle delete button
                        Swal.fire({
                            text: "Apa kamu yakin menghapus ini?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Make an AJAX request to delete the item
                                $.ajax({
                                    url: `/admin/kelas/${post_id}`,
                                    type: 'DELETE',
                                    cache: false,
                                    data: {
                                        "_token": token
                                    },
                                    success: function(response) {
                                        Swal.fire(
                                            'Dihapus!',
                                            'Kategori berhasil di hapus.',
                                            'success'
                                        );

                                        // Reload the DataTable
                                        $('#categoriesTable').DataTable().ajax.reload();
                                    },
                                    error: function(xhr, status, error) {
                                        Swal.fire(
                                            'Error!',
                                            'There was an error deleting the category.',
                                            'error'
                                        );
                                    }
                                });
                            }
                        });
                    }
                });

            });
        </script>


    @endsection

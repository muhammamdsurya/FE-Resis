@extends('layout.adminLayout')
@section('title', $title)

@section('content')

    <div class="container-fluid mt-3">
        <div class="row mb-3">
            <div class="col-7">
                <div class="search-form" style="width: 100%">
                    <form class="d-flex" role="search">
                        <input id="searchInput" class="form-control " type="search" placeholder="Tambah Kelas..."
                            aria-label="Search">
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
                    <div class="modal-dialog modal-lg">
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

                                <table id="categoriesTable" class="table table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Jenjang</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dynamic rows will be appended here -->
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Kelas -->
                <div class="modal fade" id="modal-kelas" tabindex="-1" aria-labelledby="modal-defaultLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-defaultLabel">Tambah Kelas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('kelas.post') }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="nameInput" placeholder="Class Name"
                                            name="name">
                                        <label for="nameInput">Class Name</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="descriptionInput"
                                            placeholder="Description" name="description">
                                        <label for="descriptionInput">Description</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <select class="form-control" id="categorySelect" name="category_id">
                                            <!-- Options should be populated dynamically -->
                                        </select>
                                        <label for="categorySelect">Category</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="priceInput" placeholder="Price"
                                            name="price">
                                        <label for="priceInput">Price</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="purposeInput"
                                            placeholder="Purpose" name="purpose">
                                        <label for="purposeInput">Purpose</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" name="instructor_id">
                                        {{-- <select class="form-control" id="instructorSelect" name="instructor_id">
                                            <!-- Options should be populated dynamically -->
                                        </select>
                                        <label for="instructorSelect">Instructor</label> --}}
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="coursesContainer" class="row g-2">
                <!-- Cards will be dynamically inserted here -->
            </div>


            <!-- Bootstrap Modal HTML -->
            <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editCategoryForm">
                                <div class="mb-3">
                                    <label for="categoryName" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" id="categoryName" required>
                                </div>
                                <input type="hidden" id="categoryId">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="saveCategoryBtn">Save</button>
                        </div>
                    </div>
                </div>
            </div>


            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                const apiUrl = '{{ env('API_URL') }}';

                $('#categoriesTable').on('click', '.edit-btn', function(e) {
                    e.preventDefault(); // Prevent the default anchor behavior

                    // Get the row that contains the clicked button
                    let row = $(this).closest('tr');
                    let rowData = table.row(row).data(); // Ensure 'table' is the DataTable instance

                    // Extract the 'name' value and 'id' from the row data
                    let currentName = rowData.name;
                    let post_id = $(this).data('id');

                    // Populate the modal form with the current name and category ID
                    $('#categoryName').val(currentName);
                    $('#categoryId').val(post_id);

                    // Show the modal
                    $('#editCategoryModal').modal('show');
                });

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

                // Initialize the DataTable
                const table = $('#categoriesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: apiUrl + 'courses/categories', // API endpoint
                        method: 'GET',
                        dataSrc: '', // Since the API returns an array of objects
                        error: function(xhr, status, error) {
                            console.error('Error fetching data:', error);
                            console.log('Error response:', xhr.responseText);
                        }
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1; // Adding row index for the numbering
                            }
                        },
                        {
                            data: 'name'
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
                    paging: false, // Enable pagination
                    searching: true, // Enable search/filter
                    info: false, // Disable table information display
                    lengthChange: false, // Disable page length change
                    autoWidth: false, // Disable automatic column width calculation
                    language: {
                        search: "_INPUT_", // Customize search input placeholder
                        searchPlaceholder: "Search..."
                    }
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
                    } else if ($(this).hasClass('edit-btn')) {
                        // Handle edit button
                        let currentName = $(this).closest('tr').find('').text();

                        Swal.fire({
                            title: 'Edit Category',
                            input: 'text',
                            inputLabel: 'Category Name',
                            inputValue: currentName,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Save'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let newName = result.value;

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
                                        Swal.fire(
                                            'Updated!',
                                            'Your category has been updated.',
                                            'success'
                                        );

                                        // Update the table row with the new name
                                        $(this).closest('tr').find('.category-name').text(
                                            newName);
                                    }.bind(
                                        this
                                    ), // Bind the context to access `this` inside success callback
                                    error: function(xhr, status, error) {
                                        Swal.fire(
                                            'Error!',
                                            'There was an error updating the category.',
                                            'error'
                                        );
                                    }
                                });
                            }
                        });
                    }
                });


                $.ajax({
                    url: apiUrl + 'courses/categories',
                    method: 'GET',
                    success: function(response) {
                        const jenjangSelect = $('#categorySelect');
                        jenjangSelect.empty(); // Clear existing options

                        jenjangSelect.append(
                            '<option value="" disabled selected>Select Jenjang</option>'
                        ); // Default option

                        $.each(response, function(index, category) {
                            jenjangSelect.append(new Option(category.name, category.id));
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching jenjang data:', error);
                        console.log('Error response:', xhr.responseText);
                    }
                });

                // Fetch instructor data from the API
                $.ajax({
                    url: apiUrl + "courses/instructors",
                    method: 'GET',
                    success: function(response) {
                        const instructorSelect = $('#instructorSelect');
                        instructorSelect.empty(); // Clear existing options

                        // Add a default option
                        instructorSelect.append(
                            '<option value="" disabled selected>Select Instructor</option>'
                        );

                        // Populate dropdown with options from API response
                        $.each(response, function(index, instructor) {
                            instructorSelect.append(new Option(instructor.name, instructor.id));
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching instructor data:', error);
                        console.log('Error response:', xhr.responseText);
                    }
                });

                $.ajax({
                    url: apiUrl + 'courses', // API endpoint to fetch course data
                    method: 'GET',
                    success: function(response) {
                        console.log(response); // Log the
                        const coursesContainer = $('#coursesContainer');
                        coursesContainer.empty(); // Clear existing content

                        // Assuming response is an array of course objects
                        $.each(response, function(index, item) {
                            const courseCategory = item
                                .course_category; // Access course category details
                            const courseData = item.course; // Access course details

                            const cardHtml = `
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card" style="width: 100%;">
                            <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="${courseData.name}">
                            <div class="card-body">
                                <div class="header-card d-flex justify-content-between">
                                    <p class="mr-auto fs-6"><i class="fas fa-star text-warning mr-2"></i>${courseData.rating}</p>
                                    <p class="ml-auto fs-6">Jenjang: ${courseCategory.name}</p>
                                </div>
                                <h5 class="card-title">${courseData.name}</h5>
                                <p class="card-text">${courseData.description}</p>
                                <a href="/detail-kelas/${courseData.id}" class="btn btn-success">Edit Kelas</a>
                            </div>
                        </div>
                    </div>
                `;
                            coursesContainer.append(cardHtml);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching courses:', error);
                    }
                });
            });
        </script>


    @endsection

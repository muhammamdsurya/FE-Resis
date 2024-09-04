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

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Jenjang</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="categoriesTable" class="table">
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
                                <form id="courseForm" method="POST" action="{{ route('kelas.post') }}">
                                    @csrf

                                    <div class="container">
                                        <div class="image text-center mb-5">
                                            <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}"
                                                alt="" class="img-fluid" width="200rem" height="200rem">
                                        </div>
                                        <div class="row gy-3 ">
                                            <div class="col-lg-6 col-md-6 mx-auto">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="nameInput"
                                                        placeholder="name@example.com" name="name">
                                                    <label for="nameInput">Nama Kelas</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="priceInput"
                                                        placeholder="Price" name="price">
                                                    <label for="priceInput">Harga</label>
                                                </div>

                                                <div class="form-floating">
                                                    <textarea class="form-control" placeholder="Leave a comment here" id="descriptionTextarea" name="description"
                                                        style="height: 100px"></textarea>
                                                    <label for="descriptionTextarea">Deskripsi</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 mx-auto">
                                                <div class="form-floating mb-3">
                                                    <select class="form-control" id="jenjangSelect" name="level">
                                                        <option value="" disabled selected>Select Jenjang</option>
                                                        <!-- Options will be populated here -->
                                                    </select>
                                                    <label for="jenjangSelect">Jenjang</label>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="instructorInput"
                                                        placeholder="Instructor" name="instructor">
                                                    <label for="instructorInput">Pengajar</label>
                                                </div>

                                                <div class="form-floating">
                                                    <textarea class="form-control" placeholder="Purpose" id="purposeTextarea" name="purpose" style="height: 100px"></textarea>
                                                    <label for="purposeTextarea">Tujuan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer mr-auto ml-2">
                                        <button type="submit" class="btn btn-primary">Tambah Kelas</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-2">

                <div id="coursesContainer">
                    <!-- Cards will be dynamically inserted here -->


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
                $('#tambahJenjang').on('click', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    const levelInput = $('#levelInput');

                    // Trim and validate the input
                    const level = levelInput.val().trim();
                    if (level === '') {
                        alert('Masukkan jenjang terlebih dahulu.');
                        return;
                    }

                    const data = {
                        name: level,
                    };

                    // Make the AJAX request directly to the API endpoint
                    $.ajax({

                        url: '{{ route('jenjang.post') }}', // Direct API endpoint
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
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error); // Log the error for debugging
                            console.error('Response Text:', xhr.responseText);
                            Swal.fire('Oops!', 'jenjang masih kosong!.', 'error');
                        }
                    });

                });



                $.ajax({
                    url: apiUrl + 'courses/categories',
                    method: 'GET',
                    success: function(response) {
                        const tableBody = $('#tableBody');
                        tableBody.empty(); // Clear any existing rows
                        const jenjangSelect = $('#jenjangSelect');
                        jenjangSelect.empty(); // Clear existing options

                        jenjangSelect.append(
                            '<option value="" disabled selected>Select Jenjang</option>'); // Default option

                        // Assuming response is an array of objects
                        $.each(response, function(index, category) {


                            const row = `
                    <tr>
                        <th scope="row">${index + 1}</th>
                        <td>${category.name}</td>
                        <td>
                            <a href="/categories/${category.id}/delete" class="btn btn-danger">Hapus</a>
                            <a href="/categories/${category.id}/edit" class="btn btn-success">Edit</a>
                        </td>
                    </tr>
                `;
                            tableBody.append(row);
                            jenjangSelect.append(new Option(category.name, category.id));
                        });

                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                        console.log('eror', xhr.responseText);
                    }
                });



                $.ajax({
                    url: '{{ route('kelas.index') }}', // API endpoint to fetch course data
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
                                    <p class="ml-auto fs-6">Jenjang: ${categoryData.name}</p>
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

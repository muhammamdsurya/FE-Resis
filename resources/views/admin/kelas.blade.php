@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

                                        <button type="submit" id="tambahJenjang" class="btn btn-primary ml-2">
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
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>SMA</td>
                                            <td>
                                                <a href="" class="btn btn-danger">Hapus</a>
                                                <a href="" class="btn btn-success">Edit</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Umum</td>
                                            <td>
                                                <a href="" class="btn btn-danger">Hapus</a>
                                                <a href="" class="btn btn-success">Edit</a>
                                            </td>
                                        </tr>

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
                                <div class="container">

                                    <div class="image text-center mb-5">
                                        <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" alt=""
                                            class="img-fluid" width="200rem" height="200rem">

                                    </div>
                                    <div class="row gy-3 ">
                                        <div class="col-lg-6 col-md-6 mx-auto">
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" id="floatingInput"
                                                    placeholder="name@example.com" name="class_name">
                                                <label for="floatingInput">Nama Kelas</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floatingInput"
                                                    placeholder="name@example.com" name="price">
                                                <label for="floatingInput">Harga</label>
                                            </div>

                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                                <label for="floatingTextarea2">Deskripsi</label>
                                            </div>

                                        </div>
                                        <div class="col-lg-6 col-md-6 mx-auto">

                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" id="floatingInput"
                                                    placeholder="name@example.com" name="level">
                                                <label for="floatingInput">Jenjang</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floatingInput"
                                                    placeholder="name@example.com" name="instructor">
                                                <label for="floatingInput">Pengajar</label>
                                            </div>

                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                                <label for="floatingTextarea2">Tujuan</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer mr-auto ml-2">
                                <button type="button" class="btn btn-primary">Tambah Kelas</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-lg-3 col-md-4 col-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="header-card d-flex justify-content-between">
                            <p class="mr-auto fs-6"><i class="fas fa-star text-warning mr-2"></i>4.9</p>
                            <p class="ml-auto fs-6">Jenjang : SMA</p>
                        </div>

                        <h5 class="card-title">Praktikum Laboratorium Dasar</h5>
                        <p class="card-text">mengajarkan keterampilan dasar laboratorium, seperti...</p>
                        <a href="/detail-kelas" class="btn btn-success">Edit Kelas</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="header-card d-flex justify-content-between">
                            <p class="mr-auto fs-6"><i class="fas fa-star text-warning mr-2"></i>4.9</p>
                            <p class="ml-auto fs-6">Jenjang : SMA</p>
                        </div>

                        <h5 class="card-title">Praktikum Laboratorium Dasar</h5>
                        <p class="card-text">mengajarkan keterampilan dasar laboratorium, seperti...</p>
                        <a href="/detail-kelas" class="btn btn-success">Edit Kelas</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="header-card d-flex justify-content-between">
                            <p class="mr-auto fs-6"><i class="fas fa-star text-warning mr-2"></i>4.9</p>
                            <p class="ml-auto fs-6">Jenjang : SMA</p>
                        </div>

                        <h5 class="card-title">Praktikum Laboratorium Dasar</h5>
                        <p class="card-text">mengajarkan keterampilan dasar laboratorium, seperti...</p>
                        <a href="/detail-kelas" class="btn btn-success">Edit Kelas</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="header-card d-flex justify-content-between">
                            <p class="mr-auto fs-6"><i class="fas fa-star text-warning mr-2"></i>4.9</p>
                            <p class="ml-auto fs-6">Jenjang : SMA</p>
                        </div>

                        <h5 class="card-title">Praktikum Laboratorium Dasar</h5>
                        <p class="card-text">mengajarkan keterampilan dasar laboratorium, seperti...</p>
                        <a href="/detail-kelas" class="btn btn-success">Edit Kelas</a>
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
        // Set up AJAX with default headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json', // Expect JSON response
                'Content-Type': 'application/json' // Send data in JSON format
            }
        });

        $(document).ready(function() {
            $('#tambahJenjang').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                const levelInput = $('#levelInput');
                console.log("click");

                // Trim and validate the input
                const level = levelInput.val().trim();
                if (level === '') {
                    alert('Masukkan jenjang terlebih dahulu.');
                    return;
                }

                const data = {
                    name: level
                };

                // Make the AJAX request directly to the API endpoint
                $.ajax({
                    url: 'test', // Direct API endpoint
                    method: 'POST',
                    data: JSON.stringify(data),
                    success: function(response) {
                        console.log("data:", response); // Log the response for debugging
                        alert("Category berhasil ditambahkan.");
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error); // Log the error for debugging
                        alert('Terjadi kesalahan.');
                    }
                });
            });
        });
    </script>


@endsection

@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <style>
        /* Gaya kustom tambahan untuk memperjelas checkbox */
        .form-check-input {
            border: 2px solid #000;
            /* Menambahkan border tebal */
            width: 1.25em;
            /* Lebar checkbox */
            height: 1.25em;
            /* Tinggi checkbox */
        }
    </style>
    <div class="container-fluid mt-3">
        <div class="row mb-3">
            <div class="col-7">
                <div class="search-form" style="width: 100%">
                    <form class="d-flex" role="search">
                        <input id="searchInput" class="form-control " type="search" placeholder="Cari Paket.."
                            aria-label="Search">
                    </form>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-end">
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal-bundling">
                    <i
                    class="fas fa-plus mr-1"></i>Tambah
                </button>

                <!-- Modal -->
                <div class="modal fade" id="modal-bundling" tabindex="-1" aria-labelledby="modal-defaultLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-defaultLabel">Tambah Bundling</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput"
                                            placeholder="name@example.com" name="level">
                                        <label for="floatingInput">Nama Bundling</label>
                                    </div>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Kelas</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>SMA</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkbox7">
                                                        <label class="form-check-label" for="checkbox7"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Umum</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkbox7">
                                                        <label class="form-check-label" for="checkbox7"></label>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer mr-auto">
                                <button type="button" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-6 col-lg-3 col-md-4 col-sm-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="header-card d-flex justify-content-between">
                            <p class="mr-auto fs-6"><i class="fas fa-star text-warning mr-2"></i>4.9</p>
                            <p class="ml-auto fs-6">Jenjang : SMA</p>
                        </div>

                        <h5 class="card-title">Paket Dasar</h5>
                        <p class="card-text">mengajarkan keterampilan dasar laboratorium, seperti...</p>
                        <a href="/detail-kelas" class="btn btn-success">Edit</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-4 col-sm-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="header-card d-flex justify-content-between">
                            <p class="mr-auto fs-6"><i class="fas fa-star text-warning mr-2"></i>4.9</p>
                            <p class="ml-auto fs-6">Jenjang : SMA</p>
                        </div>

                        <h5 class="card-title">Paket Menengah</h5>
                        <p class="card-text">mengajarkan keterampilan dasar laboratorium, seperti...</p>
                        <a href="/detail-kelas" class="btn btn-success">Edit</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-4 col-sm-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="header-card d-flex justify-content-between">
                            <p class="mr-auto fs-6"><i class="fas fa-star text-warning mr-2"></i>4.9</p>
                            <p class="ml-auto fs-6">Jenjang : SMA</p>
                        </div>

                        <h5 class="card-title">Paket advance</h5>
                        <p class="card-text">mengajarkan keterampilan dasar laboratorium, seperti...</p>
                        <a href="/detail-kelas" class="btn btn-success">Edit</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-4 col-sm-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="header-card d-flex justify-content-between">
                            <p class="mr-auto fs-6"><i class="fas fa-star text-warning mr-2"></i>4.9</p>
                            <p class="ml-auto fs-6">Jenjang : SMA</p>
                        </div>

                        <h5 class="card-title">Paket profesional</h5>
                        <p class="card-text">mengajarkan keterampilan dasar laboratorium, seperti...</p>
                        <a href="/detail-kelas" class="btn btn-success">Edit</a>
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
@endsection

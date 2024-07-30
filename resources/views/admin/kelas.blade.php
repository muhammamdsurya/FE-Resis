@extends('layout.adminLayout')
@section('title', $title)

@section('content')

    <div class="container-fluid mt-3">
        <div class="row mb-3">
        <div class="col-6">
            <div class="search-form" style="width: 100%">
                <form class="d-flex" role="search">
                    <input id="searchInput" class="form-control " type="search" placeholder="Mau Edit Kelas Ini ?" aria-label="Search">
                </form>
            </div>
        </div>
            <div class="col-6 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-kelas">
                    Tambah Kelas
                </button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-default">
                    Tambah Jenjang
                </button>

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
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                                        name="level">
                                        <label for="floatingInput">Tambah Jenjang</label>
                                    </div>

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
                                </form>
                            </div>
                            <div class="modal-footer mr-auto">
                                <button type="button" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Modal Kelas -->
                 <div class="modal fade" id="modal-kelas" tabindex="-1" aria-labelledby="modal-defaultLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-defaultLabel">Tambah Kelas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">

                                    <div class="image text-center mb-5">
                                    <img src="{{asset('assets/img/testimonials/testimonials-1.jpg')}}" alt="" class="img-fluid" width="200rem" height="200rem">

                                </div>
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 mx-auto">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="class_name">
                                            <label for="floatingInput">Nama Kelas</label>
                                          </div>

                                          <div class="form-floating mb-3">
                                              <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com"
                                              name="price" >
                                              <label for="floatingInput">Harga</label>
                                        </div>

                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                            <label for="floatingTextarea2">Deskripsi</label>
                                          </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 mx-auto">

                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="level">
                                            <label for="floatingInput">Jenjang</label>
                                          </div>

                                          <div class="form-floating mb-3">
                                              <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="instructor">
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
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card" style="width: 100%;">
                    <img src="{{asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
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
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card" style="width: 100%;">
                    <img src="{{asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
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
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card" style="width: 100%;">
                    <img src="{{asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
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
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card" style="width: 100%;">
                    <img src="{{asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
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

@endsection

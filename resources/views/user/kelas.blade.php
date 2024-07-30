@extends('layout.userLayout')
@section('title', $title)

@section('content')
    <div class="container-fluid">
        <section class="col-12 mt-2">
            <div class="row mb-3 mx-1">
                <div class="search-form ms-2" style="width: 50%">
                    <form class="d-flex" role="search">
                        <input id="searchInput" class="form-control " type="search" placeholder="Cari Kelas.." aria-label="Search">
                    </form>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="card" style="width: 100%;">
                        <img src="{{asset ('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: 25%">25%</div>
                              </div>

                            <h5 class="card-title my-2">Praktikum Laboratorium Dasar</h5>
                            <a href="#" class="fs-6">Lanjutkan <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="card" style="width: 100%;">
                        <img src="{{asset ('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: 25%">25%</div>
                              </div>

                            <h5 class="card-title my-2">Praktikum Laboratorium Dasar</h5>
                            <a href="#" class="fs-6">Lanjutkan <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="card" style="width: 100%;">
                        <img src="{{asset ('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: 25%">25%</div>
                              </div>

                            <h5 class="card-title my-2">Praktikum Laboratorium Dasar</h5>
                            <a href="#" class="fs-6">Lanjutkan <i class="fas fa-arrow-circle-right"></i></a>
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
        </section>
    </div>
@endsection

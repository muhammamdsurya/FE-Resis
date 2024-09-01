@extends('layout.InstLayout')
@section('title', $title)

@section('content')


    <div class="container-fluid mt-3">
        <div class="row mb-3">
            <div class="col-7">
                <div class="search-form" style="width: 100%">
                    <form class="d-flex" role="search">
                        <input id="searchInput" class="form-control " type="search" placeholder="Cari Kelas..."
                            aria-label="Search">
                    </form>
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-lg-3 col-md-4 col-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">

                        <h5 class="card-title">Praktikum Laboratorium Dasar</h5>
                        <div class="mt-3">
                            <a href="/detail-kelas" class="btn btn-success">
                              <i class="fas fa-chalkboard-teacher"></i>
                              <span class="d-none d-md-inline">Kelas</span>
                            </a>
                            <a href="/instructor/diskusi" class="btn btn-primary ">
                              <i class="fas fa-comments"></i>
                              <span class="d-none d-md-inline">Diskusi</span>
                            </a>
                          </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">

                        <h5 class="card-title">Praktikum Laboratorium Dasar</h5>
                        <div class="mt-3">
                            <a href="/detail-kelas" class="btn btn-success">
                              <i class="fas fa-chalkboard-teacher"></i>
                              <span class="d-none d-md-inline">Kelas</span>
                            </a>
                            <a href="/diskusi" class="btn btn-primary ">
                              <i class="fas fa-comments"></i>
                              <span class="d-none d-md-inline">Diskusi</span>
                            </a>
                          </div>
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

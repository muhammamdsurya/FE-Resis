@extends('layout.userLayout')
@section('title', $title)

@section('filter')

    <!-- Filter Dropdown -->
    <div class="filter-dropdown d-md-none d-sm-block ms-md-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Filter
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">Pending</a></li>
                <li><a class="dropdown-item" href="#">Dibeli</a></li>
                <li><a class="dropdown-item" href="#">Selesai</a></li>
            </ul>
        </div>
    </div>


@endsection

@section('content')
    <div class="container-fluid">
        <section class="col-12 mt-2">
            <div class="row mb-3 text-center">
                <div class="d-grid gap-2 d-none d-md-block">
                    <button class="btn btn-primary" type="button">Pending</button>
                    <button class="btn btn-secondary" type="button">Dibeli</button>
                    <button class="btn btn-secondary" type="button">Selesai</button>
                </div>
            </div>
            <div class="row ">
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="card" style="width: 100%;">
                        <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="text-center text-danger mb-1">Belum Bayar</p>
                            <h5 class="card-title">Praktikum Laboratorium Dasar</h5>
                            <a href="#" class="btn btn-primary mt-2">Bayar <i
                                    class="fas fa-arrow-circle-right"></i></a>
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

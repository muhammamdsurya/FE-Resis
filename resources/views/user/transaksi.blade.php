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
                <li><a class="dropdown-item" href="#">Belum Bayar</a></li>
                <li><a class="dropdown-item" href="#">Berhasil</a></li>
                <li><a class="dropdown-item" href="#">Pending</a></li>
                <li><a class="dropdown-item" href="#">Settlement</a></li>
                <li><a class="dropdown-item" href="#">Ditolak</a></li>
                <li><a class="dropdown-item" href="#">DiBatalkan</a></li>
                <li><a class="dropdown-item" href="#">Expired</a></li>
                <li><a class="dropdown-item" href="#">Refund</a></li>
                <li><a class="dropdown-item" href="#">Partial Refund</a></li>
            </ul>
        </div>
    </div>


@endsection

@section('content')
    <div class="container-fluid">
        <section class="col-12 mt-2">
            <div class="row mb-3 text-center">
                <div class="d-grid gap-2 d-none d-md-block">
                    <button class="btn btn-{{ $filter == 'active' ? 'primary' : 'secondary' }}" type="button">Belum Bayar</button>
                    <button class="btn btn-{{ $filter == 'capture' ? 'primary' : 'secondary' }}" type="button">Berhasil</button>
                    <button class="btn btn-{{ $filter == 'pending' ? 'primary' : 'secondary' }}" type="button">Pending</button>
                    <button class="btn btn-{{ $filter == 'settlement' ? 'primary' : 'secondary' }}" type="button">Settlement</button>
                    <button class="btn btn-{{ $filter == 'deny' ? 'primary' : 'secondary' }}" type="button">Ditolak</button>
                    <button class="btn btn-{{ $filter == 'cancel' ? 'primary' : 'secondary' }}" type="button">DiBatalkan</button>
                    <button class="btn btn-{{ $filter == 'expire' ? 'primary' : 'secondary' }}" type="button">Expired</button>
                    <button class="btn btn-{{ $filter == 'refund' ? 'primary' : 'secondary' }}" type="button">Refund</button>
                    <button class="btn btn-{{ $filter == 'partial_refund' ? 'primary' : 'secondary' }}" type="button">Partial Refund</button>
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

@extends('layout.adminLayout')
@section('title', $title)

@section('content')

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
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#modal-bundling">
                    <i class="fas fa-plus mr-1"></i>Tambah
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
                                <form action="{{ route('bundle.post') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floatingInput"
                                                    placeholder="name@example.com" name="name">
                                                <label for="floatingInput">Nama Bundling</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" id="floatingInput"
                                                    placeholder="name@example.com" name="price">
                                                <label for="floatingInput">harga</label>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput"
                                                placeholder="name@example.com" name="description">
                                            <label for="floatingInput">Deskripsi</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer mr-auto">
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-2">
            @foreach ($bundles as $row)
                <div class="col-6 col-lg-3 col-md-4 col-sm-6">
                    <a href="detail-bundling/{{ $row['id'] }}" class="text-decoration-none">
                        <div class="card" style="width: 100%;">
                            <img src="{{ asset('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <div class="header-card d-flex justify-content-between">
                                    <p class="ml-auto fs-6">{{ $row['price'] }}</p>
                                </div>

                                <h5 class="card-title">{{ $row['name'] }}</h5>
                                <p class="card-text">{{ $row['description'] }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
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
                        <a class="page-link" href="{{ route('admin.kelas', ['page' => $i]) }}">{{ $i }}</a>
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
    </div>
@endsection

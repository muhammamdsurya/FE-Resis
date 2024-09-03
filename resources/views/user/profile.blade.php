

@extends('layout.userLayout')
@section('title', $title)

@section('content')
    <div class="container">

        <div class="image text-center mb-5">
            <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" alt="" class="rounded-circle"
                width="200rem" height="200rem">

        </div>
            <div class="row ">
                <div class="col-lg-5 col-md-6 mx-auto">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            value="{{ $full_name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email </label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            value="{{ $email }}" disabled>
                    </div>

                </div>
                <div class="col-lg-5 col-md-6 mx-auto">

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Dibuat Tanggal </label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            value="{{ $created_at }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Diperbarui Tanggal </label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            value="{{ $updated_at }}" disabled>
                    </div>

                </div>

                <div class="col-lg-5 ml-5">
                    <button type="button" class="btn btn-success px-3 mb-5 mt-3" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">Edit</button>
                <!--    <a href="/logout" class="btn btn-danger px-3 mb-5 mt-3 btn-logout">Logout</a> -->
                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger px-3 mb-5 mt-3">Logout</button>
                </form>
                </div>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="image text-center mb-5">
                        <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" alt="" class="rounded-circle"
                            width="200rem" height="200rem">

                    </div>
                    <form action="{{ route('logout') }}">
                        <div class="row ">
                            <div class="col-lg-5 col-md-6 mx-auto">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $full_name }}">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email </label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $email }}" disabled>
                                </div>

                            </div>
                            <div class="col-lg-5 col-md-6 mx-auto">

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Dibuat Tanggal </label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $created_at }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Diperbarui Tanggal </label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $updated_at }}" disabled>
                                </div>


                            </div>

                            <a href="/reset-password" class="small ml-4">Reset Password</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
    </div>
@endsection

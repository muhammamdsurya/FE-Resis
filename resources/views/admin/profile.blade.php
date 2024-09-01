@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <div class="container">

        <div class="image text-center mb-2">
            <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" alt="" class="rounded-circle"
                width="200rem" height="200rem">

        </div>

        <div class="role text-center">
            <h5 class="bold">Role : {{ $role }} </p>
        </div>
        <div class="row ">
            <div class="col-lg-5 col-md-6 mx-auto">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ $full_name }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email  </label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        value="{{ $email }}" disabled>
                </div>

            </div>
            <div class="col-lg-5 col-md-6 mx-auto">

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Dibuat Tanggal  </label>
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
                <button type="submit" class="btn btn-success px-3 mb-5 mt-3">Edit</button>
                <button type="submit" class="btn btn-danger px-3 mb-5 mt-3 btn-logout">Logout</a>
            </div>
        </div>

    </div>

@endsection

@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <div class="container">

        <div class="image text-center mb-2">
            <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" alt="" class="rounded-circle"
                width="200rem" height="200rem">

        </div>

        <div class="role text-center">
            <h5 class="bold">Role : {{$role}} </p>
        </div>
        <div class="row ">
            <div class="col-lg-5 col-md-6 mx-auto">
                <div class="form-floating mb-3">
                    <label for="floatingInput">Nama Lengkap</label>
                    <input type="email" class="form-control" id="floatingInput"
                        name="email" value="{{ $full_name }}" disabled>
                </div>

                <div class="form-floating mb-3">
                    <label for="floatingInput">Email</label>
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="email" value="{{ $email }}" disabled>
                </div>

            </div>
            <div class="col-lg-5 col-md-6 mx-auto">

                <div class="form-floating mb-3">
                    <label for="floatingInput">Dibuat Tanggal</label>
                    <input type="text" class="form-control" id="floatingInput"
                        name="created_at" value="{{ $created_at }}" disabled>
                </div>

                <div class="form-floating mb-3">
                    <label for="floatingInput">Diperbarui Tanggal</label>
                    <input type="text" class="form-control" id="floatingInput"
                        name="updated_at" value="{{ $updated_at }}" disabled>
                </div>


            </div>

            <div class="col-lg-5 ml-5">
                <button type="submit" class="btn btn-success px-3 mb-5 mt-3">Edit</button>
                <a href="/admin/login" class="btn btn-danger px-3 mb-5 mt-3 btn-logout">Logout</a>
            </div>
        </div>

    </div>

@endsection

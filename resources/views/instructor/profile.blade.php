@extends('layout.InstLayout')
@section('title', $title)

@section('content')
    <div class="container">

        <div class="image text-center mb-5">
            <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" alt="" class="rounded-circle"
                width="200rem" height="200rem">

        </div>
        <div class="row">
            <div class="col-lg-5 col-md-6 mx-auto">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="email" value="{{ $name }}">
                    <label for="floatingInput">Nama Lengkap</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="email" value="">
                    <label for="floatingInput">Pendidikan</label>
                </div>

                <p class="fs-6">Dibuat Tanggal : {{ $created_at }}</p>


            </div>
            <div class="col-lg-5 col-md-6 mx-auto">
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="email" value="{{ $email }}">
                    <label for="floatingInput">Email</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="email" value="">
                    <label for="floatingInput">Pengalaman</label>
                </div>

                <p class="fs-6">Diupdate Tanggal : {{ $updated_at }} </p>

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
@endsection

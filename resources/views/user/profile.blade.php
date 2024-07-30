@extends('layout.userLayout')
@section('title', $title)

@section('content')
    <div class="container">

        <div class="image text-center mb-5">
        <img src="{{asset('assets/img/testimonials/testimonials-1.jpg')}}" alt="" class="rounded-circle" width="200rem" height="200rem">

    </div>
        <div class="row">
            <div class="col-lg-5 col-md-6 mx-auto">
                <div class="form-floating mb-3">
                    <label for="floatingInput">Nama Lengkap</label>
                    <input type="email" class="form-control"
                        id="floatingInput" placeholder="name@example.com" name="email"
                        value="{{ old('email') }}">
                </div>

                <div class="form-floating mb-3">
                    <label for="floatingInput">Password</label>
                    <input type="email" class="form-control"
                        id="floatingInput" placeholder="name@example.com" name="email"
                        value="{{ old('email') }}">
                </div>

                <p class="fs-6">Dibuat Tanggal : </p>

                <button type="submit" class="btn btn-success px-5 mb-5 mt-3">Edit</button>


            </div>
            <div class="col-lg-5 col-md-6 mx-auto">
                <div class="form-floating mb-3">
                    <label for="floatingInput">Email</label>
                    <input type="email" class="form-control"
                        id="floatingInput" placeholder="name@example.com" name="email"
                        value="{{ old('email') }}">
                </div>

                <div class="form-floating mb-3">
                    <label for="floatingInput">Jenjang</label>
                    <input type="email" class="form-control"
                        id="floatingInput" placeholder="name@example.com" name="email"
                        value="{{ old('email') }}">
                </div>

                <p class="fs-6">Diupdate Tanggal : </p>

            </div>


        </div>

    </div>
@endsection

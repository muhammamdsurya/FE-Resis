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
                <form action="{{ route('complete.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tanggal lahir</label>
                        <input type="date" class="form-control" id="birth" aria-describedby="emailHelp"
                            name="birth">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Pendidikan </label>
                        <input type="text" class="form-control" id="study_level" aria-describedby="emailHelp"
                            name="study_level">
                    </div>

            </div>
            <div class="col-lg-5 col-md-6 mx-auto">

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Sekolah </label>
                    <input type="text" class="form-control" id="institution" aria-describedby="emailHelp"
                        name="institution">
                </div>

            </div>

            <div class="col-lg-5 ml-5">
                <button type="submit" class="btn btn-success px-3 mb-5 mt-3">Selesai</button>
            </div>
            </form>
        </div>
    </div>

@endsection

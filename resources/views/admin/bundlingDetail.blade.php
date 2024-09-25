@extends('layout.adminLayout')
@section('title', $title)

@section('content')


    <form id="courseForm" method="POST" action="{{ route('bundle.edit', ['id' => $bundle['id']]) }}">
        @csrf
        <div class="container">
            <div class="image text-center mb-5">
                <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" alt="" class="img-fluid"
                    width="200rem" height="200rem">
            </div>
            <div class="row gy-3 ">
                <div class="col mx-auto">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nameInput" placeholder="name@example.com"
                            name="name" value="{{ $bundle['name'] }}">
                        <label for="nameInput">Nama Bundle</label>
                    </div>
                </div>
                <div class="col mx-auto">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="priceInput" placeholder="Price" name="price"
                            value="{{ $bundle['price'] }}">
                        <label for="priceInput">Harga</label>
                    </div>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="descriptionTextarea" name="description"
                        style="height: 100px">{{ $bundle['description'] }}</textarea>
                    <label for="descriptionTextarea">Deskripsi</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3" id="course">Simpan</button>
        </div>
    </form>





@endsection

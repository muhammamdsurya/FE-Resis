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

    {{-- <form id="courseForm" method="POST" action="{{ route('bundleCourse.post', ['id' => $bundle['id']]) }}"> --}}
    <div class="container">
        <h5>Kelas yang di bundling</h5>
        <div class="row" id="courseContainer">
            <div class="col">
                <div class="form-floating mb-3">
                    <select class="form-control" id="bundleSelect" name="bundleSelect[]">
                        @foreach ($courses as $row)
                            <option value="{{ $row['course']['id'] }}">{{ $row['course']['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="bundleSelect">Kelas</label>
                </div>
            </div>
            <div class="col d-flex align-items-center">
                <button type="button" class="btn btn-success" id="addCourseButton">+</button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3" id="saveCoursesButton">Simpan</button>
    </div>
    </form>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let courseIndex = 1;

            // Function to add new input row
            $('#addCourseButton').click(function() {
                courseIndex++;
                let newInputRow = `
                        <div class="row mt-3" id="courseRow${courseIndex}">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-control" name="bundleSelect[]">
                                        @foreach ($courses as $row)
                                            <option value="{{ $row['course']['id'] }}">{{ $row['course']['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <label for="bundleSelect">Kelas</label>
                                </div>
                            </div>
                            <div class="col d-flex align-items-center">
                                <button type="button" class="btn btn-danger removeCourseButton" data-id="${courseIndex}">-</button>
                            </div>
                        </div>
                    `;
                $('#courseContainer').append(newInputRow);
            });

            // Function to remove input row
            $(document).on('click', '.removeCourseButton', function() {
                let rowId = $(this).data('id');
                $('#courseRow' + rowId).remove();
            });
        });
    </script>


@endsection

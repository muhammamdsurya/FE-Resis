@extends('layout.adminLayout')
@section('title', $title)

@section('content')

    <div class="container">
        <div class="row">
            <!-- Left Column: Data Bundling -->
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="card-title">Data Bundling</h5>
                    </div>
                    <div class="card-body">
                        <!-- Image Section -->
                        <div class="image text-center mb-4">
                            <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" alt="Bundle Image"
                                class="img-fluid rounded-circle shadow" width="150" height="150">
                        </div>

                        <!-- Bundle Details Form -->
                        <form id="courseForm" method="POST" action="{{ route('bundle.edit', ['id' => $bundle['id']]) }}">
                            @csrf
                            <div class="row gy-4">
                                <!-- Bundle Name -->
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nameInput" placeholder="Nama Bundle"
                                            name="name" value="{{ $bundle['name'] }}">
                                        <label for="nameInput">Nama Bundle</label>
                                    </div>
                                </div>

                                <!-- Bundle Price -->
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="priceInput" placeholder="Harga"
                                            name="price" value="{{ $bundle['price'] }}">
                                        <label for="priceInput">Harga</label>
                                    </div>
                                </div>

                                <!-- Bundle Description -->
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Deskripsi" id="descriptionTextarea" name="description"
                                            style="height: 120px">{{ $bundle['description'] }}</textarea>
                                        <label for="descriptionTextarea">Deskripsi</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary px-5">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Kelas yang di Bundling -->
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="card-title">Data Bundling</h5>
                    </div>
                    <div class="card-body">
                        <!-- Courses Selection Form -->
                        <form id="courseForm" method="POST"
                            action="{{ route('bundleCourse.post', ['id' => $bundle['id']]) }}">
                            @csrf
                            <div class="row g-3 align-items-center" id="courseContainer">
                                <div class="col-md-8 col-8">
                                    <div class="form-floating">
                                        <select class="form-control" id="bundleSelect" name="bundleSelect[]">
                                            @foreach ($courses as $row)
                                                <option value="{{ $row['course']['id'] }}">{{ $row['course']['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="bundleSelect">Pilih Kelas</label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-4">
                                    <button type="button" class="btn btn-success w-100" id="addCourseButton">+
                                        Tambah</button>
                                </div>
                            </div>

                            <!-- Courses Table -->
                            <table class="table table-bordered mt-4" id="courseTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kelas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamically added rows go here -->
                                </tbody>
                            </table>

                            <!-- Submit Courses Button -->
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary px-5">Simpan Kelas</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addCourseButton = document.getElementById('addCourseButton');
            const courseTable = document.getElementById('courseTable').getElementsByTagName('tbody')[0];
            const bundleSelect = document.getElementById('bundleSelect');

            addCourseButton.addEventListener('click', function() {
                const selectedOption = bundleSelect.options[bundleSelect.selectedIndex];
                const courseId = selectedOption.value;
                const courseName = selectedOption.text;

                // Check if the course is already added
                const exists = Array.from(courseTable.getElementsByTagName('tr')).some(row => {
                    return row.getAttribute('data-course-id') === courseId;
                });

                if (!exists) {
                    // Create a new row
                    const newRow = courseTable.insertRow();
                    newRow.setAttribute('data-course-id', courseId);

                    // Insert course name
                    const nameCell = newRow.insertCell(0);
                    nameCell.textContent = courseName;

                    // Insert action (delete button)
                    const actionCell = newRow.insertCell(1);
                    const deleteButton = document.createElement('button');
                    deleteButton.className = 'btn btn-danger';
                    deleteButton.textContent = 'Hapus';
                    deleteButton.addEventListener('click', function() {
                        courseTable.deleteRow(newRow.rowIndex - 1); // Delete the row
                    });
                    actionCell.appendChild(deleteButton);

                    // Append hidden input to the form for submission
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'bundleSelect[]';
                    hiddenInput.value = courseId;
                    newRow.appendChild(hiddenInput);
                } else {
                    alert('Kelas ini sudah ditambahkan!');
                }
            });
        });
    </script>


@endsection

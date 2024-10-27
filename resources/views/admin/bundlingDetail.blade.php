@extends('layout.adminLayout')
@section('title', $title)

@section('content')

    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }

        .image-container img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5) !important;
            /* Warna hitam transparan */
            color: white !important;
            opacity: 0;
            /* Awalnya disembunyikan */
            transition: opacity 0.3s ease;
            /* Animasi saat hover */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            border-radius: 10px;
        }

        .image-container:hover .overlay {
            opacity: 1;
            cursor: pointer;
            /* Muncul saat di-hover */
        }
    </style>
    <div class="container">
        <div class="row">
            <!-- Left Column: Data Bundling -->
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="card-title">Data Bundling</h5>
                    </div>
                    <div class="card-body">
                        <form id="courseForm" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Image Section -->
                            <div class="image-container text-center mb-4">
                                <img src="{{ $bundle['thumbnail_image'] }}" alt="Bundle Image"
                                    class="img-fluid rounded shadow image-preview" id="imagePreview">
                                <div class="overlay">Ganti Gambar</div>
                            </div>
                            <input type="file" id="imageUpload" name="image" style="display: none;" accept="image/*">

                            <!-- Bundle Details Form -->

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
                                        <input type="text" class="form-control" id="priceInput" placeholder="Harga"
                                            name="price" value="{{ number_format($bundle['price'], 0, ',', '.') }}">
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

                            <div class="d-flex justify-content-between mt-4">
                                <!-- Save Button on the left -->
                                <div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                                <!-- Delete Button on the right -->
                                <div>
                                    <button type="button" class="btn btn-danger" id="deleteButton"
                                        data-id="{{ $bundle['id'] }}">Hapus</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Kelas yang di Bundling -->
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="card-title">Kelas Bundling</h5>
                    </div>
                    <div class="card-body">
                        <!-- Courses Selection Form -->
                        <form id="coursePost" method="POST">
                            @csrf
                            <div class="row g-3 align-items-center" id="courseContainer">
                                <div class="col-md-8 col-8">
                                    <div class="form-floating">
                                        <select class="form-control" id="bundleSelect" name="bundleSelect[]">
                                            @if ($courses != null)


                                                @foreach ($courses as $row)
                                                    <option value="{{ $row['id'] }}">{{ $row['name'] }}
                                                    </option>
                                                @endforeach

                                            @endif
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
                                    @if (isset($courseDetails['message']))
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada kelas tersedia.</td>
                                        </tr>
                                    @else
                                        @foreach ($courseDetails as $item)
                                            <tr>
                                                <td>{{ $item['course']['name'] ?? 'Unknown Course' }}</td>
                                                <!-- Adjust according to your data structure -->
                                                <td>
                                                    <button class="btn btn-danger deleteCourse" type="button"
                                                        data-id="{{ $item['course']['id'] ?? '' }}">Hapus</button>

                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

                            </table>

                            <!-- Submit Courses Button -->
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">Simpan Kelas</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.getElementById('priceInput').addEventListener('input', function(e) {
            var value = e.target.value;
            value = value.replace(/\D/g, ''); // Menghapus karakter selain angka
            value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
            e.target.value = value.replace('Rp', '')
                .trim(); // Menghilangkan 'Rp' dan hanya menampilkan angka dengan titik
        });

        // Pastikan format angka asli diambil saat form dikirim
        document.querySelector('form').addEventListener('submit', function() {
            var priceInput = document.getElementById('priceInput');
            priceInput.value = priceInput.value.replace(/\./g, ''); // Menghapus titik sebelum dikirimkan ke server
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('message'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('message') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        });
        $(document).ready(function() {
            // Ketika gambar di-klik, trigger input file
            $('.image-container').on('click', function() {
                $('#imageUpload').click();
            });

            // Mengubah tampilan gambar setelah memilih file
            $('#imageUpload').on('change', function(e) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#imagePreview').attr('src', event.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
        $('#courseForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman default

            // Membuat objek FormData
            const formData = new FormData(this);

            createOverlay('Proses...'); // Tampilkan overlay

            // Mengirim data formulir menggunakan AJAX
            $.ajax({
                url: ' {{ route('bundle.edit', ['id' => $bundle['id']]) }}',
                type: 'POST',
                data: formData, // Mengambil data dari formulir
                processData: false, // Mencegah jQuery mengubah data
                contentType: false, // Mencegah jQuery menetapkan konten
                success: function(response) {
                    gOverlay.hide();
                    // Lakukan sesuatu setelah berhasil
                    Swal.fire('Sukses!', response.message, 'success');
                    // Reload halaman atau arahkan ke halaman lain jika diperlukan
                    location.reload();
                },
                error: function(xhr, status, error) {
                    gOverlay.hide();
                    console.error('Error:', xhr.responseText);
                    // Menampilkan pesan error
                    Swal.fire('Error!',
                        'Terjadi kesalahan saat mengirim data. Silakan coba lagi.',
                        'error');
                },
            });
        });
        $('#coursePost').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman default

            // Membuat objek FormData
            const formData = new FormData(this);


            createOverlay('Proses...'); // Tampilkan overlay

            // Mengirim data formulir menggunakan AJAX
            $.ajax({
                url: '{{ route('bundleCourse.post', ['id' => $bundle['id']]) }}',
                type: 'POST',
                data: formData, // Mengambil data dari formulir
                processData: false, // Mencegah jQuery mengubah data
                contentType: false, // Mencegah jQuery menetapkan konten
                success: function(response) {
                    gOverlay.hide();
                    // Lakukan sesuatu setelah berhasil
                    Swal.fire('Sukses!', response.message, 'success');
                    // Reload halaman atau arahkan ke halaman lain jika diperlukan
                    location.reload();
                },
                error: function(xhr, status, error) {
                    gOverlay.hide();
                    console.error('Error:', xhr.responseText);
                    // Menampilkan pesan error
                    Swal.fire('Error!',
                        'Terjadi kesalahan saat mengirim data. Silakan coba lagi.',
                        'error');
                },
            });
        });
        document.addEventListener('DOMContentLoaded', function() {

            document.getElementById('deleteButton').addEventListener('click', function() {
                const courseBundleId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Yakin ingin menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send DELETE request to Laravel route
                        fetch(`/admin/detail-bundling/delete/${courseBundleId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-Token': '{{ csrf_token() }}' // Include CSRF token for Laravel
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    Swal.fire(
                                        'Yess!',
                                        'Berhasil Dihapus!',
                                        'success'
                                    ).then(() => {
                                        // Redirect to the specified route
                                        window.location.href =
                                            '{{ route('admin.bundling') }}'; // Redirect to the admin bundling page
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an error deleting the course bundle.',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the course bundle.',
                                    'error'
                                );
                            });
                    }
                });
            });

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
                    deleteButton.className = 'btn btn-info';
                    deleteButton.textContent = 'ganti';
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
                    Swal.fire({
                        title: 'Info!',
                        text: 'Kelas ini sudah ditambahkan!',
                        icon: 'info',
                        showConfirmButton: false,
                        timer: 1000, // Set the timer in milliseconds (e.g., 2000 ms = 2 seconds)
                    });
                }
            });
        });

        // Select all delete buttons
        const deleteButtons = document.querySelectorAll('.deleteCourse');

        // Attach event listener to each button
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                event.preventDefault(); // Prevent default button behavior

                const courseId = this.getAttribute('data-id');
                confirmDelete(courseId); // Call the confirmDelete function or any other logic
            });
        });

        function confirmDelete(courseId) {
            let bundleId = {!! json_encode($bundle['id']) !!};

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus kelas ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send DELETE request to Laravel route
                    fetch(`/admin/detail-bundling/${bundleId}/course/delete`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}', // Sertakan token CSRF untuk Laravel
                                'Content-Type': 'application/json' // Setel konten tipe ke JSON
                            },
                            body: JSON.stringify({
                                courseIds: [courseId] // Mengirim courseId dalam array
                            })
                        })
                        .then(response => {
                            // Check if the response is OK (status in the range 200-299)
                            if (!response.ok) {
                                return response.json().then(data => {
                                    throw new Error(data.message);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Handle success
                            // Handle success with SweetAlert
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'Okay'
                            });
                            window.location.href = `/admin/detail-bundling/${bundleId}`;

                        })
                        .catch(error => {
                            // Handle error
                            // Handle error with SweetAlert
                            Swal.fire({
                                title: 'Error!',
                                text: error.message,
                                icon: 'error',
                                confirmButtonText: 'Try Again'
                            });
                        });

                }
            });
        };
    </script>


@endsection

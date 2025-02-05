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
            <!-- Data Kelas Section -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Data Kelas</h5>
                    </div>
                    <div class="card-body">
                        <form id="courseForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Image Section -->
                            <div class="image-container text-center mb-4">
                                <img src="{{ $course->course->thumbnail_image }}" alt="{{ $course->course->name }}"
                                    class="img-fluid rounded shadow image-preview" id="imagePreview">
                                <div class="overlay">Ganti Gambar</div>
                            </div>
                            <input type="file" id="imageUpload" name="image" style="display: none;" accept="image/*">

                            <!-- Form Row 1: Name and Jenjang -->
                            <div class="row mb-1">
                                <div class="col-md-6 mb-1">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nameInput" placeholder="Nama Kelas"
                                            name="name" value="{{ $course->course->name }}">
                                        <label for="nameInput">Nama Kelas</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="priceInput" placeholder="Harga"
                                            name="price" value="{{ number_format($course->course->price, 0, ',', '.') }}">
                                        <label for="priceInput">Harga</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Row 2: Description and Price -->
                            <div class="row mb-1">
                                <div class="col-md-6 mb-1">
                                    <div class="form-floating">
                                        <select class="form-control" id="categorySelect" name="category_id">
                                            <option value="{{ $course->course_category->id }}" selected>
                                                {{ $course->course_category->name }}
                                            </option>

                                            @foreach ($categories as $category)
                                                <!-- Mengecek apakah instruktur sudah dipilih sebelumnya -->
                                                @if ($category->id != $course->course_category->id)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </option>
                                                @endif
                                            @endforeach

                                        </select>
                                        <label for="categorySelect">Jenjang</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control" id="instructorSelect" name="instructor_id">
                                            <option value="{{ $course->instructor->instructor->id }}" selected>
                                                {{ $course->instructor->full_name }}
                                            </option>

                                            @foreach ($instructors as $instructor)
                                                <!-- Mengecek apakah instruktur sudah dipilih sebelumnya -->
                                                @if ($instructor->instructor->id != $course->instructor->instructor->id)
                                                    <option value="{{ $instructor->instructor->id }}">
                                                        {{ $instructor->full_name }}
                                                    </option>
                                                @endif
                                            @endforeach

                                        </select>
                                        <label for="instructorSelect">Pengajar</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Row 3: Instructor and Purpose -->
                            <div class="row mb-1">
                                <div class="col-md-6 mb-1">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Deskripsi" id="descriptionTextarea" name="description"
                                            style="height: 100px">{{ $course->course->description }}</textarea>
                                        <label for="descriptionTextarea">Deskripsi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Tujuan" id="purposeTextarea" name="purpose" style="height: 100px">{{ $course->course->purpose }}</textarea>
                                        <label for="purposeTextarea">Tujuan</label>
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
                                        data-id="{{ $course->course->id }}">Hapus</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Data Materi Section -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Data Materi</h5>
                    </div>
                    <div class="card-body">
                        <!-- Sidebar for larger screens -->
                        <div class="filter-dropdown d-none d-lg-block">
                            <div class="list-group mt-3">
                                @if (isset($courseContents))
                                    @foreach ($courseContents as $courseContentSidebar)
                                        <a href="?selectedCourseContentId={{ $courseContentSidebar->id }}"
                                            class="list-group-item list-group-item-action {{ $selectedCourseContentId == $courseContentSidebar->id ? 'list-group-item-primary' : '' }}">
                                            {{ $courseContentSidebar->content_title }}
                                        </a>
                                    @endforeach
                                @endif
                                <!-- Link to add new content -->
                                <a href="?selectedCourseContentId="
                                    class="list-group-item list-group-item-action {{ $selectedCourseContentId == '' ? 'list-group-item-primary' : '' }}">
                                    <i class="fas fa-plus mr-2"></i>Tambah Materi Baru
                                </a>
                                <!-- Discussion link -->
                                <a href="/admin/diskusi-kelas/{{ $course->course->id }}"
                                    class="list-group-item list-group-item-action">Diskusi</a>
                            </div>
                        </div>

                        <!-- Dropdown for smaller screens -->
                        <div class="filter-dropdown d-lg-none d-sm-block">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle w-100" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Materi
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                    @if (isset($courseContents))
                                        @foreach ($courseContents as $courseContentSidebar)
                                            <li>
                                                <a class="dropdown-item {{ $selectedCourseContentId == $courseContentSidebar->id ? 'active' : '' }}"
                                                    href="?selectedCourseContentId={{ $courseContentSidebar->id }}">
                                                    {{ $courseContentSidebar->content_title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                    <!-- Link to add new content -->
                                    <li>
                                        <a class="dropdown-item {{ $selectedCourseContentId == '' ? 'active' : '' }}"
                                            href="?selectedCourseContentId=">
                                            <i class="fas fa-plus mr-2"></i>Tambah Materi Baru
                                        </a>
                                    </li>
                                    <!-- Discussion link -->
                                    <li><a class="dropdown-item"
                                            href="/admin/diskusi-kelas/{{ $course->course->id }}">Diskusi</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Column for Video and Description -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Materi Kelas</h5>
                    </div>
                    <div class="card-body">
                        <div class="mt-3">
                            <!-- First Row: Judul Materi and Jenis Konten -->
                            <div class="row mb-1">
                                <div class="col-md-6 mb-1">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="contentName"
                                            placeholder="Judul Materi" name="name" required>
                                        <label for="contentName">Judul Materi</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control" id="contentType" name="level" required>
                                            <option value="{{ $videoType }}" selected>Video</option>
                                            <option value="{{ $addSrcType }}">Sumber Tambahan</option>
                                            <option value="{{ $quizType }}">Quiz</option>
                                        </select>
                                        <label for="contentType">Jenis Konten</label>
                                    </div>
                                </div>

                                <div class="col-12 mb-1">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Deskripsi" id="contentDesc"></textarea>
                                        <label for="contentDesc">Deskripsi Materi</label>
                                    </div>
                                </div>
                            </div>

                            <div id="video-type">

                                <!-- Display Existing Video Content -->
                                @if ($selectedCourseContentId != '' && $courseContent->content_type == $videoType)
                                    <div class="ratio ratio-16x9 mb-3">
                                        <video controls poster="{{ $courseContent->video->thumbnail_image }}" controls
                                            controlsList="nodownload" oncontextmenu="return false;">
                                            <source src="{{ $courseContent->video->video_file }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @endif

                                <!-- Video Type Content Section -->
                                <div id="video-type" class="content-type-section">
                                    <div class="row mb-1">
                                        <div class="col-12 ">
                                            <div class="form-floating">
                                                <textarea rows="3" placeholder="Materi" id="contentVideoArticleContent" name="video_content_name" required></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" id="contentVideoDuration"
                                            value="10">
                                    </div>

                                    <!-- Video and Thumbnail Input -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="contentVideoFile" class="form-label">Konten Video</label>
                                            <input type="file" class="form-control" id="contentVideoFile"
                                                name="video_file" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="contentVideoThumbFile" class="form-label">Thumbnail</label>
                                            <input type="file" class="form-control" id="contentVideoThumbFile"
                                                name="thumbnail_file" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="additional-src-type">
                                @if ($selectedCourseContentId != '')
                                    @if ($courseContent->content_type == $addSrcType)
                                        <div class="ratio ratio-16x9 mb-3">
                                            <iframe src="{{ $courseContent->src->file }}" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                        </div>
                                    @endif
                                @endif
                                <div class="form-floating mb-3">
                                    <input type="file" class="form-control" id="contentAddSrcFile" name="name">
                                    <label for="contentAddSrcFile">Source Tambahan</label>
                                </div>
                            </div>

                            <div id="quiz-type">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="contentPassingGrade"
                                        placeholder="name@example.com" name="name">
                                    <label for="contentPassingGrade">Nilai Kelulusan</label>
                                </div>

                                <button type="button" class="btn btn-primary d-flex align-items-center mb-2"
                                    onclick="showQuizModal(null)">
                                    <i class="fas fa-plus mr-1"></i>Tambah Quiz
                                </button>
                                <div class="quizzesList">

                                </div>
                            </div>

                            <div class="mt-5">
                                <button
                                    onclick="window.location.href='?selectedCourseContentId={{ $previousCourseContentId }}'"
                                    {{ $previousCourseContentId == '' ? 'disabled' : '' }} class="btn btn-secondary"><i
                                        class="fas fa-arrow-circle-left mr-2"></i><span
                                        class="d-lg-inline d-none">Sebelumnya</span></button>
                                @if ($selectedCourseContentId == '')
                                    <button id="saveContent" class="btn btn-primary float-right">Simpan</button>
                                @else
                                    <button class="btn btn-danger ml-3" onclick="deleteContent()">Hapus</button>
                                    <button onclick="updateCourseContent()" class="btn btn-primary">Simpan</button>

                                    <button
                                        onclick="window.location.href='?selectedCourseContentId={{ $nextCourseContentId }}'"
                                        {{ $nextCourseContentId == '' ? 'disabled' : '' }}
                                        class="btn btn-primary float-right"><span
                                            class="d-lg-inline d-none">Lanjut</span><i
                                            class="fas fa-arrow-circle-right ml-2"></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kelas -->
    <div class="modal fade" id="modal-quiz" tabindex="-1" aria-labelledby="modal-defaultLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modal-defaultLabel">Tambah Pertanyaan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST" action="{{ route('kelas.post') }}">
                        @csrf
                        <!-- Pertanyaan Input -->
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" id="questionQuizInput" placeholder="Pertanyaan"
                                name="name" required>
                            <label for="questionQuizInput">Pertanyaan</label>
                        </div>

                        <!-- Jawaban Select -->
                        <div class="form-floating mb-4">
                            <select class="form-control" id="answerQuizInput" required>
                                <option value="">Pilih Jawaban</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                            <label for="answerQuizInput">Jawaban</label>
                        </div>

                        <!-- Option Input and Button -->
                        <div class="row mb-3">
                            <div class="col-8">
                                <div class="form-floating mb-0">
                                    <input type="text" class="form-control" id="optionQuizInput"
                                        placeholder="Tambah Opsi" name="option">
                                    <label for="optionQuizInput">Opsi</label>
                                </div>
                            </div>
                            <div class="col-4 d-flex align-items-center">
                                <button type="button"
                                    class="btn btn-primary w-100 d-flex align-items-center justify-content-center"
                                    onclick="addOptionQuiz()">
                                    <i class="fas fa-plus me-2"></i> Tambah Opsi
                                </button>
                            </div>
                        </div>

                        <!-- Option Quiz Add Section -->
                        <div class="option-quiz-add mb-3 p-3 border rounded" style="min-height: 100px;">
                            <!-- Dynamically added options will appear here -->
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="button" onclick="submitOptionQuiz()"
                                class="btn btn-success d-flex align-items-center justify-content-center">
                                <i class="fas fa-check me-2"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- SummerNote -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/uuid@8.3.2/dist/umd/uuid.min.js"></script>

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
    </script>


    <script>
        // Fungsi untuk menyesuaikan tinggi textarea
        function adjustTextareaHeight(textarea) {
            textarea.style.height = 'auto'; // Reset height terlebih dahulu
            textarea.style.height = textarea.scrollHeight + 'px'; // Sesuaikan tinggi berdasarkan konten
        }

        // Event listener saat pengguna mengetik
        const contentDesc = document.getElementById('contentDesc');
        contentDesc.addEventListener('input', function() {
            adjustTextareaHeight(this); // Sesuaikan tinggi saat pengguna mengetik
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

        $('#courseForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman default

            // Ambil elemen input price
            var priceInput = document.getElementById('priceInput');

            // Hapus titik dari nilai input price (pemformatan ribuan) dan konversi ke integer
            var cleanPrice = parseInt(priceInput.value.replace(/\./g, ''), 10);

            // Update nilai input price dengan nilai yang sudah diformat
            priceInput.value = cleanPrice;

            // Membuat objek FormData
            const formData = new FormData(this);
            formData.set('price', cleanPrice);


            createOverlay('Proses...'); // Tampilkan overlay

            // Mengirim data formulir menggunakan AJAX
            $.ajax({
                url: ' {{ route('kelas.edit', ['CourseId' => $course->course->id]) }}', // Menggunakan URL dari atribut action
                type: 'POST',
                data: formData, // Mengambil data dari formulir
                processData: false, // Mencegah jQuery mengubah data
                contentType: false, // Mencegah jQuery menetapkan konten
                success: function(response) {
                    gOverlay.hide();
                    // Lakukan sesuatu setelah berhasil
                    if (response.success) {
                        Swal.fire('Sukses!', response.message, 'success');
                        // Reload halaman atau arahkan ke halaman lain jika diperlukan
                        // Tunggu 1.5 detik sebelum reload
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        Swal.fire('Ooops!', response.message + response.body, 'error');
                    }

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

        document.getElementById('deleteButton').addEventListener('click', function() {
            const CourseId = this.getAttribute('data-id');

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
                    fetch(`/admin/kelas/delete/${CourseId}`, {
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
                                        '{{ route('admin.kelas') }}'; // Redirect to the admin bundling page
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
        $('#additional-src-type').hide()
        $('#quiz-type').hide()

        $(document).ready(function() {
            $('#contentVideoArticleContent').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline']], // Text styles
                    ['color', ['color']], // Text color
                    ['para', ['ul', 'ol']], // Lists
                    ['misc', ['undo', 'redo']] // Miscellaneous
                ],
                height: 300, // Set editor height
                placeholder: 'Masukan Materi atau deskripsi video...' // Placeholder text
            });
        });

        //QUIZ
        var optionQuiz = []

        var quizees = []


        function showQuizzes() {
            $('.quizzesList').empty();
            quizees.forEach((quiz, index) => {
                // Create a list item for each quiz
                var quizItem = `<div class='card p-4'>
                    <p>${quiz.question}</p>` +
                    quiz.options.map((option, indexOption) => {
                        return `<div><label><input type="radio" name="option-${index}" ${quiz.options[quiz.answer] == option ? "checked" : ""} disabled> ${option}</label></div>`;
                    }).join('') +
                    `
                     <div class="row">
                                         <div class="d-flex justify-content-end">
                <button class="btn btn-danger btn-sm me-2" onclick="deleteQuiz(${index})">
                    <i class="fas fa-trash d-md-inline"></i> <!-- Show icon only on medium and larger screens -->
                    <span class="d-none d-md-inline">Hapus</span> <!-- Show text only on medium and larger screens -->
                </button>
                <button class="btn btn-primary btn-sm" onclick="showQuizModal(${index})">
                    <i class="fas fa-edit d-md-inline"></i> <!-- Show icon only on medium and larger screens -->
                    <span class="d-none d-md-inline">Edit</span> <!-- Show text only on medium and larger screens -->
                </button>
            </div>
                                    </div>
                </div>`;

                $('.quizzesList').append(quizItem);
            });
        }



        $('#contentType').on('change', function() {
            changeForm()
        });


        function changeForm() {
            var selectedValue = $('#contentType').val();

            if (selectedValue == 'additional_source') {
                $('#additional-src-type').show()
                $('#quiz-type').hide()
                $('#video-type').hide()
            } else if (selectedValue == 'quiz') {
                $('#additional-src-type').hide()
                $('#quiz-type').show()
                $('#video-type').hide()
                showQuizzes()

            } else {
                $('#additional-src-type').hide()
                $('#quiz-type').hide()
                $('#video-type').show()
            }
        }



        //POST CONTENT
        $('#saveContent').on('click', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const contentName = $('#contentName').val()
            const contentDesc = $('#contentDesc').val()
            const contentType = $('#contentType').val()

            var formData = new FormData();
            formData.append('contentTitle', contentName);
            formData.append('contentDesc', contentDesc);
            formData.append('contentType', contentType);


            if (contentType == 'video') {
                const contentVideoFile = $('#contentVideoFile')[0].files[0];
                const contentVideoThumbFile = $('#contentVideoThumbFile')[0].files[0];

                const videoArticleContent = $('#contentVideoArticleContent').val()
                const videoDuration = $('#contentVideoDuration').val()

                // **Validasi format video**
                const allowedVideoFormats = ['video/mp4'];
                const allowedThumbnailFormats = ['image/jpeg', 'image/png', 'image/jpg'];

                if (!allowedVideoFormats.includes(contentVideoFile.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Video Tidak Valid!',
                        text: 'Silakan pilih file dengan format MP4.',
                    });
                    return; // Hentikan proses jika format salah
                }

                // **Validasi format thumbnail**
                if (!allowedThumbnailFormats.includes(contentVideoThumbFile.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Thumbnail Tidak Valid!',
                        text: 'Silakan pilih file dengan format JPG, PNG, atau JPEG.',
                    });
                    return; // Hentikan proses jika format salah
                }

                // formData.append('videoContentFile', contentVideoFile);
                formData.append('videoContentThumbFile', contentVideoThumbFile);
                formData.append('videoArticleContent', videoArticleContent);
                formData.append('videoDuration', videoDuration);

                uploadVideoInChunks(contentVideoFile, formData);

                return;

            } else if (contentType == 'quiz') {
                const passingGrade = $('#contentPassingGrade').val()

                formData.append('quizzes', JSON.stringify({
                    'passing_grade': +passingGrade,
                    'quiz_content': quizees
                }))
            } else if (contentType == 'additional_source') {
                const additionalSrcFile = $('#contentAddSrcFile')[0].files[0];

                formData.append('additionalSrcFile', additionalSrcFile);
            } else {

            }

            createOverlay("Proses...");

            $.ajax({
                url: '{{ route('admin.kelas.content.post', $courseId) }}', // Direct API endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    gOverlay.hide()
                    Swal.fire('Berhasil', 'Berhasil membuat konten', 'success');

                    // Tunggu 1.5 detik sebelum reload
                    setTimeout(function() {
                        window.location.href = '?selectedCourseContentId=' + response.data.id
                    }, 1500);

                },
                error: function(xhr, status, error) {
                    gOverlay.hide()
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
            });
        })

        function uploadVideoInChunks(file, formData) {
            const chunkSize = 5 * 1024 * 1024; // 5MB per chunk
            let totalChunks = Math.ceil(file.size / chunkSize);
            let fileId = uuid.v4();
            let chunkIndex = 0;

            // 🔹 Menampilkan Swal dengan Progress Bar
            Swal.fire({
                title: "Uploading...",
                html: `<div class="progress">
                    <div id="uploadProgress" class="progress-bar progress-bar-striped progress-bar-animated"
                         role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    0%
                    </div>
               </div>`,
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
                didOpen: () => {
                    uploadNextChunk(); // Mulai upload setelah modal muncul
                }
            });

            function updateProgress() {
                let progress = Math.round((chunkIndex / totalChunks) * 100);
                $("#uploadProgress").css("width", progress + "%").text(progress + "%");
            }

            function uploadNextChunk() {
                let start = chunkIndex * chunkSize;
                let end = Math.min(start + chunkSize, file.size);
                let chunk = file.slice(start, end);
                let chunkFormData = new FormData();
                chunkFormData.append("video_content", new File([chunk], file.name, {
                    type: file.type
                }));
                chunkFormData.append("video_id", fileId);
                chunkFormData.append("chunk_index", chunkIndex);
                chunkFormData.append("total_chunks", totalChunks);

                // Tambahkan formData tambahan di setiap chunk
                for (let [key, value] of formData.entries()) {
                    chunkFormData.append(key, value);
                }

                $.ajax({
                    url: "{{ route('admin.kelas.content.post', $courseId) }}",
                    type: "POST",
                    data: chunkFormData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        chunkIndex++;
                        updateProgress(); // Perbarui progress bar di Swal

                        if (chunkIndex < totalChunks) {
                            uploadNextChunk(); // Lanjut ke chunk berikutnya
                        } else {
                            $("#uploadProgress").css("width", "100%").text("Upload Selesai!");
                            Swal.fire({
                                icon: "success",
                                title: "Upload Selesai!",
                                text: "Video berhasil diunggah.",
                                confirmButtonText: "OK"
                            }).then(() => {
                                // Arahkan ke halaman baru setelah pengguna menekan OK
                                window.location.href = '?selectedCourseContentId=' + response.data.id;
                            });

                            // Aktifkan kembali tombol setelah upload selesai
                            $("#saveContent").prop("disabled", false);

                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Upload Gagal!",
                            text: xhr.responseJSON.message,
                            confirmButtonText: "Coba Lagi"
                        });
                        $("#saveContent").prop("disabled", false); // Aktifkan kembali jika gagal
                    }
                });
            }

            // 🔹 Nonaktifkan tombol saat upload berjalan
            $("#saveContent").prop("disabled", true);
        }


        var idQuizzesEdit = null

        function showQuizModal(indexQuiz) {
            idQuizzesEdit = null
            $('#questionQuizInput').val(''),
                optionQuiz.splice(0, optionQuiz.length);
            const modal = new bootstrap.Modal(document.getElementById('modal-quiz'));
            if (indexQuiz != null) {
                idQuizzesEdit = indexQuiz

                $('#questionQuizInput').val(quizees[indexQuiz].question)
                quizees[indexQuiz].options.forEach((option, index) => {
                    optionQuiz.push(option)
                })


            }
            showOptionQuiz()
            if (indexQuiz != null) {
                $('#answerQuizInput').val(quizees[indexQuiz].answer).change()
            }
            modal.show();
        }

        function deleteQuiz(indexQuiz) {
            if (indexQuiz != null) {
                quizees.splice(indexQuiz, 1);
                showQuizzes()
            }
        }

        function addOptionQuiz(index = null) {
            // Get the value from the input field
            const val = $('#optionQuizInput').val().trim(); // Trim whitespace to avoid empty values

            // Validate the input: if it's empty, stop the function
            if (val === '') {
                Swal.fire({
                    title: 'Ooops!',
                    text: 'Opsi tidak boleh kosong!',
                    icon: 'warning',
                    timer: 1500,
                    showConfirmButton: false
                });
                return;
            }

            // Check if we are editing an option (index is not null)
            if (index != null) {
                // Update the existing option
                optionQuiz[index] = val;
            } else {
                // Check for duplicates before adding a new option
                if (optionQuiz.includes(val)) {
                    Swal.fire({
                        title: 'Duplikat!',
                        text: 'Opsi ini sudah ada dalam daftar.',
                        icon: 'warning',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    return;
                }
                // Add new option to the array
                optionQuiz.push(val);
            }

            // Clear the input field for future inputs
            $('#optionQuizInput').val('');

            // Update the display of options
            showOptionQuiz();
        }


        function showOptionQuiz() {
            // Clear the existing options
            $('.option-quiz-add').empty();

            // Iterate through each option and create a card for it
            optionQuiz.forEach((option, index) => {
                const quizItem = `
            <div class='card mb-3 shadow-sm'>
                <div class='card-body'>
                    <div class='d-flex justify-content-between align-items-center'>
                        <p class='mb-0'>${option}</p>
                        <button class="btn btn-danger btn-sm" onclick="deleteOptionQuiz(${index})">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        `;

                // Append the new card to the container
                $('.option-quiz-add').append(quizItem);
            });

            // Call a function to merge answers and options if needed
            mergeAnswerAndOption();
        }


        function deleteOptionQuiz(index) {
            if (index != null) {
                optionQuiz.splice(index, 1);
                showOptionQuiz()
            }
        }

        function mergeAnswerAndOption() {
            $('#answerQuizInput').empty();
            optionQuiz.forEach((option, index) => {
                $('#answerQuizInput').append(
                    $('<option>', {
                        value: index,
                        text: option
                    })
                );
            })
        }

        function submitOptionQuiz() {
            if (idQuizzesEdit != null) {
                quizees[idQuizzesEdit] = {
                    'question': $('#questionQuizInput').val(),
                    'answer': +$('#answerQuizInput').val(),
                    'options': Array.from(optionQuiz)
                }

            } else {
                quizees.push({
                    'question': $('#questionQuizInput').val(),
                    'answer': +$('#answerQuizInput').val(),
                    'options': Array.from(optionQuiz)
                })
            }
            $('#modal-quiz').modal('hide');
            showQuizzes()
        }
    </script>


    @if ($selectedCourseContentId != '')
        <script>
            $('#contentName').val('{{ $courseContent->content_title }}')
            $('#contentType').val('{{ $courseContent->content_type }}').change()
            $('#contentType').prop('disabled', true);
            changeForm()
            $('#contentDesc').val(`{{ $courseContent->content_description }}`);
            adjustTextareaHeight(contentDesc);

            const contentType = $('#contentType').val()


            // else if(contentType == 'quiz'){
            //   $('#contentPassingGrade').val()
            // }



            function deleteContent() {
                createOverlay("Proses...");
                $.ajax({
                    url: '{{ route('admin.kelas.content.delete', ['courseId' => $courseId, 'id' => $selectedCourseContentId]) }}', // Direct API endpoint
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        gOverlay.hide()
                        Swal.fire('Berhasil', 'Berhasil mengapus konten', 'success');
                        // Tunggu 1.5 detik sebelum reload
                        setTimeout(function() {
                            window.location.href = '?selectedCourseContentId='
                        }, 1500);

                    },
                    error: function(xhr, status, error) {
                        gOverlay.hide()
                        Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                    }
                });
            }

            function updateCourseContent() {
                const contentName = $('#contentName').val()
                const contentDesc = $('#contentDesc').val()
                var isUpdateContentFile = false
                var formData = new FormData();
                formData.append('contentTitle', contentName);
                formData.append('contentDesc', contentDesc);

                if (contentType == 'video') {
                    const contentVideoFile = $('#contentVideoFile')[0].files[0];
                    const contentVideoThumbFile = $('#contentVideoThumbFile')[0].files[0];

                    if (contentVideoFile || contentVideoThumbFile) {
                        isUpdateContentFile = true
                    }

                    // **Validasi format video**
                    const allowedVideoFormats = ['video/mp4'];
                    const allowedThumbnailFormats = ['image/jpeg', 'image/png', 'image/jpg'];

                    if (!allowedVideoFormats.includes(contentVideoFile.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format Video Tidak Valid!',
                            text: 'Silakan pilih file dengan format MP4.',
                        });
                        return; // Hentikan proses jika format salah
                    }

                    // **Validasi format thumbnail**
                    if (!allowedThumbnailFormats.includes(contentVideoThumbFile.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format Thumbnail Tidak Valid!',
                            text: 'Silakan pilih file dengan format JPG, PNG, atau JPEG.',
                        });
                        return; // Hentikan proses jika format salah
                    }


                    // Mengambil konten dari Summernote
                    const videoArticleContent = $('#contentVideoArticleContent').val();
                    const videoDuration = $('#contentVideoDuration').val()

                    // formData.append('videoContentFile', contentVideoFile);
                    formData.append('videoContentThumbFile', contentVideoThumbFile);
                    formData.append('videoArticleContent', videoArticleContent);
                    formData.append('videoDuration', videoDuration);

                    updateVideoInChunks(contentVideoFile, formData);
                    return;

                } else if (contentType == 'additional_source') {
                    const additionalSrcFile = $('#contentAddSrcFile')[0].files[0];
                    if (additionalSrcFile) {
                        isUpdateContentFile = true
                    }
                    formData.append('additionalSrcFile', additionalSrcFile);
                } else if (contentType == 'quiz') {
                    const passingGrade = $('#contentPassingGrade').val()

                    formData.append('quizzes', JSON.stringify({
                        passing_grade: +passingGrade,
                        quizz_content: quizees
                    }))
                }


                formData.append('isUpdateContentFile', isUpdateContentFile);
                createOverlay("Proses...");
                $.ajax({
                    url: '{{ route('admin.kelas.content.update', ['courseId' => $courseId, 'contentId' => $selectedCourseContentId]) }}', // Direct API endpoint
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        gOverlay.hide()
                        Swal.fire('Berhasil', 'Berhasil memperbarui konten', 'success')

                        // Tunggu 1.5 detik sebelum reload
                        setTimeout(function() {
                            window.location.reload()
                        }, 1500);

                    },
                    error: function(xhr, status, error) {
                        gOverlay.hide()
                        Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                    }
                });
            }

            function updateVideoInChunks(file, formData) {
                const chunkSize = 5 * 1024 * 1024; // 5MB per chunk
                let totalChunks = Math.ceil(file.size / chunkSize);
                let fileId = uuid.v4();
                let chunkIndex = 0;

                // 🔹 Menampilkan Swal dengan Progress Bar
                Swal.fire({
                    title: "Uploading...",
                    html: `<div class="progress">
                    <div id="uploadProgress" class="progress-bar progress-bar-striped progress-bar-animated"
                         role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    0%
                    </div>
               </div>`,
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        uploadNextChunk(); // Mulai upload setelah modal muncul
                    }
                });

                function updateProgress() {
                    let progress = Math.round((chunkIndex / totalChunks) * 100);
                    $("#uploadProgress").css("width", progress + "%").text(progress + "%");
                }

                function uploadNextChunk() {
                    let start = chunkIndex * chunkSize;
                    let end = Math.min(start + chunkSize, file.size);
                    let chunk = file.slice(start, end);
                    let chunkFormData = new FormData();
                    chunkFormData.append("video_content", new File([chunk], file.name, {
                        type: file.type
                    }));
                    chunkFormData.append("video_id", fileId);
                    chunkFormData.append("chunk_index", chunkIndex);
                    chunkFormData.append("total_chunks", totalChunks);

                    // Tambahkan formData tambahan di setiap chunk
                    for (let [key, value] of formData.entries()) {
                        chunkFormData.append(key, value);
                    }

                    $.ajax({
                        url: '{{ route('admin.kelas.content.update', ['courseId' => $courseId, 'contentId' => $selectedCourseContentId]) }}', // Direct API endpoint
                        type: "POST",
                        data: chunkFormData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            chunkIndex++;
                            updateProgress(); // Perbarui progress bar di Swal

                            if (chunkIndex < totalChunks) {
                                uploadNextChunk(); // Lanjut ke chunk berikutnya
                            } else {
                                $("#uploadProgress").css("width", "100%").text("Upload Selesai!");
                                Swal.fire({
                                    icon: "success",
                                    title: "Upload Selesai!",
                                    text: "Video berhasil diunggah.",
                                    confirmButtonText: "OK"
                                }).then(() => {
                                    // Arahkan ke halaman baru setelah pengguna menekan OK
                                    window.location.href = '?selectedCourseContentId=' + response.data.id;
                                });

                                // Aktifkan kembali tombol setelah upload selesai
                                $("#saveContent").prop("disabled", false);

                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: "error",
                                title: "Upload Gagal!",
                                text: xhr.responseJSON.message,
                                confirmButtonText: "Coba Lagi"
                            });
                            $("#saveContent").prop("disabled", false); // Aktifkan kembali jika gagal
                        }
                    });
                }

                // 🔹 Nonaktifkan tombol saat upload berjalan
                $("#saveContent").prop("disabled", true);
            }
        </script>

        @if ($courseContent->content_type == $videoType)
            <script>
                $(document).ready(function() {
                    // Inisialisasi Summernote
                    $('#contentVideoArticleContent').summernote({
                        height: 200, // Atur tinggi editor
                        placeholder: 'Tulis artikel di sini...',
                    });

                    // Mengisi konten dari variabel server-side ke Summernote
                    var articleContent =
                        `{!! $courseContent->video->article_content !!}`;
                    $('#contentVideoArticleContent').summernote('code', articleContent);
                });

                $('#contentVideoDuration').val('{{ $courseContent->video->video_duration }}')
            </script>
        @elseif($courseContent->content_type == $quizType)
            <script>
                $('#contentPassingGrade').val('{{ $courseContent->quiz->passing_grade }}')
                quizees.splice(0, quizees.length);
                var quizzesFromPhp = @json($courseContent->quiz->questions);
                quizzesFromPhp.forEach((quiz, index) => {
                    quizees.push({
                        'question': quiz.question,
                        'answer': quiz.answer,
                        'options': quiz.options
                    })
                })
                showQuizzes()
            </script>
        @endif

    @endif



@endsection

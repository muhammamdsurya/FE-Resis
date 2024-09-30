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

    <form id="courseForm" method="POST" action="{{ route('kelas.post') }}">
        @csrf

        <div class="container">
            <div class="row">
                <!-- Data Kelas Section -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Data Kelas</h5>
                        </div>
                        <div class="card-body">
                            <div class="image-container text-center mb-4 position-relative">
                                <img src="{{ $course->course->thumbnail_image }}" alt="{{ $course->course->name }}"
                                    class="img-fluid" id="imagePreview" width="200rem" height="200rem"
                                    style="cursor: pointer;">
                                <div class="overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                                    style="top: 0; left: 0; background: rgba(0, 0, 0, 0.5); color: white; font-size: 1.5rem; display: none;">
                                    Ganti Gambar
                                </div>
                                <input type="file" id="imageUpload" name="image" style="display: none;"
                                    accept="image/*">
                            </div>

                            <!-- Form Row 1: Name and Jenjang -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="nameInput" placeholder="Nama Kelas"
                                            name="name" value="{{ $course->course->name }}">
                                        <label for="nameInput">Nama Kelas</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="priceInput" placeholder="Harga"
                                            name="price" value="{{ $course->course->price }}">
                                        <label for="priceInput">Harga</label>
                                    </div>
                                </div>

                            </div>

                            <!-- Form Row 2: Description and Price -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control" id="categorySelect" name="level">
                                            <option value="" disabled>Select Jenjang</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="categorySelect">Jenjang</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control" id="instructorSelect" name="instructor">
                                            <option value="" disabled>Select Pengajar</option>
                                            @foreach ($instructors as $instructor)
                                                <option value="{{ $instructor->instructor->id }}">
                                                    {{ $instructor->full_name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="instructorSelect">Pengajar</label>
                                    </div>
                                </div>


                            </div>

                            <!-- Form Row 3: Instructor and Purpose -->
                            <div class="row mb-3">
                                <div class="col-md-6">
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
                                    @if (isset($courseContent))
                                        @foreach ($courseContent as $courseContentSidebar)
                                        @dd($courseContentSidebar)
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
                                    <a href="/user/diskusi" class="list-group-item list-group-item-action">Diskusi</a>
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
                                        @if (isset($courseContent))
                                            @foreach ($courseContent as $courseContentSidebar)
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
                                        <li><a class="dropdown-item" href="/user/diskusi">Diskusi</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <div class="container">
        <section class="col-12 mt-2">
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
                                <div class="row mb-3">
                                    <div class="col-md-6">
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
                                </div>

                                <!-- Deskripsi Materi -->
                                <div class="mb-3">
                                    <label for="contentDesc">Deskripsi Materi</label>
                                    <textarea id="contentDesc" class="form-control" name="description" placeholder="Deskripsi" required></textarea>
                                </div>

                                <!-- Video Type Content Section -->
                                <div id="video-type" class="content-type-section">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control"
                                                    id="contentVideoArticleContent" placeholder="Judul Konten Video"
                                                    name="video_content_name" required>
                                                <label for="contentVideoArticleContent">Judul Konten Video</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="number" class="form-control" id="contentVideoDuration"
                                                    placeholder="Durasi Video" name="video_duration" required>
                                                <label for="contentVideoDuration">Durasi Video (detik)</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Display Existing Video Content -->
                                    @if ($selectedCourseContentId != '' && $courseContent->content_type == $videoType)
                                        <div class="ratio ratio-16x9 mb-3">
                                            <video controls poster="{{ $courseContent->video->thumbnail_image }}">
                                                <source src="{{ $courseContent->video->video_file }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    @endif

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

                                <!-- Additional Source Type Content Section -->
                                <div id="additional-src-type" class="content-type-section">
                                    @if ($selectedCourseContentId != '' && $courseContent->content_type == $addSrcType)
                                        <div class="ratio ratio-16x9 mb-3">
                                            <iframe src="{{ $courseContent->src->file }}" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                        </div>
                                    @endif

                                    <div class="form-floating mb-3">
                                        <input type="file" class="form-control" id="contentAddSrcFile"
                                            name="additional_source" required>
                                        <label for="contentAddSrcFile">Sumber Tambahan</label>
                                    </div>
                                </div>

                                <!-- Quiz Type Content Section -->
                                <div id="quiz-type" class="content-type-section">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="contentPassingGrade"
                                            placeholder="Nilai Kelulusan" name="passing_grade" required>
                                        <label for="contentPassingGrade">Nilai Kelulusan</label>
                                    </div>

                                    <button type="button" class="btn btn-primary d-flex align-items-center mb-2"
                                        onclick="showQuizModal(null)">
                                        <i class="fas fa-plus mr-1"></i>Tambah Quiz
                                    </button>
                                    <div class="quizzesList"></div>
                                </div>
                            </div>


                    </div>
                    <div class="mt-5">
                        <button onclick="window.location.href='?selectedCourseContentId={{$previousCourseContentId}}'" {{$previousCourseContentId == ''? 'disabled':''}} class="btn btn-secondary"><i class="fas fa-arrow-circle-left mr-2"></i>Sebelumnya</button>
                        @if ($selectedCourseContentId == '')
                            <button id="saveContent" class="btn btn-primary float-right">Simpan</button>
                        @else
                            <button class="btn btn-danger ml-3" onclick="deleteContent()">Hapus</button>
                            <button  onclick="updateCourseContent()" class="btn btn-primary">Simpan</button>

                            <button  onclick="window.location.href='?selectedCourseContentId={{$nextCourseContentId}}'" {{$nextCourseContentId == ''? 'disabled':''}} class="btn btn-primary float-right">Lanjut<i
                                    class="fas fa-arrow-circle-right ml-2"></i></button>
                        @endif
                    </div>
                </div>
                <!-- Kolom untuk Materi Selanjutnya -->
                <div class="col-md-3 d-none d-lg-block materi-container px-3">
                    <div class="list-group mt-3">
                        @if(isset($courseContents))
                        @foreach($courseContents as $courseContentSidebar)
                        <a href="?selectedCourseContentId={{$courseContentSidebar->id}}" class="list-group-item list-group-item-action {{$selectedCourseContentId == $courseContentSidebar->id? 'list-group-item-primary' : ''}}">{{$courseContentSidebar->content_title}}</a>
                        @endforeach
                        @endif
                        <a href="?selectedCourseContentId="
                                class="list-group-item list-group-item-action {{$selectedCourseContentId == ''? 'list-group-item-primary' : ''}}"><i class="fas fa-plus mr-2"></i>Tambah Materi Baru</a>
                        <a href="/user/diskusi" class="list-group-item list-group-item-action ">Diskusi</a>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Modal Kelas -->
    <div class="modal fade" id="modal-quiz" tabindex="-1" aria-labelledby="modal-defaultLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-defaultLabel">Tambah Pertanyaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('kelas.post') }}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="questionQuizInput"
                                        placeholder="Class Name" name="name">
                                    <label for="questionQuizInput">Pertanyaan</label>
                                </div>
                            </div>


                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="answerQuizInput">
                                    </select>
                                    <label for="answerQuizInput">Jawaban</label>
                                </div>
                            </div>


                        </div>



                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="optionQuizInput"
                                        placeholder="Class Name" name="name">
                                    <label for="optionQuizInput">Opsi</label>
                                </div>
                            </div>

                            <div class="col">
                                <button type="button" class="btn btn-primary d-flex align-items-center"
                                    onclick="addOptionQuiz(null)">
                                    <i class="fas fa-plus mr-1"></i>Tambah Opsi
                                </button>
                            </div>
                        </div>

                        <div class="option-quiz-add">

                        </div>


                        <button onclick="submitOptionQuiz()" type="button" class="btn btn-primary">Submit</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- SummerNote -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>



    <script>
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
            $('#contentDesc').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline']], // Text styles
                    ['color', ['color']], // Text color
                    ['para', ['ul', 'ol']], // Lists
                    ['insert', ['link', 'picture']], // Insert link and image
                    ['misc', ['undo', 'redo']] // Miscellaneous
                ],
                height: 300, // Set editor height
                placeholder: 'Type your text here...' // Placeholder text
            });
        });

        //QUIZ
        var optionQuiz = []

        var quizees = []
        quizees.push({
            'question': 'Halo',
            'answer': 1,
            'options': [
                'Jakarta',
                'Bandung',
                'Surabaya'
            ]
        })
        quizees.push({
            'question': 'Whos best??',
            'answer': 2,
            'options': [
                'Bukalapak',
                'Tokopedia',
                'Shopee'
            ]
        })
        quizees.push({
            'question': 'which best??',
            'answer': 0,
            'options': [
                'Go',
                'Php',
                'Python'
            ]
        })

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
                                        <div class="col">
                                                <button class="btn btn-danger ml-3" onclick="deleteQuiz(${index})">Hapus</button>
                                                <button onclick="showQuizModal(${index})" class="btn btn-primary">Edit</button>
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

                formData.append('videoContentFile', contentVideoFile);
                formData.append('videoContentThumbFile', contentVideoThumbFile);
                formData.append('videoArticleContent', videoArticleContent);
                formData.append('videoDuration', videoDuration);
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
                    Swal.fire('Berhasil', 'Berhasil membuat konten', 'success');

                    window.location.href = '?selectedCourseContentId=' + response.data.id

                },
                error: function(xhr, status, error) {
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
            });
        })


        var idQuizzesEdit = null

        function showQuizModal(indexQuiz) {
            idQuizzesEdit = null
            $('#questionQuizInput').val(''),
                optionQuiz.splice(0, optionQuiz.length);
            const modal = new bootstrap.Modal(document.getElementById('modal-quiz'));
            if (indexQuiz != null) {
                idQuizzesEdit = indexQuiz
                console.log(quizees[indexQuiz]);

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

        function addOptionQuiz(index) {
            if (index != null) {
                $('#optionQuizInput').val(optionQuiz[index])
            }

            val = $('#optionQuizInput').val()
            if (val == '') {
                return
            }

            if (index != null) {
                optionQuiz[index] = val
            } else {
                optionQuiz.push(val)
            }

            $('#optionQuizInput').val('')
            showOptionQuiz()
        }

        function showOptionQuiz() {
            // option-quiz-add
            $('.option-quiz-add').empty();
            optionQuiz.forEach((option, index) => {
                var quizItem = `<div class='card p-4'>
                    <p>${option}</p>` +
                    `
                     <div class="row">
                                        <div class="col">
                                                <button class="btn btn-danger ml-3" onclick="deleteOptionQuiz(${index})">Hapus</button>
                                        </div>
                                    </div>
                </div>`;

                $('.option-quiz-add').append(quizItem);
            })
            mergeAnswerAndOption()
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
            $('#contentDesc').val('{!! $courseContent->content_description !!}')

            const contentType = $('#contentType').val()


            // else if(contentType == 'quiz'){
            //   $('#contentPassingGrade').val()
            // }



            function deleteContent() {
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
                        Swal.fire('Berhasil', 'Berhasil mengapus konten', 'success');
                        window.location.href = '?selectedCourseContentId='

                },
                error: function(xhr, status, error) {
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
            });
        }



        function updateCourseContent(){
            const contentName = $('#contentName').val()
            const contentDesc = $('#contentDesc').val()
            var isUpdateContentFile =false
             var formData = new FormData();
            formData.append('contentTitle', contentName);
            formData.append('contentDesc', contentDesc);


            if(contentType == 'video'){
                const contentVideoFile = $('#contentVideoFile')[0].files[0];
                const contentVideoThumbFile = $('#contentVideoThumbFile')[0].files[0];

                if (contentVideoFile || contentVideoThumbFile) {
                    isUpdateContentFile = true
                }

                const videoArticleContent = $('#contentVideoArticleContent').val()
                const videoDuration = $('#contentVideoDuration').val()

                formData.append('videoContentFile', contentVideoFile);
                formData.append('videoContentThumbFile', contentVideoThumbFile);
                formData.append('videoArticleContent', videoArticleContent);
                formData.append('videoDuration', videoDuration);
            }else if(contentType == 'additional_source'){
                const additionalSrcFile = $('#contentAddSrcFile')[0].files[0];
                if (additionalSrcFile) {
                    isUpdateContentFile = true
                }
                formData.append('additionalSrcFile', additionalSrcFile);
            }else if(contentType == 'quiz'){
                const passingGrade = $('#contentPassingGrade').val()

                formData.append('passing_grade', passingGrade)
                formData.append('quizzes',  JSON.stringify(
                    'quiz_content':quizees
                ))
            }


            formData.append('isUpdateContentFile', isUpdateContentFile);

            $.ajax({
                url: '{{ route("admin.kelas.content.update",["courseId" => $courseId, "contentId" => $selectedCourseContentId]) }}', // Direct API endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire('Berhasil', 'Berhasil memperbarui konten', 'success')
                    window.location.reload()

                },
                error: function(xhr, status, error) {
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
            });

        }
    </script>

        @if ($courseContent->content_type == $videoType)
            <script>
                $('#contentVideoArticleContent').val('{{ $courseContent->video->article_content }}')
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

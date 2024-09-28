@extends('layout.adminLayout')
@section('title', $title)

@section('filter')

    <!-- Filter Dropdown -->
    <div class="filter-dropdown d-lg-none d-sm-block ms-md-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                Materi
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Pendahuluan</a></li>
                <li><a class="dropdown-item" href="#">Materi 2</a></li>
                <li><a class="dropdown-item" href="#">Materi 3</a></li>
                <li><a class="dropdown-item" href="#">Materi 4</a></li>
                <li><a class="dropdown-item" href="/user/diskusi">Diskusi</a></li>
            </ul>
        </div>
    </div>

@endsection

@section('content')

    <form id="courseForm" method="POST" action="{{ route('kelas.post') }}">
        @csrf

        <div class="container">
            <div class="image text-center mb-5">
                <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" alt="" class="img-fluid"
                    width="200rem" height="200rem">
            </div>
            <div class="row gy-3 ">
                <div class="col-lg-6 col-md-6 mx-auto">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nameInput" placeholder="name@example.com"
                            name="name" value="{{$course->course->name}}">
                        <label for="nameInput">Nama Kelas</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="priceInput" placeholder="Price" name="price" value="{{$course->course->price}}">
                        <label for="priceInput">Harga</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="descriptionTextarea" name="description"
                            style="height: 100px">{{$course->course->description}}</textarea>
                        <label for="descriptionTextarea">Deskripsi</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mx-auto">
                    <div class="form-floating mb-3">
                        <select class="form-control" id="categorySelect" name="level">
                            <option value="" disabled>Select Jenjang</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}" {{$course->course->course_category_id ==$category->id ?'selected' : '' }}  >{{$category->name}}</option>
                            @endforeach
                            <!-- Options will be populated here -->
                        </select>
                        <label for="jenjangSelect">Jenjang</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="instructorInput" placeholder="Instructor"
                            name="instructor" value="{{$course->instructor->full_name}}">
                        <label for="instructorInput">Pengajar</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Purpose" id="purposeTextarea" name="purpose" style="height: 100px">{{$course->course->purpose}}</textarea>
                        <label for="purposeTextarea">Tujuan</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3" id="course">Simpan</button>
        </div>


    </form>


    <div class="container-fluid">

        <section class="col-12 mt-2 pb-5">

            <div class="row">
                <!-- Kolom untuk Video dan Penjelasan -->
                <div class="col-md-9">
                    <div class="mt-3">
                        @if ($selectedCourseContentId == '')
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="contentName" placeholder="name@example.com"
                                    name="name">
                                <label for="contentName">Judul Materi</label>
                            </div>

                            <div class="form-floating mb-3 mt-3">
                                <select class="form-control" id="contentType" name="level">
                                    <option value="video" selected>video</option>
                                    <option value="quiz">quiz</option>
                                    <option value="additional_source">additional_source</option>
                                </select>
                                <label for="contentType">Jenis Konten</label>
                            </div>

                            <div id="video-type">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="contentVideoArticleContent" placeholder="name@example.com"
                                        name="name">
                                    <label for="contentVideoArticleContent">Judul Konten</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="file" class="form-control" id="contentVideoFile"
                                        placeholder="name@example.com" name="name">
                                    <label for="contentVideoFile">Konten Video</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="file" class="form-control" id="contentVideoThumbFile"
                                        placeholder="name@example.com" name="name">
                                    <label for="contentVideoThumbFile">Thumbnail</label>
                                </div>
                                <label >Materi</label>
                                <div class="form-floating mb-3">
                                    <textarea id="summernote" name="description"></textarea>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="contentVideoDuration"
                                        placeholder="name@example.com" name="name">
                                    <label for="contentVideoDuration">Durasi Video</label>
                                </div>
                            </div>

                            <div id="additional-src-type">
                                <div class="form-floating mb-3">
                                    <input type="file" class="form-control" id="contentName"
                                        placeholder="name@example.com" name="name">
                                    <label for="contentName">Source Tambahan</label>
                                </div>
                            </div>

                            <div id="quiz-type">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="contentName"
                                        placeholder="name@example.com" name="name">
                                    <label for="contentName">Nilai Kelulusan</label>
                                </div>
                            </div>
                        @else
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/CpSoqTvSAF0?si=MyY3y8RuEgSAORQk"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                            <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas voluptatum
                                molestiae obcaecati! Laudantium ipsum ea perferendis molestiae praesentium voluptates. Error
                                consectetur voluptas cupiditate doloribus maiores, sapiente sequi dignissimos dolor
                                voluptatem, illum voluptates, quos laboriosam nobis neque aut debitis? Cum, exercitationem!
                                Voluptas autem voluptates esse, a aliquid facilis, doloremque pariatur consectetur eos
                                dolore illum earum temporibus sapiente nobis velit accusamus quam iusto molestias asperiores
                                quis! Adipisci magni soluta illo? Veniam delectus assumenda qui sed possimus laboriosam
                                libero, ex ipsa itaque esse officiis natus placeat odio tempore numquam voluptate commodi
                                iusto vitae enim aperiam? Necessitatibus, iusto expedita reprehenderit ratione qui error
                                asperiores.</p>
                        @endif
                    </div>
                    <div class="mt-5">
                        <button class="btn btn-secondary"><i class="fas fa-arrow-circle-left mr-2"></i>Sebelumnya</button>
                        @if ($selectedCourseContentId == '')
                            <button id="saveContent" class="btn btn-primary float-right">Simpan</button>
                        @else
                            <button class="btn btn-primary float-right">Lanjut<i
                                    class="fas fa-arrow-circle-right ml-2"></i></button>
                        @endif
                    </div>
                </div>
                <!-- Kolom untuk Materi Selanjutnya -->
                <div class="col-md-3 d-none d-lg-block materi-container px-3">

                    <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#modal-kelas"
                        onclick="location.href='/admin/detail-kelas/{{ $courseId }}/add'">
                        <i class="fas fa-plus mr-1"></i>Materi
                    </button>
                    <div class="list-group mt-3">
                        <!-- <a href="#" class="list-group-item list-group-item-action ">Pendahuluan</a> -->
                        @if ($selectedCourseContentId == '')
                            <a href="#"
                                class="list-group-item list-group-item-action list-group-item-primary">Materi Baru</a>
                        @endif
                        <!-- <a href="#" class="list-group-item list-group-item-action ">Materi 1</a>
                                <a href="#" class="list-group-item list-group-item-action ">Materi 2</a>
                                <a href="#" class="list-group-item list-group-item-action ">Materi 3</a>
                                <a href="#" class="list-group-item list-group-item-action ">Materi 4</a> -->
                        <a href="/user/diskusi" class="list-group-item list-group-item-action ">Diskusi</a>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- SummerNote -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

    @if ($selectedCourseContentId == '')
        <script>
            $(document).ready(function() {
                $('#summernote').summernote({
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
        </script>
    @endif

    <script>

        $('#additional-src-type').hide()
        $('#quiz-type').hide()

        $('#contentType').on('change', function() {
            var selectedValue = $(this).val();
            console.log("Selected content type:", selectedValue);
            if (selectedValue == 'additional_source') {
                $('#additional-src-type').show()
                $('#quiz-type').hide()
                $('#video-type').hide()
            } else if (selectedValue == 'quiz') {
                $('#additional-src-type').hide()
                $('#quiz-type').show()
                $('#video-type').hide()

            } else {
                $('#additional-src-type').hide()
                $('#quiz-type').hide()
                $('#video-type').show()
            }


        });


        //POST CONTENT
        $('#saveContent').on('click', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const contentName = $('#contentName').val()
            const contentDesc = $('#contentDesc').val()
            const contentType = $('#contentType').val()



            console.log(contentType);

            var formData = new FormData();
            formData.append('contentTitle', contentName);
            formData.append('contentDesc', contentDesc);
            formData.append('contentType', contentType);


            if(contentType == 'video'){
                const contentVideoFile = $('#contentVideoFile')[0].files[0];
                const contentVideoThumbFile = $('#contentVideoThumbFile')[0].files[0];

                const videoArticleContent = $('#contentVideoArticleContent').val()
                const videoDuration = $('#contentVideoDuration').val()

                formData.append('videoContentFile', contentVideoFile);
                formData.append('videoContentThumbFile', contentVideoThumbFile);
                formData.append('videoArticleContent', videoArticleContent);
                formData.append('videoDuration', videoDuration);
            }else if(contentType == 'quiz'){

            }else if(contentType == 'additional_source'){

            }else{

            }


            $.ajax({
                url: '{{ route("admin.kelas.content.post", $courseId) }}', // Direct API endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("data:", response); // Log the response for debugging
                    Swal.fire('Berhasil', 'Berhasil membuat konten', 'success');

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error); // Log the error for debugging
                    console.error('Response Text:', xhr.responseText);
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
            });
        })
</script>



@endsection

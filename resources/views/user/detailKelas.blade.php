@php
    if ($course) {
        // Gunakan null coalescing untuk menghindari kesalahan count()
        $courseContents = $courseContents ?? []; // Pastikan ini adalah array

        // Count total classes and completed ones
        $totalClasses = count($courseContents);
        $completedClasses = 0;

        foreach ($courseContents as $courseContentSidebar) {
            if ($courseContentSidebar->is_completed) {
                $completedClasses++;
            }
        }

        $completionPercentage = $totalClasses > 0 ? floor(($completedClasses / $totalClasses) * 100) : 0; // Use floor or round as needed
    } else {
        $totalClasses = 0;
        $completedClasses = 0; // Pastikan ini didefinisikan meskipun $course tidak ada
        $completionPercentage = 0; // Pastikan ini didefinisikan meskipun $course tidak ada
    }
@endphp

@extends('layout.userLayout')
@section('title', isset($courseContent) ? $courseContent->content_title : $title)


@section('filter')
    <!-- Filter Dropdown for Course Content -->
    <div class="filter-dropdown d-md-none d-sm-block ms-md-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                Materi
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @if (isset($courseContents))
                    @foreach ($courseContents as $courseContentSidebar)
                        <li>
                            <a href="?selectedCourseContentId={{ $courseContentSidebar->content_id }}"
                                class="dropdown-item {{ $selectedCourseContentId == $courseContentSidebar->content_id ? 'active' : '' }}"
                                {{ $courseContentSidebar->is_completed == false ? ($selectedCourseContentId == $courseContentSidebar->content_id ? '' : 'disabled') : '' }}>
                                {{ $courseContentSidebar->courseDetail->content_title }}
                            </a>
                        </li>
                    @endforeach
                @endif
                <li><a href="/user/diskusi-kelas/{{ $course->course->id }}" class="dropdown-item">Diskusi</a></li>

                <!-- Tambahan Lihat Ulasan -->
                <li>
                    @if (isset($userRate))
                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reviewModal"
                            disabled>
                            Lihat Ulasan
                        </a>
                    @else
                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reviewModal"
                            disabled>
                            Tambah Ulasan
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    <!-- Modal untuk Lihat dan Tambah Ulasan -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">
                        @if (isset($userRate) && $userRate != null)
                            Lihat Ulasan
                        @else
                            Tambah Ulasan
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (isset($userRate) && $userRate != null)
                        <!-- Tampilkan ulasan jika sudah ada -->
                        <div class="review-content">
                            <p><strong>Ulasan:</strong></p>
                            <p>{{ $userRate->description }}</p>
                            <div class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $userRate->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    @else
                        <!-- Form untuk ulasan dan rating -->
                        <div class="form-floating mt-2 mb-1">
                            <textarea class="form-control" id="descRateMobile" placeholder="Tulis ulasan Anda di sini..." rows="4"></textarea>
                            <label for="descRateMobile">Ulasan</label>
                        </div>
                        <div class="rating text-center">
                            <input type="radio" id="star5Mobile" name="ratingMobile" value="5">
                            <label for="star5Mobile" title="5 star"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star4Mobile" name="ratingMobile" value="4">
                            <label for="star4Mobile" title="4 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star3Mobile" name="ratingMobile" value="3">
                            <label for="star3Mobile" title="3 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star2Mobile" name="ratingMobile" value="2">
                            <label for="star2Mobile" title="2 stars"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star1Mobile" name="ratingMobile" value="1">
                            <label for="star1Mobile" title="1 star"><i class="fas fa-star"></i></label>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if (!isset($userRate) || $userRate == null)
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary">Kirim Ulasan</button>
                    @else
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection


@section('content')

    <style>
        /* Hide the actual radio button */

        /* Default state for the label */
        .custom-radio-option label {
            /* No border initially */
            cursor: pointer;
            transition: all 0.3s ease;
            /* Smooth transition */
        }


        /* When the radio input is checked, apply a transparent effect */
        input[type="radio"]:checked+label {
            background-color: rgba(27, 229, 0, 0.2);
            /* Semi-transparent green background */
            color: rgba(0, 0, 0, 1);
            /* Slightly transparent white text */
            /* Transparent green border */
            transition: all 0.3s ease;
            /* Smooth transition */
        }

        .rating {
            display: flex;
            justify-content: flex-end;
            transform: scaleX(-1);
        }

        .rating input {
            display: none;
            /* Sembunyikan input radio */
        }

        .rating label {
            cursor: pointer;
            font-size: 2rem;
            /* Ukuran ikon bintang */
            color: #ccc;
            /* Warna bintang tidak terpilih */
        }

        .rating input:checked~label {
            color: #f39c12;
            /* Warna bintang terpilih */
        }

        .rating label:hover,
        .rating label:hover~label {
            color: #f39c12;
            /* Warna bintang saat hover */
        }

        /* Menyediakan warna kuning untuk bintang yang terpilih */
        .rating input:checked+label,
        .rating input:checked+label~label {
            color: #f39c12;
            /* Warna kuning */
        }

        #showStar {
            color: #f39c12;
        }
    </style>


    <div class="container-fluid">


        <!-- Progress bar -->
        <div class="progress mt-3 d-md-none d-sm-block" style="height: 25px;"> <!-- Adjusted height here -->
            <div class="progress-bar" role="progressbar"
                style="width: {{ $completionPercentage }}%; height: 100%; background-color: #28a745; font-size: 1.2em;"
                aria-valuenow="{{ $completionPercentage }}" aria-valuemin="0" aria-valuemax="100">
                {{ $completionPercentage }}% Tercapai
            </div>
        </div>


        <section class="col-12 mt-2 pb-5">
            @if (isset($course))
                <div class="row">
                    <!-- Kolom untuk Video dan Penjelasan -->
                    <div class="col-md-9">
                        @if (isset($courseContent))
                            <div class="mt-3">

                                @if ($courseContent->content_type == $videoType)
                                    <div class="ratio ratio-16x9 mb-3">
                                        <video controls poster="{{ $courseContent->video->thumbnail_image }}" controls
                                            controlsList="nodownload" oncontextmenu="return false;">
                                            <source src="{{ $courseContent->video->video_file }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    <p>{!! $courseContent->content_description !!}</p>
                                @elseif($courseContent->content_type == $addSrcType)
                                    <div class="ratio ratio-16x9 mb-3">
                                        <iframe src="{{ $courseContent->src->file }}" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                    </div>
                                @elseif($courseContent->content_type == $quizType)
                                 @if(isset($courseContent->quiz->questions))
                                 @foreach ($courseContent->quiz->questions as $quiz)
                                        <div class="card p-4 mb-3 shadow-sm border-0 rounded-lg">
                                            <!-- Added shadow, no border, and rounded corners -->
                                            <p class="font-weight-bold h5 mb-3">{{ $quiz->question }}</p>
                                            <!-- Styled question text for emphasis -->

                                            @foreach ($quiz->Options as $option)
                                                <div class="form-check mb-2 bg-light p-1 rounded custom-radio-option"
                                                    style="cursor: pointer;">
                                                    <!-- Hidden radio button -->
                                                    <input class="form-check-input d-none" type="radio"
                                                        id="option-{{ $quiz->index }}-{{ $option->index }}"
                                                        name="option-{{ $quiz->index }}" value="{{ $option->index }}"
                                                        onclick="answer('{{ $quiz->index }}', '{{ $option->index }}')">
                                                    <!-- Custom label that will show the selection state -->
                                                    <label class="form-check-label py-1 w-100 rounded "
                                                        for="option-{{ $quiz->index }}-{{ $option->index }}">
                                                        {{ $option->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                    <div class="d-flex justify-content-end mt-3"> <!-- Right-aligns the button -->
                                        <button id="submitBtnQuiz" class="btn btn-success">Kirim Jawaban</button>
                                    </div>
                                 @endif
                                @endif
                            </div>
                            <div class="mt-5">
                                <button
                                    onclick="window.location.href='?selectedCourseContentId={{ $previousCourseContentId }}'"
                                    {{ $previousCourseContentId == '' ? 'disabled' : '' }} class="btn btn-secondary"><i
                                        class="fas fa-arrow-circle-left mr-2"></i>Sebelumnya</button>

                                <button id="nextCourseButton"
                                    onclick="window.location.href='?selectedCourseContentId={{ $nextCourseContentId }}'"
                                    {{ $nextCourseContentId == '' || $courseContent->is_completed == false ? 'disabled' : '' }}
                                    class="btn btn-primary float-right">Lanjut<i
                                        class="fas fa-arrow-circle-right ml-2"></i></button>
                            </div>
                        @else
                            <p>Belum ada Materi</p>
                        @endif
                    </div>
                    <!-- Kolom untuk Materi Selanjutnya -->
                    <div class="col-md-3 d-none d-lg-block materi-container px-3">

                        <!-- Progress bar -->
                        <div class="progress mt-3" style="height: 25px;"> <!-- Adjusted height here -->
                            <div class="progress-bar" role="progressbar"
                                style="width: {{ $completionPercentage }}%; height: 100%; background-color: #28a745; font-size: 1.2em;"
                                aria-valuenow="{{ $completionPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $completionPercentage }}% Tercapai
                            </div>
                        </div>

                        <div class="list-group mt-3">
                            @if (isset($courseContents))
                                @foreach ($courseContents as $courseContentSidebar)
                                    <button
                                        onclick='window.location.href="?selectedCourseContentId={{ $courseContentSidebar->content_id }}"'
                                        class="list-group-item list-group-item-action {{ $selectedCourseContentId == $courseContentSidebar->content_id ? 'list-group-item-primary' : '' }}"
                                        {{ $courseContentSidebar->is_completed == false ? ($selectedCourseContentId == $courseContentSidebar->content_id ? '' : 'disabled') : '' }}>
                                        {{ $courseContentSidebar->courseDetail->content_title }}
                                    </button>
                                @endforeach
                            @endif
                            <a href="/user/diskusi-kelas/{{ $course->course->id }}"
                                class="list-group-item list-group-item-action">Diskusi</a>
                        </div>

                        @if (!isset($userRate))
                            <div class="form-floating mt-2 mb-1">
                                <textarea class="form-control" id="descRate" placeholder="Review" rows="4"></textarea>
                                <label for="descRate">Ulasan</label>
                            </div>
                            <div class="rating">
                                <input type="radio" id="star5" name="rating" value="5">
                                <label for="star5" title="5 star"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1" title="1 stars"><i class="fas fa-star"></i></label>
                            </div>
                        @else
                            <div class="form-floating mt-2 mb-1">
                                <textarea class="form-control" placeholder="Review" rows="4" disabled>{{ $userRate->description }}</textarea>

                                <label for="descRate">Review</label>
                            </div>
                            <p style=" font-size: 1.5rem;">
                                <i class="fas fa-star" id="showStar"></i> {{ $userRate->rating }}
                            </p>
                        @endif

                    </div>

                </div>
            @else
                <!-- Konten alternatif jika $course tidak ada, jika perlu -->
                <p>Course tidak ditemukan.</p>
            @endif

        </section>
    </div>

    @if (!isset($userRate))
        <script>
            const ratingInputs = document.querySelectorAll('input[name="rating"]');

        ratingInputs.forEach((input) => {
            input.addEventListener('change', function() {
                const selectedValue = this.value;
                createOverlay("Proses...");


                    var descRate = $('#descRate').val()

                    var formData = new FormData();
                    formData.append('rating', selectedValue);
                    formData.append('description', descRate);
                    formData.append('studentId', '{{ $userCourse->id }}');



                    $.ajax({
                        url: '{{ route('kelas.rate') }}', // Direct API endpoint
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
                            Swal.fire({
                                icon: 'success',
                                title: response.data.title,
                                text: response.data.content
                            })
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            gOverlay.hide()
                            Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                        }
                    });

                });
            });
        </script>
    @endif


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if (isset($courseContent))
        @if ($courseContent->content_type == $quizType)
        @if(isset($courseContent->quiz->questions))

            <script>
                var questionOptionsSelected = []

                function answer(questionsIndex, indexOptions) {


                    const existingIndex = questionOptionsSelected.findIndex(item => item.index === questionsIndex);
                    if (existingIndex !== -1) {
                        questionOptionsSelected[existingIndex].Option = indexOptions;
                    } else {
                        questionOptionsSelected.push({
                            index: questionsIndex,
                            Option: indexOptions
                        });
                    }
                }

                $('#submitBtnQuiz').on('click', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    var answers = []

                    questionOptionsSelected.sort((a, b) => a.index - b.index);


                    questionOptionsSelected.forEach(item => {
                        answers.push(parseInt(item.Option));
                    });

                    if (questionOptionsSelected.length < '{{ $courseContent->quiz->questionTotal }}' || answers.length <=
                        0) {
                        Swal.fire('Oops!', 'Selesaikan Quiz terlebih dahulu', 'error');
                        return;
                    }



                    createOverlay("Proses...");
                    var formData = new FormData();
                    formData.append('answers', JSON.stringify(answers));
                    formData.append('studentId', '{{ $userCourse->id }}');


                    $.ajax({
                        url: '{{ route('quiz.answer', $courseContent->id) }}', // Direct API endpoint
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
                            if (response.dataServer.passed_status) {
                                // If the user passed the quiz
                                Swal.fire({
                                    icon: 'success',
                                    title: response.data.title,
                                    text: response.data.content
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('nextCourseButton').click();
                                    }
                                });
                            } else {
                                // If the user did not pass the quiz
                                Swal.fire({
                                    icon: 'error',
                                    title: response.data.title,
                                    text: response.data.content
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Optionally reload the page after confirmation
                                        window.location.reload();
                                    }
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            gOverlay.hide()
                            Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                        }
                    });
                })
            </script>
        @endif
        @endif
    @endif

@endsection

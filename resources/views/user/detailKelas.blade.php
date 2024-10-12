@extends('layout.userLayout')
@section('title', isset($courseContent) ? $courseContent->content_title : $title)

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
    </style>

    <div class="container-fluid">

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
                        @php
                            // Count total classes and completed ones
                            $totalClasses = count($courseContents);
                            $completedClasses = 0;
                            foreach ($courseContents as $courseContentSidebar) {
                                if ($courseContentSidebar->is_completed) {
                                    $completedClasses++;
                                }
                            }
                            $completionPercentage =
                                $totalClasses > 0 ? floor(($completedClasses / $totalClasses) * 100) : 0; // Use floor or round as needed

                        @endphp

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


                    </div>

                </div>
            @endif

        </section>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @if (isset($courseContent))
        @if ($courseContent->content_type == $quizType)
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




                    var formData = new FormData();
                    formData.append('answers', JSON.stringify(answers));
                    formData.append('studentId', '{{ $userCourse->id }}');
                    console.log(JSON.stringify({
                        answers
                    }));



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

                            console.error('Error:', error); // Log the error for debugging
                            console.error('Response Text:', xhr.responseText);
                            Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                        }
                    });
                })
            </script>
        @endif
    @endif

@endsection

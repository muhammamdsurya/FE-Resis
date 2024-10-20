@extends('layout.InstLayout')
@section('title', isset($courseContent) ? $courseContent->content_title : $title)

@section('content')

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
                                        <video controls poster="{{ $courseContent->video->thumbnail_image }}">
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
                                    @foreach ($courseContent->quiz->questions ?? [] as $quiz)
                                        <div class="card p-4 mb-2">
                                            <p>{{ $quiz->question }}</p>
                                            <form>
                                                @foreach ($quiz->options as $indexOption => $option)
                                                    <div>
                                                        <label>
                                                            <input type="radio" disabled
                                                                {{ $quiz->answer == $indexOption ? 'checked' : '' }}>
                                                            {{ $option }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </form>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="mt-5">
                                <button
                                    onclick="window.location.href='?selectedCourseContentId={{ $previousCourseContentId }}'"
                                    {{ $previousCourseContentId == '' ? 'disabled' : '' }} class="btn btn-secondary"><i
                                        class="fas fa-arrow-circle-left mr-2"></i>Sebelumnya</button>
                                <button onclick="window.location.href='?selectedCourseContentId={{ $nextCourseContentId }}'"
                                    {{ $nextCourseContentId == '' ? 'disabled' : '' }}
                                    class="btn btn-primary float-right">Lanjut<i
                                        class="fas fa-arrow-circle-right ml-2"></i></button>
                            </div>
                        @else
                            <p>Belum ada Materi</p>
                        @endif
                    </div>
                    <!-- Kolom untuk Materi Selanjutnya -->
                    <div class="col-md-3 d-none d-lg-block materi-container px-3">
                        <div class="list-group mt-3">
                            @if (isset($courseContents))
                                @foreach ($courseContents as $courseContentSidebar)
                                    <button
                                        onclick='window.location.href="?selectedCourseContentId={{ $courseContentSidebar->id }}" '
                                        class="list-group-item list-group-item-action {{ $selectedCourseContentId == $courseContentSidebar->id ? 'list-group-item-primary' : '' }}">{{ $courseContentSidebar->content_title }}</button>
                                @endforeach
                            @endif
                            <a href="/instructor/diskusi-kelas/{{ $course->course->id }}"
                                class="list-group-item list-group-item-action ">Diskusi</a>
                        </div>
                    </div>
                </div>
            @endif

        </section>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@endsection

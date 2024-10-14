@extends('layout.userLayout')
@section('title', $title)
@section('content')

    <style>
        .post,
        .comment {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .comment {
            margin-left: 20px;
            background-color: #ffffff;
        }

        .filter-btn {
            margin-bottom: 15px;
        }

        .comment-form,
        .post-form {
            margin-bottom: 15px;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <!-- Kolom Diskusi -->
            <div class="col-12">
                <div class="post-form">
                    <div class="d-flex">
                        <img src="{{ asset('assets/img/testimonials/profile.jpg') }}" width=50 height=50
                            class="rounded-circle mr-3" alt="User">
                        <div class="w-100">
                            <form action="">
                                <input type="text" class="form-control mb-2" placeholder="Judul postingan baru..."
                                    id="questionTitle" required>
                                <textarea rows="3" placeholder="Tulis postingan baru..." id="questionContent"></textarea>
                            </form>
                            <input type="file" class="form-control mb-3 mt-3" id="questionImageFile" name="video_file"
                                required>
                            <button id="btnForumSend" class="btn btn-primary mt-2">Kirim Postingan</button>
                        </div>
                    </div>
                </div>

                <!-- Daftar Postingan -->
                @if (isset($courseForums->data))
                    @foreach ($courseForums->data as $courseForum)
                        <div id="posts">
                            <div class="post" onclick="showReply('{{ $courseForum->course_forum_question->id }}')">
                                <div class="post">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div class="d-flex align-items-start">
                                            <img src="{{ asset('assets/img/testimonials/profile.jpg') }}" width=50 height=50
                                                class="rounded-circle me-3" alt="User">
                                            <div>
                                                <h5 class="mb-1">{{ $courseForum->student_name }}</h5>
                                                @if (isset($courseForum->course_forum_question->question_image))
                                                    <img src="{{ $courseForum->course_forum_question->question_image }}"
                                                        alt="" class="img-fluid rounded mb-2">
                                                @endif
                                                <h6 class="mb-1">
                                                    {{ $courseForum->course_forum_question->question_rtitle }}</h6>
                                                <p class="">{!! $courseForum->course_forum_question->question_content !!}</p>
                                                <small class="text-muted cursor-pointer">Lihat {{ $courseForum->reply_count }} Komentar</small>
                                            </div>
                                        </div>
                                        @if ($courseForum->course_forum_question->course_student_id == $userCourse->id)
                                            <button type="button"
                                                onclick="deleteForum('{{ $courseForum->course_forum_question->id }}')"
                                                class="btn btn-danger mt-2">Hapus <i class="fas fa-trash"></i></button>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <!-- Komentar (diungkapkan saat postingan diklik) -->
                            <div id="comments-{{ $courseForum->course_forum_question->id }}" style="display:none;">
                                @foreach ($courseForum->course_forum_reply as $reply)
                                    <div class="comment ml-5">
                                        <div class="d-flex align-items-start justify-content-between mb-3">
                                            <div class="d-flex align-items-start w-100">
                                                <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}"
                                                    width=50 height=50 class="rounded-circle me-3" alt="User">
                                                <div class="w-100">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0">{{ $reply->name }}</h6>
                                                        @if ($reply->course_forum_question_reply->person_id == $id)
                                                            <button type="button"
                                                                onclick="deleteForumReply('{{ $courseForum->course_forum_question->id }}', '{{ $reply->course_forum_question_reply->id }}')"
                                                                class="btn btn-danger btn-sm ms-auto">Hapus <i
                                                                    class="fas fa-trash"></i></button>
                                                        @endif
                                                    </div>
                                                    @if (isset($reply->course_forum_question_reply->reply_image))
                                                        <img src="{{ $reply->course_forum_question_reply->reply_image }}"
                                                            alt="" class="img-fluid mt-2">
                                                    @endif
                                                    <p class="mt-2">{!! $reply->course_forum_question_reply->reply !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Tambahkan lebih banyak komentar di sini -->

                    <!-- Formulir Komentar -->
                    <div class="comment-form">
                        <div class="d-flex">
                            <img src="{{ asset ('assets/img/testimonials/testimonials-1.jpg')}}" width=50 height=50 class="rounded-circle mr-3" alt="User">
                            <div class="w-100">
                                <input type="file" class="form-control mb-3" id="replyImageFile-{{$courseForum->course_forum_question->id}}"
                                name="video_file" required>
                                <textarea class="replyForum" rows="3" placeholder="Tulis komentar..." id="reply-{{$courseForum->course_forum_question->id}}"></textarea>
                                <button onclick="send('{{$courseForum->course_forum_question->id}}')" class="btn btn-primary mt-2">Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Button -->
                            @if ($courseForums->pagination->page > 1)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="/user/diskusi-kelas/{{$courseId}}?page={{$courseForums->pagination->page - 1}}">Previous</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                            @endif

                            <!-- Page Numbers -->
                            @for ($i = 1; $i <= $courseForums->pagination->total_page; $i++)
                                <li class="page-item {{ $courseForums->pagination->page === $i ? 'active' : '' }}">
                                    <a class="page-link" href="/user/diskusi-kelas/{{$courseId}}?page={{$i}}">{{ $i }}</a>
                                </li>
                            @endfor

                            <!-- Next Button -->
                            @if ($courseForums->pagination->page < $courseForums->pagination->total_page)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="/user/diskusi-kelas/{{$courseId}}?page={{$courseForums->pagination->page + 1}}">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link">Next</a>
                                </li>
                            @endif
                        </ul>
                    </nav>
        </div>

    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SummerNote -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

    <script>
        $(document).ready(function() {
            $('#questionContent').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline']], // Text styles
                    ['color', ['color']], // Text color
                    ['para', ['ul', 'ol']], // Lists
                    ['misc', ['undo', 'redo']] // Miscellaneous
                ],
                height: 300, // Set editor height
                placeholder: 'Type your text here...' // Placeholder text
            });
            $('.replyForum').summernote({
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline']], // Text styles
                    ['color', ['color']], // Text color
                    ['para', ['ul', 'ol']], // Lists
                    ['misc', ['undo', 'redo']] // Miscellaneous
                ],
                height: 300, // Set editor height
                placeholder: 'Type your text here...' // Placeholder text
            });
        });


        function send(id) {
            const reply = $('#reply-' + id).val()



    var formData = new FormData();
    formData.append('reply', reply);
    formData.append('forumId', id);

    createOverlay("Proses...");
        $.ajax({

                url: '{{ route('diskusi.post.reply', $courseId) }}', // Direct API endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: async function(response) {
                    const replyImg = $('#replyImageFile-' + id)[0].files[0];

                    if (replyImg) {
                        var formData = new FormData();
                        formData.append('forumId', id);
                        formData.append('replyImg', replyImg);
                        formData.append('replyId', response.data.course_forum_question_reply.id);
                        await $.ajax({
                            url: '{{ route('diskusi.post.reply.img', $courseId) }}', // Direct API endpoint
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {},
                            error: function(xhr, status, error) {
                                Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                            }
                        });
                    }

                    gOverlay.hide()
                    window.location.reload()
                    Swal.fire('Berhasil', 'Berhasil membalas diskusi', 'success');

                },
                error: function(xhr, status, error) {
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
            });

        }


        function deleteForum(forumId) {
            var formData = new FormData();
            formData.append('forumId', forumId);
            createOverlay("Proses...");
            $.ajax({
                        url: '{{ route("diskusi.delete", $courseId) }}', // Direct API endpoint
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
                            Swal.fire('Berhasil', 'Berhasil menghapus diskusi', 'success');
                        },
                        error: function(xhr, status, error) {
                        gOverlay.hide()
                            Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                        }
                    });
}

        function showReply(id) {
            const comments = document.getElementById('comments-' + id);
            comments.style.display = comments.style.display === 'none' ? 'block' : 'none';

        }


        $('#btnForumSend').on('click', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const questionTitle = $('#questionTitle').val()
            const questionContent = $('#questionContent').val()


            var data = {
                questionTitle: questionTitle,
                questionContent: questionContent,
            }


        createOverlay("Proses...");
        $.ajax({

            url: '{{ route("diskusi.post", $courseId) }}', // Direct API endpoint
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            data: JSON.stringify(data),
            success: async function(response) {
                const img = $('#questionImageFile')[0].files[0]
                if (img) {
                    var formData = new FormData();
                    formData.append('img', img);
                    formData.append('forumId', response.data.course_forum_question.id);
                    await $.ajax({
                        url: '{{ route("diskusi.post.img", $courseId) }}', // Direct API endpoint
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                        }
                    });
                }

                gOverlay.hide()
                window.location.reload()
                Swal.fire('Berhasil', 'Berhasil membuat diskusi', 'success');

                },
                error: function(xhr, status, error) {
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
            });

        })

        function deleteForumReply(forumId, replyId) {
            var formData = new FormData();
            formData.append('forumId', forumId);
            formData.append('replyId', replyId);
            createOverlay("Proses...");
            $.ajax({
                        url: '{{ route("diskusi.reply.delete", $courseId) }}', // Direct API endpoint
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
                            Swal.fire('Berhasil', 'Berhasil menghapus balasan diskusi', 'success');
                            window.location.reload()
                        },
                        error: function(xhr, status, error) {
                            gOverlay.hide()
                            Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                        }
                    });
}
</script>
@endsection

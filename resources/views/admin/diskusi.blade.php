@extends('layout.adminLayout')
@section('title', $title)


@section('content')

    <style>
        .post,
        .comment {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
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
            <div class="col-12 col-md-9">


                <!-- Daftar Postingan -->
                @if (isset($courseForums->data))
                    @foreach ($courseForums->data as $courseForum)
                        <div id="posts">
                            <div class="post" onclick="showReply('{{ $courseForum->course_forum_question->id }}')">
                                <div class="d-flex">
                                    <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" width=50 height=50
                                        class="rounded-circle mr-3" alt="User">
                                    <div>
                                        <h5 class="mb-1">{{ $courseForum->student_name }}</h5>
                                        @if (isset($courseForum->course_forum_question->question_image))
                                            <img src="{{ $courseForum->course_forum_question->question_image }}"
                                                alt="">
                                        @endif
                                        <h6 class="mb-1">{{ $courseForum->course_forum_question->question_rtitle }}</h6>
                                        <p>{!! $courseForum->course_forum_question->question_content !!}</p>
                                        <small>{{ $courseForum->reply_count }} Komentar</small>
                                        <div>
                                            <button type="button"
                                                onclick="deleteForum('{{ $courseForum->course_forum_question->id }}')"
                                                class="btn btn-danger mt-2">Hapus <i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Komentar (diungkapkan saat postingan diklik) -->
                            <div id="comments-{{ $courseForum->course_forum_question->id }}" style="display:none;">
                                @foreach ($courseForum->course_forum_reply as $reply)
                                    <div class="comment ml-5">
                                        <div class="d-flex">
                                            <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" width=50
                                                height=50 class="rounded-circle mr-3" alt="User">
                                            <div>
                                                <h6>{{ $reply->name }}</h6>
                                                @if (isset($reply->course_forum_question_reply->reply_image))
                                                    <img src="{{ $reply->course_forum_question_reply->reply_image }}"
                                                        alt="">
                                                @endif
                                                <p>{!! $reply->course_forum_question_reply->reply !!}</p>

                                                <div>
                                                    <button type="button"
                                                        onclick="deleteForumReply('{{ $courseForum->course_forum_question->id }}', '{{ $reply->course_forum_question_reply->id }}')"
                                                        class="btn btn-danger mt-2">Hapus <i
                                                            class="fas fa-trash"></i></button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                                <!-- Tambahkan lebih banyak komentar di sini -->

                                <!-- Formulir Komentar -->
                                <div class="comment-form">
                                    <div class="d-flex">
                                        <img src="{{ asset('assets/img/testimonials/testimonials-1.jpg') }}" width=50
                                            height=50 class="rounded-circle mr-3" alt="User">
                                        <div class="w-100">
                                            <input type="file" class="form-control mb-3"
                                                id="replyImageFile-{{ $courseForum->course_forum_question->id }}"
                                                name="video_file" required>
                                            <textarea class="replyForum" rows="3" placeholder="Tulis komentar..."
                                                id="reply-{{ $courseForum->course_forum_question->id }}"></textarea>
                                            <button onclick="send('{{ $courseForum->course_forum_question->id }}')"
                                                class="btn btn-primary mt-2">Kirim</button>
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
                                    href="/admin/diskusi-kelas/{{ $courseId }}?page={{ $courseForums->pagination->page - 1 }}">Previous</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link">Previous</a>
                            </li>
                        @endif

                        <!-- Page Numbers -->
                        @for ($i = 1; $i <= $courseForums->pagination->total_page; $i++)
                            <li class="page-item {{ $courseForums->pagination->page === $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="/admin/diskusi-kelas/{{ $courseId }}?page={{ $i }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Next Button -->
                        @if ($courseForums->pagination->page < $courseForums->pagination->total_page)
                            <li class="page-item">
                                <a class="page-link"
                                    href="/admin/diskusi-kelas/{{ $courseId }}?page={{ $courseForums->pagination->page + 1 }}">Next</a>
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

                url: '{{ route('admin.diskusi.post.reply', $courseId) }}', // Direct API endpoint
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
                            url: '{{ route('admin.diskusi.post.reply.img', $courseId) }}', // Direct API endpoint
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
                    Swal.fire('Berhasil', 'Berhasil membalas diskusi', 'success');
                    setTimeout(() => {
                        window.location.reload()
                    }, 1500); // Delay 1.5 detik sebelum redirect

                },
                error: function(xhr, status, error) {
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
            });

        }

        function showReply(id) {
            const comments = document.getElementById('comments-' + id);
            comments.style.display = comments.style.display === 'none' ? 'block' : 'none';

        }

        function deleteForum(forumId) {
            var formData = new FormData();
            formData.append('forumId', forumId);
            createOverlay("Proses...");
            $.ajax({
                url: '{{ route('admin.diskusi.delete', $courseId) }}', // Direct API endpoint
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
                    setTimeout(() => {
                        window.location.reload()
                    }, 1500); // Delay 1.5 detik sebelum redirect

                },
                error: function(xhr, status, error) {
                    gOverlay.hide()
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
            });
        }

        function deleteForumReply(forumId, replyId) {
            var formData = new FormData();
            formData.append('forumId', forumId);
            formData.append('replyId', replyId);
            createOverlay("Proses...");
            $.ajax({
                url: '{{ route('admin.diskusi.reply.delete', $courseId) }}', // Direct API endpoint
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
                    setTimeout(() => {
                        window.location.reload()
                    }, 1500); // Delay 1.5 detik sebelum redirect
                },
                error: function(xhr, status, error) {
                    gOverlay.hide()
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
            });
        }
    </script>
@endsection

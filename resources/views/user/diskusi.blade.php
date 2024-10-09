@extends('layout.userLayout')
@section('title', $title)

@section('filter')
<!-- Filter Dropdown -->
<div class="filter-dropdown d-md-inline-block ms-md-3">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            Filter
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#">Semua</a></li>
            <li><a class="dropdown-item" href="#">Terbaru</a></li>
            <li><a class="dropdown-item" href="#">Diskusi Saya</a></li>
        </ul>
    </div>
</div>
@endsection

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
            <div class="post-form">
                <div class="d-flex">
                    <img src="{{ asset ('assets/img/testimonials/testimonials-1.jpg')}}" width=50 height=50 class="rounded-circle mr-3" alt="User">
                    <div class="w-100">
                        <form action="">
                            <input type="text" class="form-control mb-2" placeholder="Judul postingan baru..." id="questionTitle" required>
                            <textarea rows="3" placeholder="Tulis postingan baru..." id="questionContent"></textarea>
                        </form>
                        <button id="btnForumSend" class="btn btn-primary mt-2">Kirim Postingan</button>
                    </div>
                </div>
            </div>

            <!-- Daftar Postingan -->
             @if(isset($courseForums->data))
             @foreach($courseForums->data as $courseForum)
            <div id="posts">
                <div class="post" onclick="showReply('{{$courseForum->course_forum_question->id}}')">
                    <div class="d-flex">
                        <img src="{{ asset ('assets/img/testimonials/testimonials-1.jpg')}}" width=50 height=50 class="rounded-circle mr-3" alt="User">
                        <div>
                            <h5 class="mb-1">{{$courseForum->student_name}}</h5>
                            <h6 class="mb-1">{{$courseForum->course_forum_question->question_rtitle}}</h6>
                            <p>{!!$courseForum->course_forum_question->question_content!!}</p>
                            <small>10 Komentar</small>
                        </div>
                    </div>
                </div>

                <!-- Komentar (diungkapkan saat postingan diklik) -->
                <div id="comments-{{$courseForum->course_forum_question->id}}" style="display:none;">
                    <div class="comment ml-5">
                        <div class="d-flex">
                            <img src="{{ asset ('assets/img/testimonials/testimonials-1.jpg')}}" width=50 height=50 class="rounded-circle mr-3" alt="User">
                            <div>
                                <h6>{{$courseForum->course_forum_question->question_rtitle}}</h6>
                                <p>Ini adalah komentar.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Tambahkan lebih banyak komentar di sini -->

                    <!-- Formulir Komentar -->
                    <div class="comment-form">
                        <div class="d-flex">
                            <img src="{{ asset ('assets/img/testimonials/testimonials-1.jpg')}}" width=50 height=50 class="rounded-circle mr-3" alt="User">
                            <div class="w-100">
                                <textarea class="replyForum" rows="3" placeholder="Tulis komentar..." id="reply-{{$courseForum->course_forum_question->id}}"></textarea>
                                <button onclick="send('{{$courseForum->course_forum_question->id}}')" class="btn btn-primary mt-2">Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
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


function send(id){
    const reply = $('#reply-'+id).val()
    var data ={
            reply: reply,
            forumId: id,
        }

        $.ajax({

                url: '{{ route("diskusi.post.reply", $courseId) }}', // Direct API endpoint
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                data: JSON.stringify(data),
                success: function(response) {
                    window.location.reload()
                    Swal.fire('Berhasil', 'Berhasil membuat diskusi', 'success');

                },
                error: function(xhr, status, error) {
                    Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                }
                });

}

function showReply(id){
    const comments = document.getElementById('comments-'+id);
    comments.style.display = comments.style.display === 'none' ? 'block' : 'none';

}


    $('#btnForumSend').on('click', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const questionTitle = $('#questionTitle').val()
        const questionContent = $('#questionContent').val()


        var data ={
            questionTitle: questionTitle,
            questionContent: questionContent,
        }



        $.ajax({

            url: '{{ route("diskusi.post", $courseId) }}', // Direct API endpoint
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            data: JSON.stringify(data),
            success: function(response) {
                window.location.reload()
                Swal.fire('Berhasil', 'Berhasil membuat diskusi', 'success');

            },
            error: function(xhr, status, error) {
                Swal.fire('Oops!', xhr.responseJSON.message, 'error');
            }
        });

    })
</script>
@endsection

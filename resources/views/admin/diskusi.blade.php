@extends('layout.adminLayout')
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


            <!-- Daftar Postingan -->
             @if(isset($courseForums->data))
             @foreach($courseForums->data as $courseForum)
            <div id="posts">
                <div class="post" onclick="showReply('{{$courseForum->course_forum_question->id}}')">
                    <div class="d-flex">
                        <img src="{{ asset ('assets/img/testimonials/testimonials-1.jpg')}}" width=50 height=50 class="rounded-circle mr-3" alt="User">
                        <div>
                            <h5 class="mb-1">{{$courseForum->student_name}}</h5>
                            @if(isset($courseForum->course_forum_question->question_image))
                            <img src="{{$courseForum->course_forum_question->question_image}}" alt="">
                            @endif
                            <h6 class="mb-1">{{$courseForum->course_forum_question->question_rtitle}}</h6>
                            <p>{!!$courseForum->course_forum_question->question_content!!}</p>
                            <small>{{$courseForum->reply_count}} Komentar</small>
                            <div>
                                   <button type="button" onclick="deleteForum('{{$courseForum->course_forum_question->id}}')" class="btn btn-danger mt-2">Hapus <i class="fas fa-trash"></i></button>
                                   </div>
                        </div>
                    </div>
                </div>

                <!-- Komentar (diungkapkan saat postingan diklik) -->
                <div id="comments-{{$courseForum->course_forum_question->id}}" style="display:none;">
                    @foreach($courseForum->course_forum_reply as $reply)
                    <div class="comment ml-5">
                        <div class="d-flex">
                            <img src="{{ asset ('assets/img/testimonials/testimonials-1.jpg')}}" width=50 height=50 class="rounded-circle mr-3" alt="User">
                            <div>
                                <h6>{{$reply->name}}</h6>
                                <p>{!! $reply->course_forum_question_reply->reply !!}</p>

                                <div>
                                   <button type="button" onclick="deleteForumReply('{{$courseForum->course_forum_question->id}}', '{{$reply->course_forum_question_reply->id}}')" class="btn btn-danger mt-2">Hapus <i class="fas fa-trash"></i></button>
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
    

    
    var formData = new FormData();
    formData.append('reply', reply);
    formData.append('forumId', id);
   

        $.ajax({

                url: '{{ route("admin.diskusi.post.reply", $courseId) }}', // Direct API endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success:  async function(response) {
                    const replyImg = $('#replyImageFile-'+id)[0].files[0];
                    
                    if (replyImg) {
                        var formData = new FormData();
                        formData.append('forumId', id);
                        formData.append('replyImg', replyImg);
                        formData.append('replyId', response.data.course_forum_question_reply.id);
                        await $.ajax({
                            url: '{{ route("admin.diskusi.post.reply.img", $courseId) }}', // Direct API endpoint
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
                                console.log( xhr.responseJSON.message);
                                console.log( xhr.responseJSON.error);
                                
                                Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                            }
                        });
                    }
                
                    console.log(response);
                    
                    window.location.reload()
                    Swal.fire('Berhasil', 'Berhasil membalas diskusi', 'success');

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

function deleteForum(forumId){
            var formData = new FormData();
            formData.append('forumId', forumId);
            $.ajax({
                        url: '{{ route("admin.diskusi.delete", $courseId) }}', // Direct API endpoint
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire('Berhasil', 'Berhasil menghapus diskusi', 'success');
                        },
                        error: function(xhr, status, error) {
                            console.log( xhr.responseJSON.message);
                            console.log( xhr.responseJSON.error);
                            console.log(xhr);
                            console.log( `ERROR : ${error}`);
                            
                            Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                        }
                    });
}
function deleteForumReply(forumId, replyId){
            var formData = new FormData();
            formData.append('forumId', forumId);
            formData.append('replyId', replyId);
            $.ajax({
                        url: '{{ route("admin.diskusi.reply.delete", $courseId) }}', // Direct API endpoint
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire('Berhasil', 'Berhasil menghapus balasan diskusi', 'success');
                        },
                        error: function(xhr, status, error) {
                            console.log( xhr.responseJSON.message);
                            console.log( xhr.responseJSON.error);
                            console.log(xhr);
                            console.log( `ERROR : ${error}`);
                            
                            Swal.fire('Oops!', xhr.responseJSON.message, 'error');
                        }
                    });
}



  
</script>
@endsection

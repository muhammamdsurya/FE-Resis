@extends('layout.userLayout')
@section('title', $title)

@section('content')


<div class="container-fluid">

<section class="col-12 mt-2 pb-5">

@if(isset($course))
    <div class="row">
        <!-- Kolom untuk Video dan Penjelasan -->
        <div class="col-md-9">
            @if(isset($courseContent))
            <div class="mt-3">
             
                    @if($courseContent->content_type == $videoType)
                    <div class="ratio ratio-16x9 mb-3">
                                        <video controls poster="{{$courseContent->video->thumbnail_image}}">
                                            <source src="{{$courseContent->video->video_file}}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                   <p>{!! $courseContent->content_description !!}</p>
                   @elseif($courseContent->content_type == $addSrcType)
                   <div class="ratio ratio-16x9 mb-3">
                                        <iframe src="{{$courseContent->src->file}}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen ></iframe>
                                    </div>
                    @elseif($courseContent->content_type == $quizType)
                            @foreach($courseContent->quiz->questions as $quiz)
                                <div class="card p-4 mb-2">
                                    <p>{{$quiz->question}}</p>
                                    <form>
                                        @foreach($quiz->Options as  $option)
                                            <div>
                                                <label>
                                                    <input type="radio" name="option-{{$quiz->index}}" value="{{ $option->index }}" onclick="answer('{{ $quiz->index }}', '{{ $option->index }}')">
                                                    {{$option->name}}
                                                </label>
                                            </div>
                                        @endforeach
                                        </form>
                                </div>
                            @endforeach                   
                            <button id="submitBtnQuiz" class="btn btn-primary float-right">Submit</button>
                   @endif
            </div>
            <div class="mt-5">
                <button onclick="window.location.href='?selectedCourseContentId={{$previousCourseContentId}}'" {{$previousCourseContentId == ''? 'disabled':''}} class="btn btn-secondary"><i class="fas fa-arrow-circle-left mr-2"></i>Sebelumnya</button>
         
                <button  onclick="window.location.href='?selectedCourseContentId={{$nextCourseContentId}}'" {{$nextCourseContentId == ''  || $courseContent->is_completed == false ? 'disabled':''}} class="btn btn-primary float-right" >Lanjut<i
                            class="fas fa-arrow-circle-right ml-2"></i></button>
            </div>
            @else
            <p>Belum ada Materi</p>
            @endif
        </div>
        <!-- Kolom untuk Materi Selanjutnya -->
        <div class="col-md-3 d-none d-lg-block materi-container px-3">
            <div class="list-group mt-3">
                @if(isset($courseContents))
                @foreach($courseContents as $courseContentSidebar)
                <button onclick='window.location.href="?selectedCourseContentId={{$courseContentSidebar->content_id}}" ' class="list-group-item list-group-item-action {{$selectedCourseContentId == $courseContentSidebar->content_id? 'list-group-item-primary' : ''}}" {{$courseContentSidebar->is_completed == false ? $selectedCourseContentId == $courseContentSidebar->content_id? '' : 'disabled' : ''}} >{{$courseContentSidebar->courseDetail->content_title}}</button>
                @endforeach
                @endif
                <a href="/user/diskusi-kelas/{{$course->course->id}}" class="list-group-item list-group-item-action ">Diskusi</a>
            </div>
        </div>
    </div>
    @endif

</section>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@if(isset($courseContent))
@if($courseContent->content_type == $quizType)
<script>
var questionOptionsSelected = []

function answer(questionsIndex, indexOptions){
  
    
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

    if(questionOptionsSelected.length < '{{$courseContent->quiz->questionTotal}}' || answers.length <= 0){
        Swal.fire('Oops!',  'Selesaikan Quiz terlebih dahulu', 'error');
        return;
    }


    

    var formData = new FormData();
    formData.append('answers', JSON.stringify(answers));
    formData.append('studentId',  '{{ $userCourse->id }}');
    console.log(JSON.stringify({answers}));
    


    $.ajax({
                url: '{{ route("quiz.answer", $courseContent->id) }}', // Direct API endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                data:  formData,
                processData: false, 
                contentType: false,
                success: function(response) {
                    
                    Swal.fire(response.data.title,response.data.content, 'success');
                    window.location.reload()
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

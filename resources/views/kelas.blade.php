@extends('layout.layout')

@section('content')
    <section class="section">
        <div class="container mt-5 section-title" data-aos="fade-up">
            <p>Kelas Kami<br></p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-4">
            @foreach($courses->data as $course)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card" style="width: 100%;">
                        <img src="assets/img/values-1.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="header-card d-flex justify-content-between">
                                <p class="mr-auto fs-6"><i class="bi bi-star-fill text-warning me-1"></i>4.9</p>
                                <p class="ml-auto fs-6">Jenjang : {{$course->course_category->name}}</p>
                            </div>

                            <h5 class="card-title">{{$course->course->name}}</h5>
                            <h5 class="card-title">Rp {{$course->course->price}}</h5>
                            <p class="card-text"> {{$course->course->description}}
                            </p>
                            <a href="/detail-kelas/{{$course->course->id}}" class="btn btn-success">Belajar Sekarang</a>
                        </div>
                    </div>
                </div>
        @endforeach
           

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li id="btnIncrementPagination" class="page-item"><button class="page-link" >Previous</button></li>
                @for ($i = 1; $i <= $courses->pagination->total_page; $i++)
                <li class="page-item"><button class="page-link" >{{$i}}</button></li>
                @endfor
                <li id="btnDecrementPagination" class="page-item"><button class="page-link" >Next</button></li>
            </ul>
        </nav>
        
             
            </div>
        </div>
@endsection

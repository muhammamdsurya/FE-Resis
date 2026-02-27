@extends('layout.userLayout')

@section('filter')

<!-- Filter Dropdown -->
<div class="filter-dropdown d-lg-none d-sm-block ms-md-3">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
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


<div class="container-fluid">
    <div class="progress d-lg-none d-sm-block" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar bg-success" style="width: 25%">25%</div>
      </div>
    <section class="col-12 mt-2 pb-5">

        <div class="row">
            <!-- Kolom untuk Video dan Penjelasan -->
            <div class="col-md-9">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/CpSoqTvSAF0?si=MyY3y8RuEgSAORQk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="mt-3">
                    <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas voluptatum molestiae obcaecati! Laudantium ipsum ea perferendis molestiae praesentium voluptates. Error consectetur voluptas cupiditate doloribus maiores, sapiente sequi dignissimos dolor voluptatem, illum voluptates, quos laboriosam nobis neque aut debitis? Cum, exercitationem! Voluptas autem voluptates esse, a aliquid facilis, doloremque pariatur consectetur eos dolore illum earum temporibus sapiente nobis velit accusamus quam iusto molestias asperiores quis! Adipisci magni soluta illo? Veniam delectus assumenda qui sed possimus laboriosam libero, ex ipsa itaque esse officiis natus placeat odio tempore numquam voluptate commodi iusto vitae enim aperiam? Necessitatibus, iusto expedita reprehenderit ratione qui error asperiores.</p>
                </div>
                <div class="mt-5">
                    <button class="btn btn-secondary"><i class="fas fa-arrow-circle-left mr-2"></i>Sebelumnya</button>
                    <button class="btn btn-primary float-right">Lanjut<i class="fas fa-arrow-circle-right ml-2"></i></button>
                </div>
            </div>
            <!-- Kolom untuk Materi Selanjutnya -->
            <div class="col-md-3 d-none d-lg-block materi-container px-3">
                <h4>Progress Belajar</h4>
                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-success" style="width: 25%">25%</div>
                  </div>
                  <div class="list-group mt-3">
                    <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Pendahuluan</a>

                    <a href="#" class="list-group-item list-group-item-action ">Materi 1</a>
                    <a href="#" class="list-group-item list-group-item-action ">Materi 2</a>
                    <a href="#" class="list-group-item list-group-item-action ">Materi 3</a>
                    <a href="#" class="list-group-item list-group-item-action ">Materi 4</a>
                    <a href="/user/diskusi" class="list-group-item list-group-item-action ">Diskusi</a>
                  </div>
            </div>
        </div>

    </section>
</div>
@endsection

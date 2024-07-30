@extends('layout.userLayout')
@section('title', $title)

@section('content')
    <div class="container-fluid mt-2">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>8</h3>

                        <p>Jumlah Kelas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>10</h3>

                        <p>Jumlah Admin</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>

                        <p>Jumlah Siswa</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-12">
                <div class="card-header mb-3">
                    <h3 class="card-title">
                        <i class="fas fa-book-reader mr-1"></i>
                        Sedang Dipelajari
                    </h3>
                </div><!-- /.card-header -->
                <div class="row g-4">
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card" style="width: 100%;">
                            <img src="{{asset ('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-success" style="width: 25%">25%</div>
                                  </div>

                                <h5 class="card-title my-2">Praktikum Laboratorium Dasar</h5>
                                <a href="#" class="fs-6">Lanjutkan <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card" style="width: 100%;">
                            <img src="{{asset ('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-success" style="width: 25%">25%</div>
                                  </div>

                                <h5 class="card-title my-2">Praktikum Laboratorium Dasar</h5>
                                <a href="#" class="fs-6">Lanjutkan <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card" style="width: 100%;">
                            <img src="{{asset ('assets/img/values-1.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-success" style="width: 25%">25%</div>
                                  </div>

                                <h5 class="card-title my-2">Praktikum Laboratorium Dasar</h5>
                                <a href="#" class="fs-6">Lanjutkan <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
@endsection



@extends('layout.userLayout')
@section('title', $title)

@section('content')
    <div class="container">

            <div class="row ">
                <div class="col-lg-5 col-md-6 mx-auto">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            value="{{ $full_name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email </label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            value="{{ $email }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tanggal lahir </label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            value="{{ $birth }}" disabled>
                    </div>


                </div>
                <div class="col-lg-5 col-md-6 mx-auto">


                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label"> Jenjang </label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            value="{{ $study_level }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label"> Sekolah </label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            value="{{ $institution }}" disabled>
                    </div>

                </div>

                <div class="col-lg-5 ml-5">
                    <button type="button" class="btn btn-success px-3 mb-5 mt-3" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">Edit</button>
                <!--    <a href="/logout" class="btn btn-danger px-3 mb-5 mt-3 btn-logout">Logout</a> -->
                <!-- Logout Button -->
                    <button type="submit" class="btn btn-danger px-3 mb-5 mt-3 btn-logout">Logout</button>
                </div>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="">
                        <div class="row ">
                            <div class="col-lg-5 col-md-6 mx-auto">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $full_name }}">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email </label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $email }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Tanggal lahir </label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $birth }}">
                                </div>

                            </div>
                            <div class="col-lg-5 col-md-6 mx-auto">

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Jenjang</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $study_level }}" >
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Sekolah</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" value="{{ $institution }}" >
                                </div>


                            </div>

                            <a href="/reset-password" class="small ml-4">Reset Password</p>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
    </div>
@endsection

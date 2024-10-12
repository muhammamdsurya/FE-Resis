@extends('layout.adminLayout')


@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-lg-6 col-md-8">
                <!-- Card Layout -->
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h5>Lengkapi informasi Terlebih Dahulu</h5>
                    </div>
                    <div class="card-body">
                        <!-- Form Start -->
                        <form action="{{ route('complete.post.pengajar') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $id }}" name="id">

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="education" placeholder="Nama lengkap"
                                    name="education">
                                <label for="name">Edukasi</label>
                                <p class="small" id="nameError" style="color: red; display: none;">Masukan Edukasi
                                </p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="experience" placeholder="Nama lengkap"
                                    name="experience">
                                <label for="name">Pengalaman</label>
                                <p class="small" id="nameError" style="color: red; display: none;">Masukan pengalaman</p>
                            </div>
                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-4">Selesai</button>
                            </div>
                        </form>
                        <!-- Form End -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endsection

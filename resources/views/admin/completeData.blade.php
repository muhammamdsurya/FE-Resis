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
                        <form action="{{ route('complete.post.admin') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $id }}" name="id">
                            <!-- Sekolah Dropdown -->
                            <div class="mb-3">
                                <label for="institution" class="form-label">Tipe </label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Pilih tipe admin</option>
                                    <option value="super">SUPER</option>
                                    <option value="regular">REGULER</option>
                                </select>
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

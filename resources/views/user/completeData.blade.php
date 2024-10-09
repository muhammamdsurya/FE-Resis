@extends('layout.userLayout')


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
                        <form action="{{ route('complete.post') }}" method="POST">
                            @csrf

                            <!-- Tanggal Lahir -->
                            <div class="mb-3">
                                <label for="birth" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="birth" name="birth" required>
                            </div>

                            <!-- Pendidikan -->
                            <div class="mb-3">
                                <label for="study_level" class="form-label">Sekolah</label>
                                <input type="text" class="form-control" id="institution" name="institution" required>
                            </div>

                            <!-- Sekolah Dropdown -->
                            <div class="mb-3">
                                <label for="institution" class="form-label">Pendidikan</label>
                                <select class="form-control" id="study_level" name="study_level" required>
                                    <option value="">Pilih tingkat pendidikan</option>
                                    <option value="sd">SD</option>
                                    <option value="smp">SMP</option>
                                    <option value="sma">SMA</option>
                                    <option value="universitas">Universitas</option>
                                    <option value="umum">Umum</option>
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
            @if (session('message'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('message') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

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

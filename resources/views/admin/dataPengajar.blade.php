@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <style>
        .image-container,
        .image-container-add {
            position: relative;
            display: inline-block;

        }

        .image-container img,
        .image-container-add img {
            width: 100%;
            height: 50% !important;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5) !important;
            /* Warna hitam transparan */
            color: white !important;
            opacity: 0;
            /* Awalnya disembunyikan */
            transition: opacity 0.3s ease;
            /* Animasi saat hover */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            border-radius: 10px;
        }

        .image-container:hover .overlay,
        .image-container-add:hover .overlay {
            opacity: 1;
            cursor: pointer;
            /* Muncul saat di-hover */
        }
    </style>

    <div class="card">
        <div class="card-body">
            @if ($type === 'super')
                <!-- Tombol untuk menampilkan modal -->
                <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#registrationModal">
                    <i class="fas fa-plus d-inline me-1"></i> <!-- Ikon untuk mobile -->
                    <span class="d-lg-inline">Tambah Instruktur</span> <!-- Teks untuk desktop -->
                </a>
            @endif

            <!-- Modal untuk Registrasi -->
            <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="registrationModalLabel">Tambah Instruktur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="registrationForm" method="POST" action="{{ route('admin.dataInstructor.regis') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <!-- Image Section -->
                                <div class="image-container-add text-center mb-4 cursor-pointer">
                                    <img src="{{ asset('assets/img/testimonials/profile.jpg') }}" alt="upload gambar"
                                        class="img-fluid rounded shadow image-preview cursor-pointer" id="imagePreview">
                                    <div class="overlay">Ganti Gambar</div>
                                </div>
                                <input type="file" id="imageUpload" name="image" style="display: none; cursor-pointer"
                                    accept="image/*">

                                <!-- Name input -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="full_name" placeholder="Nama lengkap"
                                        name="full_name" required>
                                    <label for="name">Nama Lengkap</label>
                                    <p class="small" id="nameError" style="color: red; display: none;">Masukan nama
                                        lengkap</p>
                                </div>

                                <!-- Email input -->
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" placeholder="email"
                                        name="email" required>
                                    <label for="email">Email</label>
                                    <p class="small" id="emailError" style="color: red; display: none;">Gunakan alamat
                                        email aktif anda</p>
                                </div>

                                <!-- Password input -->
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                        name="password" required>
                                    <label for="password">Password</label>
                                    <p class="small">Gunakan minimal 8 karakter dengan kombinasi huruf, angka &
                                        karakter</p>
                                    <p id="passwordError" class="small text-danger" style="display: none;">Password
                                        harus mengandung minimal 8 karakter, 1 huruf besar, 1 angka & 1 Karakter</p>
                                </div>

                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password_confirm"
                                        placeholder="Konfirmasi Password" name="password_confirm" required>
                                    <label for="confirmPassword">Konfirmasi Password</label>
                                    <p id="passwordMismatch" class="small text-danger" style="display: none;">Password
                                        tidak cocok</p>
                                </div>

                                <div class="text-center text-lg-start mt-4 pt-2">
                                    <button type="submit" class="btn btn-primary w-100"
                                        id="submitRegistration">Registrasi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.dataInstructor.download') }}" class="btn btn-primary mb-3">
                <i class="fas fa-download d-inline me-1 "></i> <!-- Ikon untuk mobile -->
                <span class="d-lg-inline">Download CSV</span> <!-- Teks untuk desktop -->
            </a>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Education</th>
                            <th>Experience</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data instruktur akan ditampilkan disini -->
                        @if ($dataInstructor != null)
                            @foreach ($dataInstructor as $instructor)
                                <tr>
                                    <td>{{ $instructor->name }}</td>
                                    <td>{{ $instructor->email }}</td>
                                    <td>{{ $instructor->education ?? '' }}</td>
                                    <td>{{ $instructor->experience ?? '' }}</td>
                                    <td class="d-flex justify-content-center">
                                        @if ($type === 'super')
                                            <div class="d-flex justify-content-center">
                                                <!-- Delete Button -->
                                                @if ($instructor->education && $instructor->experience)
                                                    <button class="btn btn-danger btn-sm me-2 delete-btn"
                                                        data-id="{{ $instructor->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-success btn-sm edit-btn"
                                                        data-id="{{ $instructor->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#modal-{{ $instructor->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('instructor.data' , ['personId' => $instructor->id]) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif

                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Tampilkan pagination hanya jika pagination tersedia -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <!-- Previous Button -->
                @if ($pagination['page'] > 1)
                    <li class="page-item">
                        <a class="page-link"
                            href="{{ route('data.pengajar', ['page' => $pagination['page'] - 1]) }}">Previous</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                @endif

                <!-- Page Numbers -->
                @for ($i = 1; $i <= $pagination['total_page']; $i++)
                    <li class="page-item {{ $pagination['page'] == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('data.pengajar', ['page' => $i]) }}">{{ $i }}</a>
                    </li>
                @endfor

                <!-- Next Button -->
                @if ($pagination['page'] < $pagination['total_page'])
                    <li class="page-item">
                        <a class="page-link"
                            href="{{ route('data.pengajar', ['page' => $pagination['page'] + 1]) }}">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

    @if ($dataInstructor)

        @foreach ($dataInstructor as $instructor)
            <!-- Modal with unique ID for each instructor -->
            <div class="modal fade" id="modal-{{ $instructor->id }}" tabindex="-1"
                aria-labelledby="modalLabel{{ $instructor->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel{{ $instructor->id }}">Edit Instruktur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.dataPengajar.edit', ['id' => $instructor->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id" name="id"
                                    value="{{ $instructor->id }}">
                                <!-- Image Section -->
                                <div class="image-container text-center mb-4" data-id="{{ $instructor->id }}">
                                    <img src="{{ $instructor->photo_profile }}" alt="{{ $instructor->name }}"
                                        class="img-fluid rounded shadow image-preview"
                                        id="imagePreview{{ $instructor->id }}">
                                    <div class="overlay">Ganti Gambar</div>
                                </div>
                                <input type="file" id="imageUpload{{ $instructor->id }}" name="image"
                                    style="display: none;" accept="image/*">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 mb-3">
                                        <label for="fullName" class="form-label">Full name</label>
                                        <input type="text" class="form-control" id="fullName" name="full_name"
                                            value="{{ $instructor->name }}" readonly>
                                    </div>
                                    <div class="col-lg-6 col-md-12 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $instructor->email }}" readonly>
                                    </div>
                                    <div class="col-lg-6 col-md-12 mb-3">
                                        <label for="education" class="form-label">Education</label>
                                        <input type="text" class="form-control" id="education" name="education"
                                            value="{{ $instructor->education ?? '' }}">
                                    </div>
                                    <div class="col-lg-6 col-md-12 mb-3">
                                        <label for="experience" class="form-label">Experience</label>
                                        <input type="text" class="form-control" id="experience" name="experience"
                                            value="{{ $instructor->experience ?? '' }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

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

        $(document).ready(function() {
            // Ketika image-container diklik, trigger input file yang sesuai
            $('.image-container').on('click', function() {
                var instructorId = $(this).data('id'); // Ambil ID dari data-id elemen yang diklik
                $('#imageUpload' + instructorId).click(); // Trigger input file sesuai dengan ID instruktur
            });

            // Mengubah tampilan gambar setelah memilih file
            $('input[type="file"]').on('change', function(e) {
                var instructorId = $(this).attr('id').replace('imageUpload',
                    ''); // Ambil ID instruktur dari ID input file
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#imagePreview' + instructorId).attr('src', event.target
                        .result); // Update preview gambar sesuai ID instruktur
                }
                reader.readAsDataURL(e.target.files[0]);
            });

            // Ketika gambar di-klik, trigger input file
            $('.image-container-add').on('click', function() {
                $('#imageUpload').click(); // Trigger input file ketika gambar di-klik
            });

            // Mengubah tampilan gambar setelah memilih file
            $('#imageUpload').on('change', function(e) {
                var reader = new FileReader(); // Membuat instance FileReader
                reader.onload = function(event) {
                    $('#imagePreview').attr('src', event.target
                        .result); // Mengubah src gambar pratinjau
                }
                reader.readAsDataURL(e.target.files[0]); // Membaca file yang dipilih
            });
        });


        $(document).on('click', '.delete-btn', function() {
            const token = $("meta[name='csrf-token']").attr("content");
            var instructorId = $(this).data('id');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus instruktur ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ganti URL berikut dengan URL yang sesuai untuk menghapus admin
                    createOverlay("Proses...");
                    $.ajax({
                        url: '/admin/data-pengajar/' +
                            instructorId + '/delete', // Misal menggunakan route yang sesuai
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        success: function(response) {
                            gOverlay.hide()
                            Swal.fire(
                                'Terhapus!',
                                'Instruktur telah dihapus.',
                                'success'
                            );
                            // Reload halaman atau update tabel jika diperlukan
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            gOverlay.hide()
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus admin. ' + (xhr
                                    .responseJSON?.message || ''),
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $(document).on('click', '.edit-btn', function() {
            var instructorId = $(this).data('id');
        });

        // Function to validate password strength
        function validatePassword(password) {
            const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}:";'?/.,]).{8,}$/;
            return passwordPattern.test(password);
        }

        // Password and confirmation fields
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirm');
        const passwordError = document.getElementById('passwordError');
        const passwordMismatch = document.getElementById('passwordMismatch');

        // Add event listener for password input
        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;

            // Validate password format
            if (validatePassword(password)) {
                passwordError.style.display = 'none';
            } else {
                passwordError.style.display = 'block';
            }
        });

        // Add event listener for password confirmation
        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            // Check if passwords match
            if (password === confirmPassword) {
                passwordMismatch.style.display = 'none';
            } else {
                passwordMismatch.style.display = 'block';
            }
        });

        // Form submission validation
        const registrationForm = document.getElementById('registrationForm');
        registrationForm.addEventListener('submit', function(event) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            // Prevent form submission if the password is invalid or passwords don't match
            if (!validatePassword(password) || password !== confirmPassword) {
                event.preventDefault();
            }
        });
    </script>
@endsection

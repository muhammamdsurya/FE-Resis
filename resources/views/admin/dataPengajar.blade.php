@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <style>
        /* Mempercantik Table */
        .table thead th {
            font-size: 0.7rem;
            letter-spacing: 0.05rem;
            text-transform: uppercase;
            background-color: #2E3A9D;
        }

        .table-hover tbody tr:hover {
            background-color: #fcfcfc;
            transition: 0.3s;
        }

        /* Efek hover tombol Download */
        .transition-all:hover {
            transform: translateY(-2px);
            background-color: #0d6efd;
            color: white !important;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        #imagePreview {
            transition: transform 0.2s ease;
            border: 3px solid #f8f9fa;
        }

        #imagePreview:hover {
            transform: scale(1.05);
            border-color: #0d6efd;
        }

        .btn-light {
            border: 1px solid #f0f0f0;
        }
    </style>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0 text-dark">Data Pengajar</h2>
                <p class="text-muted small mb-0">Kelola informasi instruktur dan kredensial akademik.</p>
            </div>
            <div class="d-flex gap-2">
                @if ($type === 'super')
                    <button class="btn btn-success rounded-pill px-4 shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#registrationModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Instruktur
                    </button>
                @endif
                <a href="{{ route('admin.dataInstructor.download') }}"
                    class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-download me-1"></i> Export CSV
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-custom">
                            <tr>
                                <th class="ps-4 py-3 border-0 text-light fw-bold">INSTRUKTUR</th>
                                <th class="py-3 border-0 text-light fw-bold">PENDIDIKAN</th>
                                <th class="py-3 border-0 text-light fw-bold">PENGALAMAN</th>
                                <th class="py-3 border-0 text-light fw-bold text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataInstructor as $instructor)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $instructor->name }}</div>
                                        <small class="text-muted">{{ $instructor->email }}</small>
                                    </td>
                                    <td>
                                        <span class="text-dark small fw-medium">{{ $instructor->education ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark small fw-medium">{{ $instructor->experience ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($type === 'super')
                                            <div class="d-flex justify-content-center gap-2">
                                                @if ($instructor->education && $instructor->experience)
                                                    <button
                                                        class="btn btn-light btn-sm rounded-circle text-danger shadow-sm delete-btn"
                                                        data-id="{{ $instructor->id }}" style="width: 32px; height: 32px;">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                    <button
                                                        class="btn btn-light btn-sm rounded-circle text-success shadow-sm"
                                                        data-bs-toggle="modal" data-bs-target="#modal-{{ $instructor->id }}"
                                                        style="width: 32px; height: 32px;">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('instructor.data', ['personId' => $instructor->id]) }}"
                                                        class="btn btn-warning btn-sm px-3 rounded-pill shadow-sm small">
                                                        Lengkapi Profil
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-person-badge mb-3 fa-2x opacity-25"></i>
                                            <p>Belum ada data pengajar tersedia.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-0 py-4">
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination pagination-sm justify-content-center align-items-center mb-0">

                        <li class="page-item {{ $pagination['page'] <= 1 ? 'disabled' : '' }}">
                            <a class="page-link rounded-circle mx-1 border-0 shadow-sm d-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px;"
                                href="{{ $pagination['page'] > 1 ? route('data.pengajar', ['page' => $pagination['page'] - 1]) : '#' }}">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $pagination['total_page']; $i++)
                            <li class="page-item mx-1 {{ $pagination['page'] == $i ? 'active' : '' }}">
                                <a class="page-link rounded-circle border-0 shadow-sm d-flex align-items-center justify-content-center {{ $pagination['page'] == $i ? 'bg-primary text-white' : 'text-dark' }}"
                                    style="width: 32px; height: 32px;" href="{{ route('data.pengajar', ['page' => $i]) }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor

                        <li class="page-item {{ $pagination['page'] >= $pagination['total_page'] ? 'disabled' : '' }}">
                            <a class="page-link rounded-circle mx-1 border-0 shadow-sm d-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px;"
                                href="{{ $pagination['page'] < $pagination['total_page'] ? route('data.pengajar', ['page' => $pagination['page'] + 1]) : '#' }}">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registrationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0">
                    <h5 class="fw-bold m-0">Tambah Instruktur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <form id="registrationForm" method="POST" action="{{ route('admin.dataInstructor.regis') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img src="{{ asset('assets/img/testimonials/profile.jpg') }}" id="imagePreview"
                                    class="rounded-4 shadow-sm" width="120" height="120"
                                    style="object-fit: cover; cursor: pointer;">
                                <label for="imageUpload"
                                    class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow-sm cursor-pointer"
                                    style="width: 35px; height: 35px;">
                                    <i class="bi bi-camera-fill small"></i>
                                </label>
                            </div>
                            <input type="file" id="imageUpload" name="image" class="d-none" accept="image/*">
                            <p class="text-muted small mt-2">Klik foto untuk unggah</p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" name="full_name" placeholder="Nama"
                                required>
                            <label>Nama Lengkap</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" name="email" placeholder="Email"
                                required>
                            <label>Email Instruktur</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" name="password" placeholder="Pass"
                                required>
                            <label>Password</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control rounded-3" name="password_confirm"
                                placeholder="Conf" required>
                            <label>Konfirmasi Password</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold">Simpan &
                            Daftarkan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Tampilkan pagination hanya jika pagination tersedia -->
    </div>

    @if ($dataInstructor)

        @foreach ($dataInstructor as $instructor)
            <div class="modal fade" id="modal-{{ $instructor->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="fw-bold m-0 text-dark">Edit Profil Instruktur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4">
                            <form action="{{ route('admin.dataPengajar.edit', ['id' => $instructor->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $instructor->id }}">

                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ $instructor->photo_profile ?? asset('assets/img/testimonials/profile.jpg') }}"
                                            alt="{{ $instructor->name }}"
                                            class="rounded-circle shadow-sm border border-3 border-white"
                                            id="imagePreview{{ $instructor->id }}"
                                            style="width: 120px; height: 120px; object-fit: cover;">

                                        <label for="imageUpload{{ $instructor->id }}"
                                            class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow-sm cursor-pointer"
                                            style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;"
                                            title="Ganti Gambar">
                                            <i class="bi bi-camera-fill small"></i>
                                        </label>
                                    </div>
                                    <input type="file" id="imageUpload{{ $instructor->id }}" name="image"
                                        class="d-none" accept="image/*"
                                        onchange="previewImage(this, '{{ $instructor->id }}')">
                                    <p class="small text-muted mt-2">Klik ikon kamera untuk mengubah foto</p>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-secondary">NAMA LENGKAP</label>
                                        <input type="text" class="form-control bg-light rounded-3 shadow-none border-0"
                                            value="{{ $instructor->name }}" readonly disabled style="font-size: 0.9rem;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-secondary">EMAIL</label>
                                        <input type="email" class="form-control bg-light rounded-3 shadow-none border-0"
                                            value="{{ $instructor->email }}" readonly disabled
                                            style="font-size: 0.9rem;">
                                    </div>

                                    <div class="col-12">
                                        <label for="education{{ $instructor->id }}"
                                            class="form-label small fw-bold text-secondary text-uppercase">
                                            <i class="bi bi-mortarboard-fill me-1 text-primary"></i> Pendidikan Terakhir
                                        </label>
                                        <textarea class="form-control rounded-3 shadow-sm" id="education{{ $instructor->id }}" name="education"
                                            rows="2" placeholder="Contoh: S1 Teknik Informatika - Univ. Indonesia">{{ $instructor->education ?? '' }}</textarea>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-secondary text-uppercase">
                                            <i class="bi bi-briefcase-fill me-1 text-primary"></i> Pengalaman Kerja
                                        </label>
                                        <textarea class="form-control rounded-3 shadow-sm" id="experience{{ $instructor->id }}" name="experience"
                                            rows="2" placeholder="Contoh: Analis Kimia - Pertamina Indonesia">{{ $instructor->experience ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="modal-footer border-0 pt-4 px-0 pb-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Simpan
                                        Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        });

        // Tambahkan trigger klik pada gambar
        document.getElementById('imagePreview').addEventListener('click', function() {
            document.getElementById('imageUpload').click();
        });

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
                            setTimeout(() => {
                                location.reload();
                            }, 1500); // Delay 1.5 detik sebelum redirect
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

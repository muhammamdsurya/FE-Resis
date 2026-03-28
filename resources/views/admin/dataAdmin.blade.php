@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <style>
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


        /* Hilangkan outline default focus */
        .page-link:focus {
            box-shadow: none;
        }
    </style>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0 text-dark">Data Pengelola</h2>
                <p class="text-muted small mb-0">Manajemen akses dan daftar akun administrator.</p>
            </div>
            <div class="d-flex gap-2">
                @if ($type === 'super')
                    <button class="btn btn-success rounded-pill px-3 shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#registrationModal">
                        <i class="bi bi-person-plus-fill me-1"></i> Tambah Admin
                    </button>
                @endif
                <a href="{{ route('admin.dataAdmin.download') }}"
                    class="btn btn-outline-primary rounded-pill px-3 shadow-sm">
                    <i class="bi bi-download me-1"></i> Export CSV
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 ps-4 py-3 text-light fw-bold">NAMA</th>
                                <th class="border-0 py-3 text-light fw-bold">EMAIL</th>
                                <th class="border-0 py-3 text-light fw-bold text-center">TIPE</th>
                                <th class="border-0 py-3 text-light fw-bold">TERDAFTAR</th>
                                <th class="border-0 py-3 text-light fw-bold text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataAdmin as $admin)
                                <tr>
                                    <td class="ps-4 fw-semibold text-dark">{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge rounded-pill {{ $admin->type === 'super' ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary' }} px-3">
                                            {{ strtoupper($admin->type ?? 'ADMIN') }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ \Carbon\Carbon::parse($admin->created_at)->format('d M Y, H:i') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($type === 'super')
                                            <div class="d-flex justify-content-center gap-2">

                                                {{-- Logika: Hanya tampil jika type kosong (null atau string kosong) --}}
                                                @if (empty($admin->type))
                                                    <a href="{{ route('admin.data', ['id' => $admin->id]) }}"
                                                        class="btn btn-light btn-sm rounded-circle text-warning shadow-sm d-flex align-items-center justify-content-center"
                                                        style="width: 32px; height: 32px;">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                @endif

                                                {{-- Tombol hapus biasanya tetap ada untuk pengelolaan data --}}
                                                <button
                                                    class="btn btn-light btn-sm rounded-circle text-danger delete-btn shadow-sm d-flex align-items-center justify-content-center"
                                                    data-id="{{ $admin->id }}" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-trash3"></i>
                                                </button>

                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada data pengelola</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-4">
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination pagination-sm justify-content-center align-items-center mb-0">

                        {{-- Button Previous --}}
                        <li class="page-item {{ $pagination['page'] <= 1 ? 'disabled' : '' }}">
                            <a class="page-link rounded-circle mx-1 border-0 shadow-sm d-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px;"
                                href="{{ $pagination['page'] > 1 ? route('data.admin', ['page' => $pagination['page'] - 1]) : '#' }}"
                                aria-label="Previous">
                                <i class="bi bi-chevron-left text-dark"></i>
                            </a>
                        </li>

                        @php
                            $current = $pagination['page'];
                            $total = $pagination['total_page'];
                            $show = 2; // Menampilkan 2 angka di kiri dan kanan halaman aktif
                        @endphp

                        {{-- Page Numbers Logic --}}
                        @for ($i = 1; $i <= $total; $i++)
                            @if ($i == 1 || $i == $total || ($i >= $current - $show && $i <= $current + $show))
                                <li class="page-item mx-1 {{ $current == $i ? 'active' : '' }}">
                                    <a class="page-link rounded-circle border-0 shadow-sm d-flex align-items-center justify-content-center p-0 {{ $current == $i ? 'bg-primary text-white' : 'text-dark bg-white' }}"
                                        style="width: 32px; height: 32px; line-height: 0;" {{-- Tambahkan line-height: 0 atau p-0 --}}
                                        href="{{ route('data.admin', ['page' => $i]) }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @elseif ($i == $current - $show - 1 || $i == $current + $show + 1)
                                <li class="page-item disabled">
                                    <span class="page-link border-0 bg-transparent text-muted px-2">...</span>
                                </li>
                            @endif
                        @endfor

                        {{-- Button Next --}}
                        <li class="page-item {{ $pagination['page'] >= $total ? 'disabled' : '' }}">
                            <a class="page-link rounded-circle mx-1 border-0 shadow-sm d-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px;"
                                href="{{ $pagination['page'] < $total ? route('data.admin', ['page' => $pagination['page'] + 1]) : '#' }}"
                                aria-label="Next">
                                <i class="bi bi-chevron-right text-dark"></i>
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
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold">Tambah Admin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="registrationForm" method="POST" action="{{ route('admin.dataAdmin.regis') }}">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="full_name" name="full_name"
                                placeholder="Nama" required>
                            <label>Nama Lengkap</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="email" name="email"
                                placeholder="Email" required>
                            <label>Alamat Email</label>
                        </div>
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control rounded-3 pe-5" id="password" name="password"
                                placeholder="Pass" required>
                            <label>Password</label>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer"
                                onclick="togglePass()">
                                <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                            </span>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control rounded-3" id="password_confirm"
                                name="password_confirm" placeholder="Conf" required>
                            <label>Konfirmasi Password</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow">Simpan Data
                            Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        $(document).on('click', '.delete-btn', function() {
            const token = $("meta[name='csrf-token']").attr("content");
            var adminId = $(this).data('id');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus admin ini?",
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
                        url: '/admin/data-admin/' + adminId, // Misal menggunakan route yang sesuai
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        success: function(response) {
                            gOverlay.hide()
                            Swal.fire(
                                'Terhapus!',
                                'Admin telah dihapus.',
                                'success'
                            );
                            // Reload halaman atau update tabel jika diperlukan
                            // Tunggu 1.5 detik sebelum reload
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
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
    </script>
@endsection

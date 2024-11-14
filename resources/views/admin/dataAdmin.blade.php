@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($type === 'super')
                <!-- Tombol untuk menampilkan modal -->
                <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#registrationModal">
                    <i class="fas fa-plus d-inline me-1"></i> <!-- Ikon untuk mobile -->
                    <span class="d-lg-inline">Tambah Admin</span> <!-- Teks untuk desktop -->
                </a>
            @endif

            <!-- Modal untuk Registrasi -->
            <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="registrationModalLabel">Registrasi Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="registrationForm" method="POST" action="{{ route('admin.dataAdmin.regis') }}">
                                @csrf
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
            <a href="{{ route('admin.dataAdmin.download') }}" class="btn btn-primary mb-3 float-right">
                <i class="fas fa-download d-inline me-1 "></i> <!-- Ikon untuk mobile -->
                <span class=" d-lg-inline">Download CSV</span> <!-- Teks untuk desktop -->
            </a>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Created</th>
                            <th>Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data admin akan ditampilkan disini -->
                        @if ($dataAdmin)
                            @foreach ($dataAdmin as $admin)
                                <tr>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->type ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($admin->created_at)->timezone('Asia/Jakarta')->format('d F Y, H:i') }}
                                    </td>
                                    <td>
                                        @if ($type === 'super')
                                            @if ($admin->type)
                                                <button class="btn btn-danger btn-sm me-2 delete-btn"
                                                    data-id="{{ $admin->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <a href="{{ route('admin.data', ['id' => $admin->id]) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" style="text-align: center;">Belum ada data</td>
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
                            href="{{ route('data.admin', ['page' => $pagination['page'] - 1]) }}">Previous</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                @endif

                <!-- Page Numbers -->
                @for ($i = 1; $i <= $pagination['total_page']; $i++)
                    <li class="page-item {{ $pagination['page'] == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('data.admin', ['page' => $i]) }}">{{ $i }}</a>
                    </li>
                @endfor

                <!-- Next Button -->
                @if ($pagination['page'] < $pagination['total_page'])
                    <li class="page-item">
                        <a class="page-link" href="{{ route('data.admin', ['page' => $pagination['page'] + 1]) }}">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
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
    </script>
@endsection

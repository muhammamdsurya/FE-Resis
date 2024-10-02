@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($type === 'super')
                <a href="{{ route('admin.dataAdmin.download') }}" class="btn btn-success mb-3">
                    <i class="fas fa-plus d-inline me-1 "></i> <!-- Ikon untuk mobile -->
                    <span class=" d-lg-inline">Tambah Admin</span> <!-- Teks untuk desktop -->
                </a>
            @endif
            <a href="{{ route('admin.dataAdmin.download') }}" class="btn btn-primary mb-3 float-right">
                <i class="fas fa-download d-inline me-1 "></i> <!-- Ikon untuk mobile -->
                <span class=" d-lg-inline">Download CSV</span> <!-- Teks untuk desktop -->
            </a>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tipe</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data admin akan ditampilkan disini -->
                        @foreach ($dataAdmin as $admin)
                            <tr>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->type }}</td>
                                <td>{{ \Carbon\Carbon::parse($admin->created_at)->format('d F Y, H:i') }}</td>
                                <td>
                                    @if ($type === 'super')
                                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $admin->name }}">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
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

    <script>
        $(document).on('click', '.delete-btn', function() {
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
                    $.ajax({
                        url: '/admin/data/admins/' + adminId, // Misal menggunakan route yang sesuai
                        type: 'DELETE',
                        success: function(response) {
                            // Tindakan setelah penghapusan berhasil
                            Swal.fire(
                                'Terhapus!',
                                'Admin telah dihapus.',
                                'success'
                            );
                            // Reload halaman atau update tabel jika diperlukan
                            location.reload();
                        },
                        error: function() {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus admin.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection

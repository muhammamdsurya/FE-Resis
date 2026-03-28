@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <style>
        /* Soft colors untuk badge */
        .bg-blue-subtle {
            background-color: #e7f0ff !important;
        }

        .w-fit {
            width: fit-content;
        }

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

        /* Custom Pagination Bulat */
        .page-link {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .page-item.disabled .page-link {
            background-color: #f8f9fa;
            opacity: 0.5;
        }
    </style>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0 text-dark">Data Siswa</h2>
                <p class="text-muted small mb-0">Manajemen informasi dan riwayat pendaftaran siswa.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dataUser.download') }}"
                    class="btn btn-outline-primary rounded-pill px-4 shadow-sm transition-all">
                    <i class="bi bi-download me-2"></i> Export CSV
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
             <thead>
                            <tr>
                                <th class="ps-4 py-3 border-0 text-light small fw-bold">NAMA LENGKAP</th>
                                <th class="py-3 border-0 text-light small fw-bold">EMAIL</th>
                                <th class="py-3 border-0 text-light small fw-bold">JENJANG / INSTITUSI</th>
                                <th class="py-3 border-0 text-light small fw-bold">TANGGAL LAHIR</th>
                                <th class="py-3 border-0 text-light small fw-bold">BERGABUNG</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataSiswa as $siswa)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">{{ $siswa->name }}</span>
                                    </td>
                                    <td>{{ $siswa->email }}</td>
                                    <td>
                                        <span class="badge rounded-pill px-3 bg-primary-subtle text-primary mb-1">
                                            {{ strtoupper($siswa->study_level) }}
                                        </span>
                                        <div class="text-muted small ps-1">{{ $siswa->institution }}</div>
                                    </td>
                                    <td>
                                        <span class="text-dark small">
                                            {{ \Carbon\Carbon::parse($siswa->birth)->translatedFormat('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="small text-dark">
                                            {{ \Carbon\Carbon::parse($siswa->created_at)->translatedFormat('d M Y') }}
                                        </div>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            {{ \Carbon\Carbon::parse($siswa->created_at)->format('H:i') }} WIB
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-people mb-3 fa-2x opacity-25"></i>
                                            <p>Belum ada data siswa yang tersedia.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-0 py-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm justify-content-center mb-0 shadow-none">
                        {{-- Previous Button --}}
                        <li class="page-item {{ $pagination['page'] <= 1 ? 'disabled' : '' }}">
                            <a class="page-link rounded-circle mx-1 border-0 shadow-sm"
                                href="{{ $pagination['page'] > 1 ? route('data.siswa', ['page' => $pagination['page'] - 1]) : '#' }}">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        {{-- Page Numbers --}}
                        @for ($i = 1; $i <= $pagination['total_page']; $i++)
                            <li class="page-item mx-1 {{ $pagination['page'] == $i ? 'active' : '' }}">
                                <a class="page-link rounded-circle border-0 shadow-sm {{ $pagination['page'] == $i ? 'bg-primary text-white' : 'text-dark' }}"
                                    href="{{ route('data.siswa', ['page' => $i]) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Next Button --}}
                        <li class="page-item {{ $pagination['page'] >= $pagination['total_page'] ? 'disabled' : '' }}">
                            <a class="page-link rounded-circle mx-1 border-0 shadow-sm"
                                href="{{ $pagination['page'] < $pagination['total_page'] ? route('data.siswa', ['page' => $pagination['page'] + 1]) : '#' }}">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

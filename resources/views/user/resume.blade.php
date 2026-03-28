@extends('layout.userLayout')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0 text-dark">Riwayat Analisis CV</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"
                                class="text-decoration-none text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item active fw-semibold text-primary" aria-current="page">Riwayat Analisis</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('cvmenu') }}" class="btn btn-primary px-4 py-2 shadow-sm d-flex align-items-center"
                style="border-radius: 12px; transition: all 0.3s;">
                <i class="fas fa-magic me-2"></i> <span>Analisis Baru</span>
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm position-relative overflow-hidden" style="border-radius: 16px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                                <i class="fas fa-history fa-lg"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block fw-bold text-uppercase"
                                    style="font-size: 0.7rem; letter-spacing: 1px;">Total Analisis</small>
                                <h3 class="fw-bold m-0 text-dark">{{ $total }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute" style="right: -10px; bottom: -10px; opacity: 0.05;">
                        <i class="fas fa-file-invoice fa-5x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
            <div class="card-header bg-white border-0 py-3 ps-4">
                <h5 class="fw-bold m-0 text-dark">Daftar Hasil Analisis</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light bg-opacity-50">
                            <tr>
                                <th class="ps-4 py-3 text-muted small text-uppercase fw-bold">Waktu Analisis</th>
                                <th class="py-3 text-muted small text-uppercase fw-bold">Target Posisi</th>
                                <th class="py-3 text-muted small text-uppercase fw-bold">Pengalaman</th>
                                <th class="py-3 text-muted small text-uppercase fw-bold text-center">Matching Score</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase fw-bold text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3"
                                                style="width: 40px; height: 40px;">
                                                <i class="far fa-calendar-alt text-muted"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">
                                                    {{ \Carbon\Carbon::parse($item['created_at'])->translatedFormat('d M Y') }}
                                                </div>
                                                <small class="text-muted"><i class="far fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($item['created_at'])->format('H:i') }}
                                                    WIB</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="fw-semibold text-dark text-truncate" style="max-width: 280px;"
                                                title="{{ $item['job_description'] }}">
                                                <i class="fas fa-briefcase me-2 text-primary opacity-50"></i>
                                                @php
                                                    // Mengambil apapun setelah 'Posisi:' sampai bertemu titik yang diikuti kata 'Berikut'
                                                    preg_match(
                                                        '/Posisi:\s*(.*?)\.\s*Berikut/i',
                                                        $item['job_description'],
                                                        $matches,
                                                    );
                                                    $position = $matches[1] ?? 'Posisi Tidak Ditemukan';
                                                @endphp
                                                {{ $position }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
                                            {{ str_replace('Years', 'Tahun', $item['experience_years']) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $val = $item['match_percentage'];
                                            $color = $val >= 80 ? 'success' : ($val >= 50 ? 'warning' : 'danger');
                                            $icon =
                                                $val >= 80
                                                    ? 'fa-check-circle'
                                                    : ($val >= 50
                                                        ? 'fa-exclamation-circle'
                                                        : 'fa-times-circle');
                                        @endphp
                                        <div class="d-inline-flex align-items-center px-3 py-2 rounded-pill bg-{{ $color }} bg-opacity-10 text-{{ $color }} fw-bold"
                                            style="font-size: 0.85rem;">
                                            <i class="fas {{ $icon }} me-2"></i> {{ $val }}%
                                        </div>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('resume.detail', $item['id']) }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-4 fw-bold hover-btn">
                                            Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-white border-0 py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p class="small text-muted mb-0">
                            Menampilkan <span class="fw-bold text-dark">{{ count($results) }}</span> dari <span
                                class="fw-bold text-dark">{{ $total }}</span> laporan tersimpan
                        </p>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm justify-content-center justify-content-md-end mb-0">
                                @php $totalPages = ceil($total / $per_page); @endphp

                                <li class="page-item {{ $current_page <= 1 ? 'disabled' : '' }}">
                                    <a class="page-link border-0 shadow-none rounded-circle me-2"
                                        href="{{ route('resume.history', ['page' => $current_page - 1]) }}">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>

                                @for ($i = 1; $i <= $totalPages; $i++)
                                    @if ($i == 1 || $i == $totalPages || ($i >= $current_page - 1 && $i <= $current_page + 1))
                                        <li class="page-item {{ $current_page == $i ? 'active' : '' }}">
                                            <a class="page-link border-0 shadow-none rounded-circle mx-1 {{ $current_page == $i ? '' : 'text-dark' }}"
                                                href="{{ route('resume.history', ['page' => $i]) }}">{{ $i }}</a>
                                        </li>
                                    @elseif ($i == $current_page - 2 || $i == $current_page + 2)
                                        <li class="page-item disabled"><span
                                                class="page-link border-0 bg-transparent">...</span></li>
                                    @endif
                                @endfor

                                <li class="page-item {{ $current_page >= $totalPages ? 'disabled' : '' }}">
                                    <a class="page-link border-0 shadow-none rounded-circle ms-2"
                                        href="{{ route('resume.history', ['page' => $current_page + 1]) }}">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table thead th {
            border-top: none;
            letter-spacing: 0.5px;
        }

        .hover-btn:hover {
            background-color: #0d6efd;
            color: white;
            transform: translateX(5px);
            transition: all 0.3s;
        }

        .page-link {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
            color: white;
        }

        tr:hover {
            background-color: rgba(13, 110, 253, 0.02) !important;
        }
    </style>
@endsection

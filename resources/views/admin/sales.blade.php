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
    </style>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0 text-dark">Data Penjualan</h2>
                <p class="text-muted small mb-0">Pantau transaksi, status pembayaran, dan laporan pendapatan.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dataSales.download') }}"
                    class="btn btn-outline-primary rounded-pill px-4 shadow-sm transition-all">
                    <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export CSV
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-custom">
                            <tr>
                                <th class="ps-4 py-3 border-0 text-light fw-bold">PELANGGAN</th>
                                <th class="py-3 border-0 text-light fw-bold">PRODUK & TIPE</th>
                                <th class="py-3 border-0 text-light fw-bold text-end">TOTAL HARGA</th>
                                <th class="py-3 border-0 text-light fw-bold text-center">STATUS</th>
                                <th class="py-3 border-0 text-light fw-bold">METODE</th>
                                <th class="py-3 border-0 text-light fw-bold">TANGGAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataSales as $sale)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">{{ $sale->name }}</span>
                                    </td>
                                    <td>
                                        <div class="text-dark fw-semibold mb-1">{{ $sale->product_name }}</div>
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2"
                                            style="font-size: 0.7rem;">
                                            {{ strtoupper($sale->transaction_type) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="fw-bold text-primary">
                                            Rp{{ number_format($sale->total_amount, 0, ',', '.') }}
                                        </div>
                                        <small class="text-muted" style="font-size: 0.7rem;">Pajak:
                                            {{ number_format($sale->tax, 0, ',', '.') }}</small>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $statusClass =
                                                [
                                                    'settlement' => 'bg-success-subtle text-success',
                                                    'pending' => 'bg-warning-subtle text-warning',
                                                    'expire' => 'bg-danger-subtle text-danger',
                                                    'cancel' => 'bg-secondary-subtle text-secondary',
                                                ][$sale->payment_status] ?? 'bg-primary-subtle text-primary';
                                        @endphp
                                        <span class="badge rounded-pill px-3 {{ $statusClass }}">
                                            {{ strtoupper($sale->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center small">
                                            <i class="bi bi-credit-card me-2 text-muted"></i>
                                            <span class="text-dark">{{ strtoupper($sale->payment_type) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small text-dark">
                                            {{ \Carbon\Carbon::parse($sale->created_at)->translatedFormat('d M Y') }}
                                        </div>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            {{ \Carbon\Carbon::parse($sale->created_at)->format('H:i') }} WIB
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox mb-3 fa-2x opacity-25"></i>
                                            <p>Belum ada data transaksi yang tersedia.</p>
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
                    <ul class="pagination pagination-sm justify-content-center align-items-center mb-0 shadow-none">

                        {{-- Previous --}}
                        <li class="page-item {{ $pagination['page'] <= 1 ? 'disabled' : '' }}">
                            <a class="page-link rounded-circle mx-1 border-0 shadow-sm d-flex align-items-center justify-content-center p-0"
                                style="width: 32px; height: 32px;"
                                href="{{ $pagination['page'] > 1 ? route('sales', ['page' => $pagination['page'] - 1]) : '#' }}">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        @php
                            $current = $pagination['page'];
                            $total = $pagination['total_page'];
                            $show = 2;
                        @endphp

                        {{-- Page Logic --}}
                        @for ($i = 1; $i <= $total; $i++)
                            @if ($i == 1 || $i == $total || ($i >= $current - $show && $i <= $current + $show))
                                <li class="page-item mx-1 {{ $current == $i ? 'active' : '' }}">
                                    <a class="page-link rounded-circle border-0 shadow-sm d-flex align-items-center justify-content-center p-0 {{ $current == $i ? 'bg-primary text-white' : 'bg-white text-dark' }}"
                                        style="width: 32px; height: 32px;" href="{{ route('sales', ['page' => $i]) }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @elseif ($i == $current - $show - 1 || $i == $current + $show + 1)
                                <li class="page-item disabled">
                                    <span class="page-link border-0 bg-transparent px-2">...</span>
                                </li>
                            @endif
                        @endfor

                        {{-- Next --}}
                        <li class="page-item {{ $current >= $total ? 'disabled' : '' }}">
                            <a class="page-link rounded-circle mx-1 border-0 shadow-sm d-flex align-items-center justify-content-center p-0"
                                style="width: 32px; height: 32px;"
                                href="{{ $current < $total ? route('sales', ['page' => $current + 1]) : '#' }}">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

@extends('layout.userLayout')
@section('filter')
    <div class="filter-dropdown d-md-none ms-3">
        <div class="dropdown">
            <button class="btn btn-white shadow-sm dropdown-toggle fw-bold" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                <i class="fas fa-filter me-1 text-primary"></i> Filter
            </button>
            <ul class="dropdown-menu border-0 shadow" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item {{ $filter == 'active' ? 'active' : '' }}" href="?filter=active">Belum Bayar</a></li>
                <li><a class="dropdown-item {{ $filter == 'pending' ? 'active' : '' }} " href="?filter=pending">Pending</a></li>
                <li><a class="dropdown-item {{ $filter == 'settlement' ? 'active' : '' }}" href="?filter=settlement">Berhasil</a></li>
                <li><a class="dropdown-item {{ $filter == 'expire' ? 'active' : '' }}" href="?filter=expire">Expired</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <style>
        .card-course {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #fff;
        }
        .card-course:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .btn-filter {
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            border: none;
        }
        .btn-filter.active {
            background-color: #007bff !important;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }
        .btn-filter.inactive {
            background-color: #e9ecef;
            color: #6c757d;
        }
        .badge-status {
            font-size: 0.7rem;
            padding: 5px 10px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .pagination .page-link {
            border: none;
            margin: 0 3px;
            border-radius: 8px;
            color: #6c757d;
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff;
            box-shadow: 0 3px 6px rgba(0, 123, 255, 0.2);
        }
    </style>

    <div class="container-fluid p-4" style="background-color: #f4f6f9; min-height: 100vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0" style="color: #343a40;">Riwayat Transaksi</h2>
                <p class="text-muted small">Kelola dan pantau semua pembayaran kursus Anda</p>
            </div>

            <div class="d-none d-md-flex gap-2">
                <a href="?filter=active" class="btn btn-filter {{ $filter == 'active' ? 'active' : 'inactive' }}">Belum Bayar</a>
                <a href="?filter=pending" class="btn btn-filter {{ $filter == 'pending' ? 'active' : 'inactive' }}">Pending</a>
                <a href="?filter=settlement" class="btn btn-filter {{ $filter == 'settlement' ? 'active' : 'inactive' }}">Berhasil</a>
                <a href="?filter=expire" class="btn btn-filter {{ $filter == 'expire' ? 'active' : 'inactive' }}">Expired</a>
            </div>
        </div>

        <div class="row">
            @if (isset($transactions->data) && count($transactions->data) > 0)
                @foreach ($transactions->data as $transaction)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card card-course h-100 border-0 shadow-sm">
                            <div class="position-relative">
                                <img src="{{$transaction->course->thumbnail_image }}" class="card-img-top"
                                     alt="{{$transaction->course->name}}" style="height: 160px; object-fit: cover;">

                                @if ($filter != 'active')
                                    <div class="position-absolute top-0 end-0 m-2">
                                        @php
                                            $status = strtolower($transaction->transaction->payment_status);
                                            $badgeClass = $status == 'settlement' ? 'bg-success' : ($status == 'pending' ? 'bg-warning text-dark' : 'bg-danger');
                                        @endphp
                                        <span class="badge badge-status {{ $badgeClass }}">
                                            {{ $transaction->transaction->payment_status }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="card-title fw-bold text-dark mb-2">{{ Str::limit($transaction->course->name, 40) }}</h6>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($transaction->course->description, 60) }}
                                </p>

                                @if ($filter == 'active')
                                    <button onclick="pay('{{ $transaction->midtrans_snap_token }}')"
                                            class="btn btn-primary btn-sm w-100 mt-2 fw-bold" style="border-radius: 8px; padding: 10px;">
                                        Bayar Sekarang <i class="fas fa-credit-card ms-1" style="font-size: 0.8rem;"></i>
                                    </button>
                                @else
                                    <div class="mt-2 pt-2 border-top">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted small">Total:</span>
                                            <span class="fw-bold text-primary">Rp {{ number_format($transaction->transaction->course_price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">Tidak ada transaksi ditemukan</h5>
                </div>
            @endif
        </div>

        @if($filter != 'active' && isset($transactions->pagination))
            <div class="mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $transactions->pagination->page <= 1 ? 'disabled' : '' }}">
                            <a class="page-link shadow-sm" href="/user/transaksi?filter={{$filter}}&page={{$transactions->pagination->page - 1}}">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>

                        @for ($i = 1; $i <= $transactions->pagination->total_page; $i++)
                            <li class="page-item {{ $transactions->pagination->page === $i ? 'active' : '' }}">
                                <a class="page-link shadow-sm" href="/user/transaksi?filter={{$filter}}&page={{$i}}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item {{ $transactions->pagination->page >= $transactions->pagination->total_page ? 'disabled' : '' }}">
                            <a class="page-link shadow-sm" href="/user/transaksi?filter={{$filter}}&page={{$transactions->pagination->page + 1}}">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{env('CLIENT_KEY')}}"></script>
    <script>
        function pay(token) {
            window.snap.pay(token, {
                onSuccess: function(result){ location.reload(); },
                onPending: function(result){ location.reload(); },
                onError: function(result){ location.reload(); }
            });
        }
    </script>
@endsection

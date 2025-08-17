@extends('layout.userLayout')
@section('title', $title)

@section('filter')

    <!-- Filter Dropdown -->
    <div class="filter-dropdown d-md-none d-sm-block ms-md-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                Filter
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item {{ $filter == 'active' ? 'active' : '' }}" href="?filter=active">Belum Bayar</a></li>
                <li><a class="dropdown-item {{ $filter == 'pending' ? 'active' : '' }} " href="?filter=pending">Pending</a></li>
                <li><a class="dropdown-item {{ $filter == 'settlement' ? 'active' : '' }}" href="?filter=settlement">Settlement</a></li>
                <li><a class="dropdown-item {{ $filter == 'expire' ? 'active' : '' }}" href="?filter=expire">Expired</a></li>
            </ul>
        </div>
    </div>


@endsection

@section('content')
    <style>
        .card {
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            cursor: pointer;
        }


    </style>
    <div class="container-fluid">
        <section class="col-12 mt-2">
            <div class="row mb-3 text-center">
                <div class="d-grid gap-2 d-none d-md-block">
                    <button class="btn btn-{{ $filter == 'active' ? 'primary' : 'secondary' }}" type="button"
                        onclick="window.location.href='?filter=active'">Belum Bayar</button>
                    <button class="btn btn-{{ $filter == 'pending' ? 'primary' : 'secondary' }}" type="button"
                        onclick="window.location.href='?filter=pending'">Pending</button>
                    <button class="btn btn-{{ $filter == 'settlement' ? 'primary' : 'secondary' }}" type="button"
                        onclick="window.location.href='?filter=settlement'">Berhasil</button>
                    <button class="btn btn-{{ $filter == 'expire' ? 'primary' : 'secondary' }}" type="button"
                        onclick="window.location.href='?filter=expire'">Expired</button>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row">
                    @if (isset($transactions->data))
                        @foreach ($transactions->data as $transaction)
                            <div class="col-lg-3 col-md-4 col-6 mb-4">
                                <div class="card h-100 shadow border-0 position-relative"
                                    style="border-radius: 15px; overflow: hidden;">
                                    <img src="{{ $transaction->course->thumbnail_image }}" class="card-img-top"
                                        alt="{{$transaction->course->name}}" style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        @if ($filter != 'active')
                                            <p class="text-center text-danger mb-2">
                                                <strong>{{ $transaction->transaction->payment_status }}</strong>
                                            </p>
                                        @endif

                                        <h5 class="card-title fw-bold text-dark">{{ $transaction->course->name }}</h5>

                                        <p class="card-text text-muted">
                                            {{ Str::limit($transaction->course->description, 50) }}
                                        </p>
                                        @if ($filter == 'active')
                                            <button onclick="pay('{{ $transaction->midtrans_snap_token }}')"
                                                class="btn btn-primary mt-2 w-100">Bayar <i
                                                    class="fas fa-arrow-circle-right"></i></button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            @if($filter != 'active'  && isset($transactions))
             <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Button -->
                            @if ($transactions->pagination->page > 1)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="/user/transaksi?filter= {{$filter}}&page={{$transactions->pagination->page - 1}}">Previous</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                            @endif

                            <!-- Page Numbers -->
                            @for ($i = 1; $i <= $transactions->pagination->total_page; $i++)
                                <li class="page-item {{ $transactions->pagination->page === $i ? 'active' : '' }}">
                                    <a class="page-link" href="/user/transaksi?filter= {{$filter}}&page={{$i}}">{{ $i }}</a>
                                </li>
                            @endfor

                            <!-- Next Button -->
                            @if ($transactions->pagination->page < $transactions->pagination->total_page)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="/user/transaksi?filter= {{$filter}}&page={{$transactions->pagination->page + 1}}">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <a class="page-link">Next</a>
                                </li>
                            @endif
                        </ul>
                    </nav>
            @endif

        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{env('CLIENT_KEY')}}"></script>
    <script>
        function pay(token) {
            const midTransSnap = new MidTransSnap(token);
            midTransSnap.pay();
        }
    </script>

@endsection

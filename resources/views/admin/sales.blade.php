@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.dataSales.download') }}" class="btn btn-primary mb-3">
                <i class="fas fa-download d-inline me-1 "></i> <!-- Ikon untuk mobile -->
                <span class="d-lg-inline">Download CSV</span> <!-- Teks untuk desktop -->
            </a>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered" id="sales-table">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Transaction Type</th>
                            <th>Product Name</th>
                            <th>Course Price</th>
                            <th>Transaction Fee</th>
                            <th>Tax</th>
                            <th>Total Amount</th>
                            <th>Payment Status</th>
                            <th>Payment Type</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($dataSales)
                            @foreach ($dataSales as $sale)
                                <tr>
                                    <td>{{ $sale->name }}</td>
                                    <td>{{ $sale->transaction_type }}</td>
                                    <td>{{ $sale->product_name }}</td>
                                    <td>{{ number_format($sale->course_price, 0, ',', '.') }}</td>
                                    <td>{{ number_format($sale->transaction_fee, 0, ',', '.') }}</td>
                                    <td>{{ number_format($sale->tax, 0, ',', '.') }}</td>
                                    <td>{{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                                    <td>{{ $sale->payment_status }}</td>
                                    <td>{{ $sale->payment_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d F Y, H:i') }}</td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="10" style="text-align: center;">Belum ada data</td>
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
                        <a class="page-link" href="{{ route('sales', ['page' => $pagination['page'] - 1]) }}">Previous</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                @endif

                <!-- Page Numbers -->
                @for ($i = 1; $i <= $pagination['total_page']; $i++)
                    <li class="page-item {{ $pagination['page'] == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('sales', ['page' => $i]) }}">{{ $i }}</a>
                    </li>
                @endfor

                <!-- Next Button -->
                @if ($pagination['page'] < $pagination['total_page'])
                    <li class="page-item">
                        <a class="page-link" href="{{ route('sales', ['page' => $pagination['page'] + 1]) }}">Next</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link">Next</a>
                    </li>
                @endif
            </ul>
        </nav>

    </div>
@endsection

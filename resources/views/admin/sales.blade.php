@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="sales-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
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
            </table>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#sales-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/admin/sales') }}", // Adjust the route as needed
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'transaction_type',
                    name: 'transaction_type'
                },
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'course_price',
                    name: 'course_price'
                },
                {
                    data: 'transaction_fee',
                    name: 'transaction_fee'
                },
                {
                    data: 'tax',
                    name: 'tax'
                },
                {
                    data: 'total_amount',
                    name: 'total_amount'
                },
                {
                    data: 'payment_status',
                    name: 'payment_status'
                },
                {
                    data: 'payment_type',
                    name: 'payment_type'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ],
            order: [[10, 'desc']], // Order by Created At column
            pageLength: 3,
            lengthChange: false, // Disable the "Show entries" dropdown
        });
    });
</script>

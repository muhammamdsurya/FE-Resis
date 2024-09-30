@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="admin-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tipe</th>
                        <th>Dibuat</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#admin-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/admin/data-admin') }}", // Correct route
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                }
            ],
            order: [
                [3, 'desc']
            ], // Order by Created At column (index 3)
            pageLength: 3,
            lengthChange: false, // Disable the "Show entries" dropdown
            responsive: true // Enable responsive feature
        });


        // Function to format number as currency (IDR)
        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

    });
</script>

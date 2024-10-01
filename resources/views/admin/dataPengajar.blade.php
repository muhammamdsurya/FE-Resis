@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="instructor-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Edukasi</th>
                        <th>Pengalaman</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#instructor-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/admin/data-pengajar') }}", // Correct route
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'education',
                    name: 'education'
                },
                {
                    data: 'experience',
                    name: 'experience'
                }
            ],
            order: [
                [3, 'desc']
            ], // Order by Created At column (index 3)
            pageLength: 3,
            lengthChange: false, // Disable the "Show entries" dropdown
            responsive: true // Enable responsive feature
        });

    });
</script>

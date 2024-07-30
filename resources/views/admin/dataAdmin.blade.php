@extends('layout.adminLayout')
@section('title', $title)

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <div class="card">
        <div class="card-header">
            <button type="submit" class="btn btn-success">Ekspor Data</button>
          </div>
        <!-- /.card-header -->
       <div class="card-body">
        <table id="employeeTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start Date</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be filled here -->
            </tbody>
        </table>
       </div>
        <!-- /.card-body -->
      </div>

      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <li class="page-item disabled">
            <a class="page-link">Previous</a>
          </li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#">Next</a>
          </li>
        </ul>
      </nav>
      <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
      <script>

$(document).ready(function() {
    $('#example').DataTable();
});

      </script>
@endsection

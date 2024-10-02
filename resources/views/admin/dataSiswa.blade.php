@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.dataUser.download') }}" class="btn btn-primary mb-3">
                <i class="fas fa-download d-inline me-1 "></i> <!-- Ikon untuk mobile -->
                <span class=" d-lg-inline">Download CSV</span> <!-- Teks untuk desktop -->
            </a>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Study Level</th>
                            <th>Institution</th>
                            <th>Birth</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data admin akan ditampilkan disini -->
                        @foreach ($dataSiswa as $siswa)
                            <tr>
                                <td>{{ $siswa->name }}</td>
                                <td>{{ $siswa->email }}</td>
                                <td>{{ $siswa->study_level }}</td>
                                <td>{{ $siswa->institution }}</td>
                                <td>{{ \Carbon\Carbon::parse($siswa->birth)->format('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($siswa->created_at)->format('d F Y, H:i') }}</td>

                            </tr>
                        @endforeach
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
                        <a class="page-link"
                            href="{{ route('data.siswa', ['page' => $pagination['page'] - 1]) }}">Previous</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                @endif

                <!-- Page Numbers -->
                @for ($i = 1; $i <= $pagination['total_page']; $i++)
                    <li class="page-item {{ $pagination['page'] == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('data.siswa', ['page' => $i]) }}">{{ $i }}</a>
                    </li>
                @endfor

                <!-- Next Button -->
                @if ($pagination['page'] < $pagination['total_page'])
                    <li class="page-item">
                        <a class="page-link" href="{{ route('data.siswa', ['page' => $pagination['page'] + 1]) }}">Next</a>
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

@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_courses }}</h3>

                        <p>Jumlah Kelas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_bundles }}</h3>

                        <p>Jumlah Bundling</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $total_admins }}</h3>

                        <p>Jumlah Admin</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $total_users }}</h3>

                        <p>Jumlah Siswa</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_instructors }}</h3>

                        <p>Jumlah Pengajar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-8 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Statistik Penjualan
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart"
                                style="position: relative; height: 300px;">
                                <canvas id="salesChart" width="400" height="200"></canvas>
                            </div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-4 connectedSortable">
                <div class="card card-success shadow">
                    <div class="card-header">
                        <h3 class="card-title">Keterangan</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        Total Penjualan : {{$total_sales}}
                    </div>
                    <!-- /.card-body -->
                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->

    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>


    <script>
        // Ambil data dari controller
        const chartData = @json($sales);

        console.log(chartData);

        const labels = [chartData.month]; // Mengambil nama bulan dari data
        const totalSalesData = [chartData.total_sales]; // Mengambil total chartData dari data
        const totalIncomeData = [chartData.total_income]; // Mengambil total income dari data

        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar', // atau 'line', 'pie', tergantung jenis chart yang ingin digunakan
            data: {
                labels: labels,
                datasets: [{
                        label: 'Total Sales',
                        data: totalSalesData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Income',
                        data: totalIncomeData,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection

@extends('layout.adminLayout')
@section('title', $title)

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row g-3">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $total_courses }}</h3>

                        <p>Jumlah Kelas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <a href="{{ route('admin.kelas') }}" class="small-box-footer">Lihat <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
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
                    <a href="{{ route('data.pengajar') }}" class="small-box-footer">Lihat <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_admins }}</h3>

                        <p>Jumlah Admin</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <a href="{{ route('data.admin') }}" class="small-box-footer">Lihat <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_users }}</h3>

                        <p>Jumlah Siswa</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <a href="{{ route('data.siswa') }}" class="small-box-footer">Lihat <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row g-3">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $total_bundles }}</h3>

                        <p>Jumlah Bundling</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <a href="{{ route('admin.bundling') }}" class="small-box-footer">Lihat <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <!-- Total Sales Box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="totalSales">Loading...</h3>
                        <p>Total Penjualan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="{{ route('admin.sales') }}" class="small-box-footer">Lihat <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-5 col-12">
                <!-- Total Income Box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="totalIncome">Loading...</h3>
                        <p>Total Pendapatan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="{{ route('admin.sales') }}" class="small-box-footer">Lihat <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Main row -->
    <div class="row">
        <!-- Right col for few months statistics -->
        <section class="col-lg-8 connectedSortable">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Statistik Penjualan Beberapa Bulan
                    </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="monthRange">Pilih Rentang Bulan:</label>
                        <select id="monthRange" class="form-control" onchange="fetchSalesData(this.value)">
                            <option value="">Pilih Rentang Bulan</option>
                            <option value="6">6 Bulan</option>
                            <option value="12">12 Bulan</option>
                        </select>
                    </div>
                    <div class="chart" style="position: relative; height: auto;">
                        <canvas id="fewmonthChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Right col -->
        <!-- Left col for monthly statistics -->
        <section class="col-lg-4 connectedSortable">
            <!-- Custom tabs (Charts with tabs) -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Statistik Penjualan Per Bulan
                    </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="monthRange">Pilih Bulan:</label>
                        <select id="monthRange" class="form-control" onchange="fetchMonthData(this.value)">
                            <option value="">Pilih Bulan</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="chart" style="position: relative; height: auto;">
                        <canvas id="monthChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>

    <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->

    <!-- ChartJS -->
    {{-- <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        let fewmonthChart;
        const fewmonthChartCanvas = document.getElementById('fewmonthChart');

        let monthChart;
        const monthChartCanvas = document.getElementById('monthChart');

        const monthNames = [
            "Januari", "Februari", "Maret", "April",
            "Mei", "Juni", "Juli", "Agustus",
            "September", "Oktober", "November", "Desember"
        ];


        $(document).ready(function() {
            // Automatically load the chart with 6 months data on page load
            fetchSalesData(6); // Assuming '6' means the first 6 months
            fetchMonthData(10); // Assuming '6' means the first 6 months
        });


        function fetchMonthData(month) {
            // Ensure fewMonths is a valid number
            if (month) {
                $.ajax({
                    url: '{{ route('admin.salesMonth') }}', // Adjust to your route
                    type: 'GET',
                    data: {
                        month: month
                    },
                    success: function(response) {
                        console.log('Canvas:', monthChartCanvas);
                        updateMonthChart(response.months, month);
                        // Check if total_sales exists and is not undefined
                        if (response.months.total_sales !== undefined) {
                            $('#totalSales').html(response.months.total_sales);
                            // Mengambil total_income dari response
                            var totalIncome = response.months.total_income;


                            // Mengformat totalIncome ke format Rupiah tanpa desimal
                            var formattedIncome = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0, // Tidak ada angka desimal
                                maximumFractionDigits: 0 // Tidak ada angka desimal
                            }).format(totalIncome);
                            // Menampilkan formattedIncome di elemen dengan id totalIncome
                            $('#totalIncome').html(formattedIncome);
                        } else {
                            $('#totalSales').html('0');
                            $('#totalIncome').html('Rp 0');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching sales data:', error);
                    }
                });
            }
        }

        function fetchSalesData(fewMonths) {
            // Ensure fewMonths is a valid number
            if (fewMonths) {
                $.ajax({
                    url: '{{ route('admin.sales') }}', // Adjust to your route
                    type: 'GET',
                    data: {
                        few_months: fewMonths
                    },
                    success: function(response) {
                        updateChart(response
                            .total_sales, fewMonths);


                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching sales data:', error);
                    }
                });
            } else {
                // Clear data if no month is selected
                // $('#salesData').html('');
            }
        }

        function updateMonthChart(salesData, month) {
            const totalSales = [salesData.total_sales]; // Ubah menjadi array
            const totalIncome = [salesData.total_income]; // Ubah menjadi array

            console.log(totalSales, totalIncome);

            // Destroy the existing chart if it exists
            if (monthChart) {
                monthChart.destroy();
            }

            // Create the datasets with yAxisID
            const totalSalesDataset = {
                label: 'Penjualan',
                data: totalSales, // Use the total sales from the sales data
                backgroundColor: 'rgba(54, 162, 235, 0.6)', // Customize colors
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                yAxisID: 'y-axis-sales' // yAxisID for total sales
            };

            const totalIncomeDataset = {
                label: 'Pendapatan', // Add another dataset for total_income
                data: totalIncome, // Set the data to the total_income values
                backgroundColor: 'rgba(255, 99, 132, 0.6)', // Different color for clarity
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                yAxisID: 'y-axis-income' // yAxisID for total income
            };

            // Create a new chart with the updated data
            monthChart = new Chart(monthChartCanvas.getContext('2d'), {
                type: 'bar', // Bar chart type
                data: {
                    labels: [monthNames[month - 1]], // Use the month parameter to get the corresponding month name
                    datasets: [totalSalesDataset, totalIncomeDataset] // Combine both datasets
                },
                options: {
                    responsive: true,

                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: `Penjualan Bulan ${[monthNames[month - 1]]} `
                        }
                    }
                },
            });
        }


        // Function to update the chart with the fetched data
        function updateChart(salesData, fewMonths) {

            // Extract months and total_sales from the response
            const months = salesData.map(item => item.month); // Get the 6 months
            const totalSales = salesData.map(item => item.total_sales); // Get the corresponding sales for each month
            const totalIncome = salesData.map(item => item.total_income); // Get the corresponding sales for each month

            console.log(totalSales, totalIncome);

            // Destroy the existing chart if it exists
            if (fewmonthChart) {
                fewmonthChart.destroy();
            }

            // Create the datasets with yAxisID
            const totalSalesDataset = {
                label: 'Total Penjualan',
                data: totalSales, // Use the total sales from the sales data
                backgroundColor: 'rgba(54, 162, 235, 0.6)', // Customize colors
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                yAxisID: 'y-axis-sales' // yAxisID for total sales
            };

            const totalIncomeDataset = {
                label: 'Total Pendapatan', // Add another dataset for total_income
                data: totalIncome, // Set the data to the total_income values
                backgroundColor: 'rgba(255, 99, 132, 0.6)', // Different color for clarity
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                yAxisID: 'y-axis-income' // yAxisID for total income
            };

            // Create a new chart with the updated data
            fewmonthChart = new Chart(fewmonthChartCanvas.getContext('2d'), {
                type: 'bar', // Bar chart type
                data: {
                    labels: months, // Use the months from the sales data
                    datasets: [totalSalesDataset, totalIncomeDataset] // Combine both datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: `Penjualan ${fewMonths} Bulan Terakhir`
                        }
                    }
                },
            });
        }
    </script>

@endsection

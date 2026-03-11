@extends('layout.adminLayout')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0" style="color: #343a40;">Dashboard</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box shadow-sm border-0"
                    style="background: linear-gradient(45deg, #4e73df, #224abe); color: white; border-radius: 15px;">
                    <div class="inner">
                        <h3 class="fw-bold">{{ $total_courses }}</h3>
                        <p>Total Kelas</p>
                    </div>
                    <div class="icon text-white-50">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <a href="{{ route('admin.kelas') }}" class="small-box-footer bg-dark bg-opacity-10 border-0"
                        style="border-radius: 0 0 15px 15px;">
                        Detail Info <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box shadow-sm border-0"
                    style="background: linear-gradient(45deg, #36b9cc, #258391); color: white; border-radius: 15px;">
                    <div class="inner">
                        <h3 class="fw-bold">{{ $total_instructors }}</h3>
                        <p>Total Pengajar</p>
                    </div>
                    <div class="icon text-white-50">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <a href="{{ route('data.pengajar') }}" class="small-box-footer bg-dark bg-opacity-10 border-0"
                        style="border-radius: 0 0 15px 15px;">
                        Detail Info <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box shadow-sm border-0"
                    style="background: linear-gradient(45deg, #f6c23e, #dda20a); color: white; border-radius: 15px;">
                    <div class="inner">
                        <h3 class="fw-bold">{{ $total_admins }}</h3>
                        <p>Admin Sistem</p>
                    </div>
                    <div class="icon text-white-50">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <a href="{{ route('data.admin') }}" class="small-box-footer bg-dark bg-opacity-10 border-0"
                        style="border-radius: 0 0 15px 15px;">
                        Detail Info <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box shadow-sm border-0"
                    style="background: linear-gradient(45deg, #e74a3b, #be2617); color: white; border-radius: 15px;">
                    <div class="inner">
                        <h3 class="fw-bold">{{ $total_users }}</h3>
                        <p>Total Siswa</p>
                    </div>
                    <div class="icon text-white-50">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <a href="{{ route('data.siswa') }}" class="small-box-footer bg-dark bg-opacity-10 border-0"
                        style="border-radius: 0 0 15px 15px;">
                        Detail Info <i class="fas fa-arrow-circle-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="small-box shadow-sm border-0 bg-white"
                    style="border-radius: 15px; border-left: 5px solid #4e73df !important;">
                    <div class="inner text-dark">
                        <h3 class="text-primary">{{ $total_bundles }}</h3>
                        <p class="text-muted fw-bold">Jumlah Bundling</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-layer-group text-light"></i>
                    </div>
                    <a href="{{ route('admin.bundling') }}"
                        class="small-box-footer text-primary border-top py-2 bg-transparent">
                        Lihat Koleksi <i class="fas fa-arrow-right small ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="small-box shadow-sm border-0 bg-white"
                    style="border-radius: 15px; border-left: 5px solid #1cc88a !important;">
                    <div class="inner text-dark">
                        <h3 id="totalSales" class="text-success">...</h3>
                        <p class="text-muted fw-bold">Total Penjualan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart text-light"></i>
                    </div>
                    <a href="{{ route('sales') }}" class="small-box-footer text-success border-top py-2 bg-transparent">
                        Laporan Sales <i class="fas fa-arrow-right small ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="small-box shadow-sm border-0 bg-white"
                    style="border-radius: 15px; border-left: 5px solid #6f42c1 !important;">
                    <div class="inner text-dark">
                        <h3 id="totalIncome" class="text-purple" style="color: #6f42c1;">...</h3>
                        <p class="text-muted fw-bold">Total Pendapatan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-wallet text-light"></i>
                    </div>
                    <a href="{{ route('sales') }}" class="small-box-footer text-purple border-top py-2 bg-transparent"
                        style="color: #6f42c1;">
                        Detail Keuangan <i class="fas fa-arrow-right small ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title fw-bold text-dark">
                            <i class="fas fa-chart-line text-primary mr-2"></i> Tren Penjualan
                        </h3>
                        <div class="card-tools">
                            <select id="monthRange" class="form-control form-control-sm border-0 bg-light"
                                onchange="fetchSalesData(this.value)">
                                <option value="6">6 Bulan Terakhir</option>
                                <option value="12">1 Tahun Terakhir</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="fewmonthChart"
                            style="min-height: 350px; height: 350px; max-height: 350px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3">
                        <h3 class="card-title fw-bold text-dark">
                            <i class="fas fa-chart-pie text-info mr-2"></i> Per Bulan
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <select id="monthRangeSingle" class="form-control bg-light border-0 rounded-pill"
                                onchange="fetchMonthData(this.value)">
                                @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $key => $month)
                                    <option value="{{ $key + 1 }}" {{ $key + 1 == 10 ? 'selected' : '' }}>
                                        {{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                        <canvas id="monthChart"
                            style="min-height: 280px; height: 280px; max-height: 280px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- /.row (main row) -->

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


            // Destroy the existing chart if it exists
            if (monthChart) {
                monthChart.destroy();
            }

            // Contoh untuk totalSalesDataset di dalam updateChart
            const totalSalesDataset = {
                label: 'Total Penjualan',
                data: totalSales,
                backgroundColor: 'rgba(78, 115, 223, 0.8)', // Warna Biru Modern
                borderColor: '#4e73df',
                borderWidth: 1,
                borderRadius: 5, // Membuat batang chart agak bulat
                barPercentage: 0.6,
            };

            const totalIncomeDataset = {
                label: 'Total Pendapatan',
                data: totalIncome,
                backgroundColor: 'rgba(28, 200, 138, 0.8)', // Warna Hijau Modern
                borderColor: '#1cc88a',
                borderWidth: 1,
                borderRadius: 5,
                barPercentage: 0.6,
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


            // Destroy the existing chart if it exists
            if (fewmonthChart) {
                fewmonthChart.destroy();
            }

            // Contoh untuk totalSalesDataset di dalam updateChart
            const totalSalesDataset = {
                label: 'Total Penjualan',
                data: totalSales,
                backgroundColor: 'rgba(78, 115, 223, 0.8)', // Warna Biru Modern
                borderColor: '#4e73df',
                borderWidth: 1,
                borderRadius: 5, // Membuat batang chart agak bulat
                barPercentage: 0.6,
            };

            const totalIncomeDataset = {
                label: 'Total Pendapatan',
                data: totalIncome,
                backgroundColor: 'rgba(28, 200, 138, 0.8)', // Warna Hijau Modern
                borderColor: '#1cc88a',
                borderWidth: 1,
                borderRadius: 5,
                barPercentage: 0.6,
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

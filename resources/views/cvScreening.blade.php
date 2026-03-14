@extends('layout.layout')

@section('content')
    <section class="py-5"
        style="background: linear-gradient(135deg, #f8faff 0%, #e9f0ff 100%); border-radius: 0 0 50px 50px;">
        <div class="container mt-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 mt-3">
                    <h1 class="display-4 fw-bold text-dark mb-3">
                        Dapatkan Pekerjaan Impian dengan <span class="text-primary">Screening CV Berbasis AI!</span>
                    </h1>
                    <p class="lead text-muted mb-4">
                        Jangan biarkan CV Anda terabaikan oleh HRD. Gunakan teknologi AI untuk mengukur kecocokan CV Anda
                        dengan posisi target secara instan dan akurat.
                    </p>

                    <div class="card border-0 shadow-sm p-3 mb-4"
                        style="border-radius: 15px; border-left: 5px solid #0d6efd;">
                        <div class="d-flex align-items-center">
                            <div class="icon-box me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="fas fa-gift fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Promo Pengguna Baru!</h6>
                                <p class="small mb-0 text-muted">Daftar sekarang dan nikmati <strong>2x Free CV
                                        Screening</strong> tanpa biaya tambahan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid d-md-flex gap-3">
                        <a href="/register" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow">
                            Daftar Sekarang — Gratis! <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#cara-kerja" class="btn btn-outline-primary btn-lg rounded-pill px-4 py-3 fw-bold">
                            Lihat Cara Kerja
                        </a>
                    </div>

                    <p class="mt-3 small text-muted">
                        <i class="fas fa-check-circle text-success me-1"></i> Bergabung dengan 10,000+ Analis Kimia lainnya.
                    </p>
                </div>

                <div class="col-lg-6 text-center">
                    <div class="position-relative">
                        <img src="path_ke_gambar_skor_anda.png" class="img-fluid rounded-4 shadow-lg border"
                            alt="Preview Result" style="max-height: 450px; transform: rotate(2deg);">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Mengapa Screening di Akuanalis?</h2>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="p-4 h-100">
                        <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">AI Matching Score</h5>
                        <p class="text-muted small">Ketahui seberapa cocok CV Anda dengan kriteria perusahaan dalam hitungan
                            detik.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 h-100">
                        <i class="fas fa-lightbulb fa-3x text-warning mb-3"></i>
                        <h5 class="fw-bold">Rekomendasi Perbaikan</h5>
                        <p class="text-muted small">Dapatkan saran spesifik per poin untuk meningkatkan kualitas CV Anda
                            secara mendalam.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 h-100">
                        <i class="fas fa-graduation-cap fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">Kursus Relevan</h5>
                        <p class="text-muted small">Kami merekomendasikan kelas tambahan untuk menutupi celah skill Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

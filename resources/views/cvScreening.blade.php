@extends('layout.layout')

@section('content')
<style>
    /* Gradient Text Efek */
    .text-gradient {
        background: linear-gradient(90deg, #0d6efd, #00d2ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Animasi Mengapung untuk Gambar */
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(2deg); }
        50% { transform: translateY(-20px) rotate(1deg); }
    }

    /* Efek Angkat saat Hover */
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 1rem 3rem rgba(13, 110, 253, 0.25) !important;
    }

    .hover-shadow:hover {
        transform: translateY(-10px);
        box-shadow: 0 1.5rem 4rem rgba(0,0,0,0.1) !important;
        background-color: #fff;
    }

    /* Transisi Halus */
    .transition-all {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
<section class="py-5 position-relative overflow-hidden"
    style="background: radial-gradient(circle at top right, #f0f5ff, #ffffff); border-radius: 0 0 60px 60px;">

    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25" style="background-image: radial-gradient(#0d6efd 0.5px, transparent 0.5px); background-size: 20px 20px;"></div>

    <div class="container position-relative mt-lg-5 py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3 fw-bold shadow-sm">
                    <i class="bi bi-stars me-1"></i> AI-Powered Career Booster
                </div>
                <h1 class="display-4 fw-bolder text-dark mb-4 lh-sm">
                    Dapatkan Pekerjaan Impian dengan <span class="text-primary text-gradient">Screening CV AI</span>
                </h1>
                <p class="lead text-secondary mb-4 pb-2" style="font-weight: 400;">
                    Jangan biarkan CV Anda terabaikan. Gunakan teknologi AI untuk membedah kecocokan profil Anda dengan standar HRD perusahaan secara instan.
                </p>

                <div class="card border-0 shadow-sm p-3 mb-5 rounded-4 bg-white border-start border-primary border-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary text-white rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;">
                            <i class="bi bi-gift-fill fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="fw-bold mb-0">Promo Pengguna Baru!</h6>
                            <p class="small mb-0 text-muted">Daftar sekarang dan nikmati <span class="text-primary fw-bold">2x Free CV Screening</span>.</p>
                        </div>
                    </div>
                </div>

                <div class="d-grid d-md-flex gap-3 align-items-center">
                    <a href="/register" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg hover-lift">
                        Mulai Gratis Sekarang <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    <div class="ms-md-2">
                        <div class="d-flex align-items-center">
                            <div class="avatar-group d-flex me-2">
                                <i class="bi bi-people-fill text-primary fs-4"></i>
                            </div>
                            <span class="small fw-bold text-dark">10,000+ Analis Kimia Terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 text-center position-relative">
                <div class="position-absolute top-50 start-50 translate-middle bg-primary opacity-10 rounded-circle" style="width: 400px; height: 400px; filter: blur(80px);"></div>

                <div class="image-wrapper p-2 bg-white shadow-lg rounded-4 border animate-float">
                    <img src="assets/img/screening.png" class="img-fluid rounded-3" alt="AI Result Preview">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container py-lg-5">
        <div class="text-center mb-5 pb-lg-3">
            <h2 class="fw-bolder display-5 mb-3">Mengapa di Akuanalis?</h2>
            <div class="mx-auto bg-primary rounded-pill mb-4" style="width: 60px; height: 5px;"></div>
            <p class="text-muted mx-auto fs-5" style="max-width: 700px;">
                Kami membantu menjembatani celah antara CV Anda dengan kebutuhan industri kimia global.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            @php
                $features = [
                    ['icon' => 'bi-graph-up-arrow', 'color' => 'primary', 'title' => 'AI Matching Score', 'desc' => 'Ketahui seberapa cocok CV Anda dengan kriteria perusahaan dalam hitungan detik secara akurat.'],
                    ['icon' => 'bi-lightbulb-fill', 'color' => 'warning', 'title' => 'Rekomendasi Perbaikan', 'desc' => 'Dapatkan saran spesifik per poin untuk meningkatkan kualitas CV Anda secara mendalam.'],
                    ['icon' => 'bi-mortarboard-fill', 'color' => 'success', 'title' => 'Kursus Relevan', 'desc' => 'Kami merekomendasikan kelas tambahan untuk menutupi celah skill Anda agar sesuai target industri.']
                ];
            @endphp

            @foreach($features as $f)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-5 p-4 transition-all hover-shadow">
                    <div class="card-body text-center">
                        <div class="icon-square bg-{{ $f['color'] }}-subtle text-{{ $f['color'] }} mb-4 mx-auto d-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px; border-radius: 20px;">
                            <i class="bi {{ $f['icon'] }} fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">{{ $f['title'] }}</h5>
                        <p class="text-muted small lh-lg mb-0">{{ $f['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

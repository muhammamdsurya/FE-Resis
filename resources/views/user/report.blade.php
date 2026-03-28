@extends('layout.userLayout')

@section('content')
    <div class="container py-5">
        {{-- Header Navigation --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('resume.history') }}" class="btn btn-white shadow-sm border-0 btn-sm rounded-pill px-3">
                <i class="fas fa-arrow-left me-2 text-primary"></i> Kembali ke Riwayat
            </a>
            <div class="text-muted small">
                Dianalisa Tanggal : <span
                    class="fw-bold">{{ \Carbon\Carbon::parse($data['created_at'])->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        {{-- Top Section: Analysis Result --}}
        <div class="row g-4 mb-5">
            {{-- Skor Box --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm overflow-hidden h-100"
                    style="border-radius: 24px; background: linear-gradient(145deg, #ffffff, #f8f9ff);">
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-center">
                        <h6 class="text-muted fw-bold small text-uppercase tracking-wider">Skor Kesesuaian</h6>
                        <div class="py-4">
                            <div class="position-relative d-inline-block">
                                <h1 class="display-2 fw-bold text-primary mb-0" style="letter-spacing: -2px;">
                                    {{ $data['match_percentage'] }}%</h1>
                                <div class="progress mt-2"
                                    style="height: 6px; border-radius: 10px; background-color: rgba(13, 110, 253, 0.1);">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                        style="width: {{ $data['match_percentage'] }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-4 p-3 shadow-sm border border-light">
                            <div class="text-start mb-3">
                                <p class="mb-1 small text-muted font-monospace">TARGET POSISI</p>
                                <h6 class="fw-bold text-dark mb-0">
                                    @php
                                        // Mengambil apapun setelah 'Posisi:' sampai bertemu titik yang diikuti kata 'Berikut'
                                        preg_match(
                                            '/Posisi:\s*(.*?)\.\s*Berikut/i',
                                            $data['job_description'],
                                            $matches,
                                        );
                                        $position = $matches[1] ?? 'Posisi Tidak Ditemukan';
                                    @endphp
                                    {{ $position }}
                                </h6>
                            </div>
                            <div class="text-start">
                                <p class="mb-1 small text-muted font-monospace">PENGALAMAN</p>
                                <h6 class="fw-bold text-primary mb-0"><i class="fas fa-history me-1"></i>
                                    {{ Str::replace('Years', 'Tahun', $data['experience_years']) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Analisis --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 h-100" style="border-radius: 24px;">
                    <h4 class="fw-bold mb-4 d-flex align-items-center">
                        <span class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="fas fa-file-invoice text-primary"></i>
                        </span>
                        Laporan Analisis Mendalam
                    </h4>

                    <div class="row g-4">
                        {{-- Strength --}}
                        <div class="col-md-6">
                            <div class="p-3 rounded-4 h-100" style="background-color: #f6fff9; border: 1px solid #e1f7e8;">
                                <h6 class="fw-bold text-success d-flex align-items-center mb-3">
                                    <i class="fas fa-check-circle me-2"></i> Kekuatan Utama
                                </h6>
                                <p class="small text-dark lh-base mb-0">{{ $data['strength'] }}</p>
                            </div>
                        </div>

                        {{-- Recommendation --}}
                        <div class="col-md-6">
                            <div class="p-3 rounded-4 h-100" style="background-color: #f4f9ff; border: 1px solid #e2efff;">
                                <h6 class="fw-bold text-primary d-flex align-items-center mb-3">
                                    <i class="fas fa-lightbulb me-2"></i> Rekomendasi AI
                                </h6>
                                <p class="small text-dark lh-base mb-0">{{ $data['recommendation'] }}</p>
                            </div>
                        </div>

                        {{-- Improvement --}}
                        <div class="col-12">
                            <div class="p-3 rounded-4" style="background-color: #fffbf2; border: 1px solid #fef0d4;">
                                <h6 class="fw-bold text-warning d-flex align-items-center mb-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Poin Perbaikan
                                </h6>
                                <div class="row">
                                    @if (is_array($data['improvement_points']))
                                        @foreach (array_chunk($data['improvement_points'], ceil(count($data['improvement_points']) / 2)) as $chunk)
                                            <div class="col-md-6">
                                                <ul class="list-group list-group-flush bg-transparent">
                                                    @foreach ($chunk as $point)
                                                        <li
                                                            class="list-group-item bg-transparent border-0 ps-0 py-1 small text-dark d-flex align-items-start">
                                                            <i class="fas fa-arrow-right text-warning me-2 mt-1"
                                                                style="font-size: 10px;"></i>
                                                            <span>{{ $point }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 small text-dark ps-4">{{ $data['improvement_points'] }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Section: Full Width Courses --}}
        <div class="pt-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold m-0"><i class="fas fa-graduation-cap me-2 text-info"></i> Rekomendasi Kursus Untuk Anda
                </h4>
                <span class="badge bg-light text-dark rounded-pill px-3 py-2 border">Disesuaikan dengan profil Anda</span>
            </div>

            <div class="row g-4">
                @forelse($courses as $item)
                    @php $c = $item['course']; @endphp
                    <div class="col-md-6 col-xl-3">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all"
                            style="border-radius: 20px; transition: transform 0.2s;">
                            <div class="position-relative">
                                <img src="{{ $c['thumbnail_image'] }}" class="card-img-top" alt="thumbnail"
                                    style="height: 160px; object-fit: cover; border-radius: 20px 20px 0 0;">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-white text-dark shadow-sm rounded-pill fw-bold">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        {{ $c['rating'] > 0 ? $c['rating'] : 'New' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-3 d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-normal"
                                        style="font-size: 10px;">
                                        {{ $item['course_category']['name'] }}
                                    </span>
                                </div>
                                <h6 class="fw-bold text-dark mb-3 flex-grow-1" style="line-height: 1.5; font-size: 14px;">
                                    {{ Str::limit($c['name'], 60) }}
                                </h6>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ $item['instructor']['photo_profile'] }}" class="rounded-circle me-2"
                                        width="24" height="24" style="object-fit: cover;">
                                    <span
                                        class="text-muted small text-truncate">{{ $item['instructor']['full_name'] }}</span>
                                </div>
                                <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 10px;">Investasi Ilmu</small>
                                        <span
                                            class="fw-bold text-primary">Rp{{ number_format($c['price'], 0, ',', '.') }}</span>
                                    </div>
                                    <a href="/detail-kelas/{{ $c['id'] }}"
                                        class="btn btn-primary rounded-pill px-4 shadow-sm btn-sm">
                                        Daftar <i class="fas fa-arrow-right ms-1" style="font-size: 10px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 bg-light rounded-4 border border-dashed">
                        <i class="fas fa-search-minus mb-3 text-muted display-4"></i>
                        <p class="text-muted">Belum ada kursus yang spesifik untuk kriteria perbaikan Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .1) !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }
    </style>
@endsection

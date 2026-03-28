@extends('layout.userLayout')

@section('content')
    <div class="container-fluid p-4" style="background-color: #f4f6f9;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold m-0" style="color: #343a40;">AI CV Screening</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="background: transparent; padding: 0; font-size: 0.9rem;">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">CV Screening</li>
                    </ol>
                </nav>
            </div>

            <div>
                <a href="{{ route('resume.history') }}" class="btn btn-outline-primary px-4 shadow-sm" ...>
                    <i class="fas fa-history me-2"></i> Riwayat Screening
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4"><i class="fas fa-file-upload text-primary me-2"></i> Detail CV</h5>

                        <form id="analyzeForm" enctype="multipart/form-data">
                            @csrf

                            <div class="upload-area border border-2 border-dashed rounded-3 p-5 text-center mb-4"
                                style="border-style: dashed !important; border-color: #dee2e6 !important; background: #fafafa; cursor: pointer;"
                                onclick="document.getElementById('cvInput').click();">
                                <div class="mb-3">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
                                </div>
                                <h6 class="fw-bold">Klik untuk upload CV atau tempel dan taruh</h6>
                                <p class="text-muted small">PDF max 2mb</p>
                                <input type="file" id="cvInput" name="resume" accept=".pdf" style="display: none;">
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Job Position</label>
                                    <input type="text" name="job_position" class="form-control"
                                        placeholder="Analis Kimia" style="border-radius: 8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Pengalaman Dibutuhkan</label>
                                    <select class="form-select" name="experience_years" style="border-radius: 8px;">
                                        <option>1-2 Years</option>
                                        <option>3-5 Years</option>
                                        <option>5++ Years</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-muted">Deskripsi pekerjaan</label>
                                    <textarea class="form-control" name="job_description" rows="11"
                                        placeholder="PT XYZ sedang mencari kandidat dengan kriteria..." style="border-radius: 8px;"></textarea>
                                </div>
                            </div>
                            <div class="text-center w-100">
                                <button type="submit" id="btnAnalyze"
                                    class="btn btn-primary px-5 py-3 rounded-4 fw-bold shadow w-100 mb-2">
                                    Analisis CV
                                </button>
                                <div class="text-muted small">
                                    <i class="fas fa-bolt text-warning me-1"></i>
                                    Kamu Punya <strong><span id="creditCount">...</span>x analisis</strong>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <div class="card-body p-4 text-center">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold m-0">CV Preview</h6>
                            <a href="#" id="fullScreenBtn" class="small text-primary text-decoration-none"
                                style="display: none;">Full Screen</a>
                        </div>

                        <div id="previewContainer"
                            class="bg-light rounded p-2 mb-3 d-flex align-items-center justify-content-center"
                            style="min-height: 300px; border: 1px solid #eee;">
                            <div id="placeholderText" class="text-muted small">
                                <i class="fas fa-file-pdf fa-3x mb-2 d-block opacity-25"></i>
                                Pratinjau CV akan muncul di sini
                            </div>
                            <iframe id="pdfViewer" style="width: 100%; height: 350px; display: none;"
                                frameborder="0"></iframe>
                        </div>

                        <div class="text-start">
                            <h6 class="fw-bold mb-1" id="fileNameDisplay">Belum ada file dipilih</h6>
                            <small class="text-muted" id="fileDateDisplay">-</small>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg text-white mb-4"
                    style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 16px; overflow: hidden;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 35px; height: 35px;">
                                    <i class="fas fa-chart-pie text-white small"></i>
                                </div>
                                <h6 class="fw-bold m-0 small text-uppercase tracking-wider">Hasil Analisis AI</h6>
                            </div>
                            <span id="match-status" class="badge rounded-pill bg-white text-primary px-3 py-2 fw-bold"
                                style="font-size: 0.7rem;">
                                WAITING
                            </span>
                        </div>

                        <div class="text-center py-2">
                            <div class="position-relative d-inline-flex align-items-center justify-content-center">
                                <svg width="140" height="140" viewBox="0 0 140 140">
                                    <circle cx="70" cy="70" r="60" stroke="rgba(255,255,255,0.2)"
                                        stroke-width="10" fill="none" />
                                    <circle id="progress-bar" cx="70" cy="70" r="60" stroke="#ffffff"
                                        stroke-width="10" fill="none" stroke-dasharray="377" stroke-dashoffset="377"
                                        stroke-linecap="round"
                                        style="transition: stroke-dashoffset 1.5s ease-in-out; transform: rotate(-90deg); transform-origin: center;" />
                                </svg>

                                <div class="position-absolute text-center">
                                    <h2 id="text-percentage" class="fw-bold m-0" style="font-size: 2rem;">0%</h2>
                                    <small class="opacity-75 fw-bold" style="font-size: 0.6rem;">MATCH SCORE</small>
                                </div>
                            </div>
                        </div>

                        <div id="text-summary" class="mt-3 p-3 bg-white text-light bg-opacity-10 rounded-3 text-center"
                            style="font-size: 0.85rem; border: 1px solid rgba(255,255,255,0.1);">
                            Silakan unggah dan analisis CV Anda untuk melihat skor kecocokan.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100"
                    style="border-radius: 12px; border-left: 4px solid #28a745 !important;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-success mb-2 small"><i class="fas fa-check-circle me-1"></i> Key Strength
                        </h6>
                        <p class="small text-muted mb-0" id="text-strength">Masukan CV Terlebih dahulu...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100"
                    style="border-radius: 12px; border-left: 4px solid #007bff !important;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-primary mb-2 small"><i class="fas fa-lightbulb me-1"></i> Recommendation
                        </h6>
                        <p class="small text-muted mb-0" id="text-recommendation">Masukan CV Terlebih dahulu...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100"
                    style="border-radius: 12px; border-left: 4px solid #ffc107 !important;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-warning mb-2 small"><i class="fas fa-exclamation-triangle me-1"></i>
                            Improvement Point</h6>
                        <p class="small text-muted mb-0" id="text-improvement">Masukan CV Terlebih dahulu...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function refreshCredits() {
            fetch("{{ route('credits.get') }}")
                .then(res => res.json())
                .then(data => {
                    document.getElementById('creditCount').innerText = data.credits || 0;
                });
        }
        refreshCredits();
        document.getElementById('cvInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const pdfViewer = document.getElementById('pdfViewer');
            const placeholderText = document.getElementById('placeholderText');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const fileDateDisplay = document.getElementById('fileDateDisplay');
            const fullScreenBtn = document.getElementById('fullScreenBtn');

            if (file) {
                // Validasi sederhana jika bukan PDF (opsional)
                if (file.type !== 'application/pdf') {
                    alert('Mohon upload file berformat PDF untuk melihat pratinjau.');
                    return;
                }

                // Membaca file untuk pratinjau
                const fileURL = URL.createObjectURL(file);

                // Tampilkan Iframe, Sembunyikan Placeholder
                pdfViewer.src = fileURL;
                pdfViewer.style.display = 'block';
                placeholderText.style.display = 'none';
                fullScreenBtn.style.display = 'block';
                fullScreenBtn.href = fileURL;
                fullScreenBtn.target = '_blank';

                // Update Info File
                fileNameDisplay.innerText = file.name;
                const now = new Date();
                fileDateDisplay.innerText = "Uploaded: " + now.getHours() + ":" + now.getMinutes() + " Just now";
            }
        });

        // Fitur Drag and Drop (Opsional tapi keren)
        const uploadArea = document.querySelector('.upload-area');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        uploadArea.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            document.getElementById('cvInput').files = files;
            // Trigger change event manual
            document.getElementById('cvInput').dispatchEvent(new Event('change'));
        });

        document.getElementById('analyzeForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let submitBtn = e.target.querySelector('button[type="submit"]');

            // --- LOGIKA PROTEKSI KREDIT ---
            const creditCountElement = document.getElementById('creditCount');
            const currentCredits = parseInt(creditCountElement.innerText) || 0;

            if (currentCredits <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Maaf, Token Habis!',
                    text: 'Kamu tidak memiliki kuota analisis tersisa. Silakan top-up atau tunggu besok!',
                    confirmButtonText: 'Top Up Sekarang',
                    confirmButtonColor: '#0d6efd',
                    showCancelButton: true,
                    cancelButtonText: 'Tutup'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/pricing'; // Sesuaikan route pricing Anda
                    }
                });
                return; // Menghentikan eksekusi, tidak jadi fetch
            }
            // ------------------------------

            // Validasi input form
            const jobPosition = formData.get('job_position');
            const originalDescription = formData.get('job_description');

            if (!jobPosition || !originalDescription) {
                Swal.fire('Oops!', 'Mohon isi Jabatan dan Deskripsi Pekerjaan!', 'warning');
                return;
            }

            // Efek Loading
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Analyzing...';
            submitBtn.disabled = true;

            // Gabungkan teks
            const combinedDescription =
                `Posisi: ${jobPosition}. Berikut adalah deskripsi pekerjaan: ${originalDescription}`;
            formData.set('job_description', combinedDescription);

            fetch("{{ route('resume.analyze') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    submitBtn.innerHTML = 'Analyze';
                    submitBtn.disabled = false;

                    if (data.success) {
                        // Panggil fungsi refresh kredit (jika ada di global scope)
                        if (typeof refreshCredits === "function") refreshCredits();

                        // Update UI Result (Progress Circle, Text, dll)
                        const percentage = data.match_percentage;
                        const circle = document.getElementById('progress-bar');
                        const statusBadge = document.getElementById('match-status');

                        // Hitung Dash Offset
                        const offset = 377 - (377 * percentage / 100);
                        circle.style.strokeDashoffset = offset;

                        document.getElementById('text-percentage').innerText = percentage + '%';
                        document.getElementById('text-strength').innerText = data.strength;
                        document.getElementById('text-recommendation').innerText = data.recommendation;
                        document.getElementById('text-improvement').innerText = data.improvement_points;
                        document.getElementById('text-summary').innerText = data.recommendation;

                        // Status Color Logic
                        if (percentage >= 80) {
                            statusBadge.innerText = "HIGH MATCH";
                            statusBadge.className =
                            "badge rounded-pill bg-success text-white px-3 py-2 fw-bold";
                        } else if (percentage >= 50) {
                            statusBadge.innerText = "MEDIUM MATCH";
                            statusBadge.className = "badge rounded-pill bg-warning text-dark px-3 py-2 fw-bold";
                        } else {
                            statusBadge.innerText = "LOW MATCH";
                            statusBadge.className = "badge rounded-pill bg-danger text-white px-3 py-2 fw-bold";
                        }

                        Swal.fire('Berhasil!', 'Silahkan cek detail di riwayat screening.', 'success');

                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire('Error', 'Terjadi kesalahan sistem saat analisis.', 'error');
                    submitBtn.innerHTML = 'Analyze';
                    submitBtn.disabled = false;
                });
        });
    </script>
@endsection

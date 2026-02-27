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
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4"><i class="fas fa-file-upload text-primary me-2"></i> Detail CV</h5>

                        <div class="upload-area border border-2 border-dashed rounded-3 p-5 text-center mb-4"
                            style="border-style: dashed !important; border-color: #dee2e6 !important; background: #fafafa; cursor: pointer;"
                            onclick="document.getElementById('cvInput').click();">
                            <div class="mb-3">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary"></i>
                            </div>
                            <h6 class="fw-bold">Klik untuk upload CV atau tempel dan taruh</h6>
                            <p class="text-muted small">PDF max 2mb</p>
                            <input type="file" id="cvInput" name="cv_file" accept=".pdf" style="display: none;">
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Job Position</label>
                                <input type="text" class="form-control" placeholder="Senior Frontend Engineer"
                                    style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Pengalaman Dibutuhkan</label>
                                <select class="form-select" style="border-radius: 8px;">
                                    <option>1-2 Years</option>
                                    <option>3-5 Years</option>
                                    <option>5++ Years</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Deskripsi pekerjaan</label>
                                <textarea class="form-control" rows="4" placeholder="PT XYZ sedang mencari kandidat dengan kriteria..."
                                    style="border-radius: 8px;"></textarea>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary px-4 py-2 flex-grow-1 fw-bold"
                                style="border-radius: 8px;">Analyze</button>
                            <button class="btn btn-outline-warning px-4 py-2 fw-bold" style="border-radius: 8px;">Free 2x
                                Analyze</button>
                        </div>

                        <hr class="my-5">

                        <div class="text-center">
                            <p class="text-muted fw-bold small mb-3">HASIL KECOCOKAN</p>
                            <div class="position-relative d-inline-block">
                                <div class="progress-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                    style="width: 120px; height: 120px; border: 8px solid #e9ecef; border-top: 8px solid #007bff; border-radius: 50%;">
                                    <div class="text-center">
                                        <span class="h3 fw-bold m-0 d-block">85%</span>
                                        <small class="text-primary fw-bold" style="font-size: 0.6rem;">HIGH MATCH</small>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted small mx-auto" style="max-width: 400px;">
                                The candidate's profile is highly compatible with the Senior Frontend Engineer role based on
                                technical skills and experience depth.
                            </p>
                        </div>
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

                <div class="card border-0 text-white mb-4"
                    style="background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 12px;">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-25 rounded p-2">
                            <i class="fas fa-sparkles text-white"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold m-0 small">AI Recommendation</h6>
                            <p class="m-0" style="font-size: 0.75rem;">This candidate ranks in the top 5% of all
                                applicants for technical compatibility.</p>
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
                        <p class="small text-muted mb-0">Strong proficiency in React Ecosystem (Hooks, Redux, Context API)
                            shown in 3 previous roles.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100"
                    style="border-radius: 12px; border-left: 4px solid #007bff !important;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-primary mb-2 small"><i class="fas fa-lightbulb me-1"></i> Recommendation
                        </h6>
                        <p class="small text-muted mb-0">Candidate would excel in a team leading environment given their
                            mentorship experience.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100"
                    style="border-radius: 12px; border-left: 4px solid #ffc107 !important;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold text-warning mb-2 small"><i class="fas fa-exclamation-triangle me-1"></i>
                            Improvement Point</h6>
                        <p class="small text-muted mb-0">Lacks formal experience with Next.js which is mentioned as a
                            'nice-to-have' in JD.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
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

    function preventDefaults (e) {
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
</script>
@endsection

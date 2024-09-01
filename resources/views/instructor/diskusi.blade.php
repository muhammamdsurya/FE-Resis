@extends('layout.InstLayout')
@section('title', $title)

@section('filter')
    <!-- Filter Dropdown -->
    <div class="filter-dropdown d-md-inline-block ms-md-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Filter
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">Semua</a></li>
                <li><a class="dropdown-item" href="#">Terbaru</a></li>
                <li><a class="dropdown-item" href="#">Diskusi Saya</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')

<style>
     .post, .comment {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .comment {
            margin-left: 20px;
            background-color: #ffffff;
        }
        .filter-btn {
            margin-bottom: 15px;
        }
        .comment-form, .post-form {
            margin-bottom: 15px;
        }
</style>
<div class="container-fluid">
    <div class="row">
        <!-- Kolom Diskusi -->
        <div class="col-12 col-md-9">
            <div class="post-form">
                <div class="d-flex">
                    <img src="{{ asset ('assets/img/testimonials/testimonials-1.jpg')}}" width=50 height=50 class="rounded-circle mr-3" alt="User">
                    <div class="w-100">
                        <textarea class="form-control" rows="3" placeholder="Tulis postingan baru..."></textarea>
                        <button class="btn btn-primary mt-2">Kirim Postingan</button>
                    </div>
                </div>
            </div>

            <!-- Daftar Postingan -->
            <div id="posts">
                <div class="post">
                    <div class="d-flex">
                        <img src="{{ asset ('assets/img/testimonials/testimonials-1.jpg')}}" width=50 height=50 class="rounded-circle mr-3" alt="User">
                        <div>
                            <h5 class="mb-1">Nama User</h5>
                            <p>Ini adalah isi postingan. Klik untuk melihat komentar.</p>
                            <small>10 Komentar</small>
                        </div>
                    </div>
                </div>

                <!-- Komentar (diungkapkan saat postingan diklik) -->
                <div id="comments" style="display:none;">
                    <div class="comment ml-5">
                        <div class="d-flex">
                            <img src="{{ asset ('assets/img/testimonials/testimonials-1.jpg')}}" width=50 height=50 class="rounded-circle mr-3" alt="User">
                            <div>
                                <h6>Nama User</h6>
                                <p>Ini adalah komentar.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Tambahkan lebih banyak komentar di sini -->

                    <!-- Formulir Komentar -->
                    <div class="comment-form">
                        <div class="d-flex">
                            <img src="{{ asset ('assets/img/testimonials/testimonials-1.jpg')}}" width=50 height=50 class="rounded-circle mr-3" alt="User">
                            <div class="w-100">
                                <textarea class="form-control" rows="3" placeholder="Tulis komentar..."></textarea>
                                <button class="btn btn-primary mt-2">Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.querySelectorAll('.post').forEach(post => {
        post.addEventListener('click', () => {
            const comments = document.getElementById('comments');
            comments.style.display = comments.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>
@endsection

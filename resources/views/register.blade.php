<x-auth-layout>
    <div class="login">
        <div class="container d-flex align-items-center justify-content-center min-vh-100 z-index-99">
            <div class="container bg-light">
                <div class="row d-flex justify-content-center align-items-center shadow py-3">

                    <div class="col-md-5 col-lg-5 ">
                        <form>
                            <h3 class="text-center mb-3">Registrasi</h3>
                            <!-- Name input -->
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Nama Lengkap</label>
                                <p class="small">Masukan nama lengkap</p>
                            </div>

                            <!-- Email input -->
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Email</label>
                                <p class="small">Gunakan alamat email aktif anda</p>
                            </div>

                            <!-- Password input -->
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                <p class="small">Gunakan minimal 8 karakter dengan kombinasi huruf & angka</p>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="button" class="btn btn-primary w-100">Registrasi</button>

                                <div class="d-flex align-items-center my-2">
                                    <div class="flex-grow-1 border-top" style="border-color: #ccc;"></div>
                                    <span class="mx-2">atau</span>
                                    <div class="flex-grow-1 border-top" style="border-color: #ccc;"></div>
                                </div>

                                <button type="button" class="btn btn-light w-100"><i class="bi bi-google mx-3"></i>Daftar dengan google</button>

                                <p class="small mt-3 pt-1 mb-0">Sudah punya akun? <a href="/login" class="link-primary">Login</a></p>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5 col-lg-5">
                        <img src="assets/img/hero-img.png" class="img-fluid d-none d-md-block mx-auto" style="width: 20rem;" alt="Sample image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>

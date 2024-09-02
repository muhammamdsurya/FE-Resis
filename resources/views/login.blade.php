@extends('layout.authLayout')
@section('content')
    <div class="login">
        <div class="container d-flex align-items-center justify-content-center min-vh-100 z-index-99">
            <div class="container bg-light">
                <div class="row d-flex justify-content-center align-items-center shadow py-3">
                    <div class="col-md-5 col-lg-5">
                        <img src="assets/img/logo.png" class="img-fluid d-none d-md-block" style="width: 20rem;"
                            alt="Sample image">
                    </div>

                    <div class="col-md-5 col-lg-5 ">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <h3 class="text-center mb-3">Login</h3>
                            <!-- Email input -->
                            <!-- Input field untuk email -->
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="floatingInput" placeholder="name@example.com" name="email"
                                    value="{{ old('email') }}">
                                <label for="floatingInput">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Input field untuk password -->
                            <div class="form-floating">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="floatingPassword" placeholder="Password" name="password">
                                <label for="floatingPassword">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                               <!-- <div class="form-check mb-0">
                                    <input class="form-check-input me-2" type="checkbox" value=""
                                        id="form2Example3" />
                                    <label class="form-check-label" for="form2Example3">
                                        Ingat saya
                                    </label>
                                </div> -->
                                <a href="#!" class="text-body link-primary">Lupa Password?</a>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" class="btn btn-primary w-100">Login</button>

                                <div class="d-flex align-items-center my-4">
                                    <div class="flex-grow-1 border-top" style="border-color: #ccc;"></div>
                                    <span class="mx-2">atau</span>
                                    <div class="flex-grow-1 border-top" style="border-color: #ccc;"></div>
                                </div>

                                <a href="{{ route('login.google') }}" class="btn btn-light w-100"><i class="bi bi-google mx-3"></i>Masuk
                                    dengan google</a>

                                <p class="small mt-3 pt-1 mb-0">belum punya akun? <a href="/register"
                                        class="link-primary">Daftar sekarang</a></p>
                                <a href="/terms" class="small mb-1 ">*Syarat & Ketentuan</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

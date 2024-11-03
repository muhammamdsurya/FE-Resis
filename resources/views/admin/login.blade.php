@extends('layout.authLayout')

@section('content')
    <div class="login">
        <div class="container d-flex align-items-center justify-content-center min-vh-100 z-index-99">
            <div class="container bg-light col-lg-10">
                <div class="row d-flex justify-content-center align-items-center shadow py-3">
                    <div class="col-md-5 col-lg-5">
                        <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid d-none d-md-block" style="width: 20rem;"
                            alt="Sample image">
                    </div>

                    <div class="col-md-5 col-lg-5 ">
                        <form method="POST" action="{{ route('login.admin') }}">
                            @csrf
                            <h3 class="text-center mb-3">Admin Login</h3>
                            <!-- Display error message -->
                            @if (session('error'))
                                <div id="alert-message" class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
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

                                <a href="{{ route('reset.password.public') }}" class="text-body link-primary">Lupa
                                    Password?</a>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" class="btn btn-primary w-100">Login</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

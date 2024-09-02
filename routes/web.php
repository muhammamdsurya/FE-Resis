<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegisController;
use App\Http\Controllers\InstructorController;

// Rute standar
Route::redirect('/', '/beranda');
Route::get('/', function () {
    return view('welcome');
})->name('beranda');

Route::get('/kelas', function () {
    return view('kelas');
})->name('kelas');

Route::get('/detail-kelas', function () {
    return view('detailKelas');
})->name('detail-kelas');

Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');


Route::middleware(['apicookiehandler'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



// Grup rute untuk rute-rute yang terkait dengan admin

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboardAdmin');
    Route::get('/kelas', [AdminController::class, 'kelas'])->name('kelas');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('/bundling', [AdminController::class, 'bundling'])->name('bundling');
    Route::get('/sales', [AdminController::class, 'sales'])->name('sales');
    Route::get('/data-admin', [AdminController::class, 'dataAdmin'])->name('data-admin');
    Route::get('/data-pengajar', [AdminController::class, 'dataPengajar'])->name('data-pengajar');
    Route::get('/data-siswa', [AdminController::class, 'dataSiswa'])->name('data-siswa');
    // Tambahkan rute-rute lain untuk admin di sini

    Route::post('/kelas', [AdminController::class, 'jenjang'])->name('jenjang.post');

});


// Grup rute untuk rute-rute yang terkait dengan admin
Route::middleware(['apicookiehandler', 'whoami'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::get('/kelas', [UserController::class, 'kelas'])->name('kelas');
        Route::get('/transaksi', [UserController::class, 'transaksi'])->name('transaksi');
        Route::get('/materi', [UserController::class, 'materi'])->name('materi');
        Route::get('/diskusi', [UserController::class, 'diskusi'])->name('diskusi');
    });
});

Route::prefix('instructor')->group(function () {
    Route::get('/dashboard', [InstructorController::class, 'dashboard'])->name('dashboard');
    Route::get('/kelas', [InstructorController::class, 'kelas'])->name('kelas');
    Route::get('/profile', [InstructorController::class, 'profile'])->name('profile');
    Route::get('/diskusi', [InstructorController::class, 'diskusi'])->name('diskusi');

});

// Rute untuk login pengguna biasa
Route::prefix('')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login'); // Menampilkan form login
    Route::post('/login', [AuthController::class, 'login']); // Proses login user
    // for google login
    Route::get('/login/google', [AuthController::class, 'handleGoogleOauth'])->name('login.google');
    Route::get('/register/google', [AuthController::class, 'handleGoogleOauth'])->name('register.google');
    Route::get('/auth/google/login', [AuthController::class, 'handleGoogleCallback']);
});

// Rute untuk login admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdmin'])->name('loginAdmin'); // Menampilkan form login admin
    Route::post('/login', [AuthController::class, 'loginAdmin']); // Proses login admin
});

// Rute untuk login instrutor
Route::prefix('instructor')->group(function () {
    Route::get('/login', [AuthController::class, 'showInstructor'])->name('loginInstructor'); // Menampilkan form login admin
    Route::post('/login', [AuthController::class, 'loginInstructor']); // Proses login admin
});

Route::prefix('')->group(function () {
    Route::get('/register', [RegisController::class, 'show'])->name('show'); // Menampilkan form registrasi
    Route::post('/register', [RegisController::class, 'store'])->name('register'); // Proses registrasi user
});

Route::post('/activate', [AuthController::class, 'activation'])->name('activate.post');
Route::get('/activate', [AuthController::class, 'activate'])->name('activate');

Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');


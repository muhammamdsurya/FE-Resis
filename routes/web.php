<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\courseContentController;
use App\Http\Controllers\RegisController;
use App\Http\Controllers\courseController;
use App\Http\Controllers\courseForumController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\publicController;
use App\Http\Controllers\transactionController;
use App\Http\Controllers\userCourseController;

// Rute standar
Route::redirect('/', '/beranda');
Route::get('/', function () {
    return view('welcome');
})->name('beranda');

// Route::get('/test', [transactionController::class, 'helo'])->name('kelas'); testing, nanti di awasin
Route::get('/kelas', [publicController::class, 'kelas'])->name('kelas');
Route::get('/detail-kelas/{courseId}', [publicController::class, 'detailKelas'])->name('detail.kelas');


Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy-policy', function () {
    return view('policy');
})->name('policy');



// Grup rute untuk rute-rute yang terkait dengan admin

Route::prefix('admin')->middleware(['whoami:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    //course
    Route::get('/kelas', [AdminController::class, 'kelas'])->name('admin.kelas');
    Route::get('/diskusi', [UserController::class, 'diskusi'])->name('diskusi');
    Route::get('/detail-kelas/{id}', [AdminController::class, 'detailKelas'])->name('detail-kelas');
    Route::post('/kelas', [CourseController::class, 'kelas'])->name('kelas.post');
    Route::post('/kelas/{CourseId}', [courseController::class, 'editKelas'])->name('kelas.edit');
    Route::delete('/kelas/delete/{id}', [courseController::class, 'destroyCourse'])->name('course.destroy');


    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('/bundling', [AdminController::class, 'bundling'])->name('admin.bundling');
    Route::get('/sales', [AdminController::class, 'sales'])->name('sales');
    Route::get('/data-admin', [AdminController::class, 'dataAdmin'])->name('data.admin');
    Route::get('/data-pengajar', [AdminController::class, 'dataPengajar'])->name('data.pengajar');
    Route::get('/data-siswa', [AdminController::class, 'dataSiswa'])->name('data-siswa');
    Route::get('/instructor', [AdminController::class, 'getInstructor'])->name('get.instructors');


    //bundling
    Route::get('/detail-bundling/{id}', [AdminController::class, 'detailBundling'])->name('detail-bundling');
    Route::post('bundling', [CourseController::class, 'bundlePost'])->name('bundle.post');
    Route::post('/detail-bundling/{id}/edit', [CourseController::class, 'bundleEdit'])->name('bundle.edit');
    Route::post('/detail-bundling/{id}/course', [CourseController::class, 'bundleCoursePost'])->name('bundleCourse.post');
    Route::delete('/detail-bundling/delete/{id}', [courseController::class, 'destroyBundle'])->name('bundles.destroy');
    Route::delete('/detail-bundling/{bundleId}/course/delete', [CourseController::class, 'bundleCourseDelete'])->name('bundleCourse.delete');

    // categories
    Route::post('/kelas/categories/post', [CourseController::class, 'jenjang'])->name('categories.post');
    Route::get('/kelas/categories/get', [AdminController::class, 'getCategories'])->name('get.category');
    Route::delete('/kelas/{id}/destroy', [courseController::class, 'destroy'])->name('categories.destroy');
    Route::put('/kelas/{id}/edit', [courseController::class, 'editCategory'])->name('categories.edit');

    // data Course
    Route::post('/data/kelas/{id}/content/create', [courseContentController::class, 'createCourseContent'])->name('admin.kelas.content.post');
    Route::post('/data/kelas/{courseId}/content/update/{contentId}', [courseContentController::class, 'updateCourseContent'])->name('admin.kelas.content.update');
    Route::delete('/data/kelas/{courseId}/content/{id}/delete', [courseContentController::class, 'deleteContent'])->name('admin.kelas.content.delete');
});


// Grup rute untuk rute-rute yang terkait dengan admin

Route::prefix('user')->middleware(['whoami:user', 'completed.data'])->group(function () {

    Route::get('/', [UserController::class, 'completeData'])->name('user.data');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/kelas', [UserController::class, 'kelas'])->name('user.kelas');
    Route::get('/transaksi', [UserController::class, 'transaksi'])->name('transaksi');
    Route::get('/materi', [UserController::class, 'materi'])->name('materi');
    Route::get('/diskusi-kelas/{courseId}', [UserController::class, 'diskusi'])->name('diskusi');
    Route::get('/detail-kelas/{courseId}', [UserController::class, 'detailKelas'])->name('user.detail');

    Route::post('/complete-data', [UserDataController::class, 'completePost'])->name('complete.post');

    Route::post('/diskusi-kelas/{courseId}', [courseForumController::class, 'createCourseForum'])->name('diskusi.post');
    Route::post('/diskusi-kelas/{courseId}/reply', [courseForumController::class, 'replyCourseForum'])->name('diskusi.post.reply');
    Route::post('/quiz/answer/{contentId}', [userCourseController::class, 'answerQuiz'])->name('quiz.answer');

    Route::post('/checkout', [transactionController::class, 'checkout'])->name('user.checkout');
});


Route::prefix('instructor')->middleware(['whoami:instructor'])->group(function () {
    Route::get('/dashboard', [InstructorController::class, 'dashboard'])->name('instructor.dashboard');
    Route::get('/kelas', [InstructorController::class, 'kelas'])->name('instructor.kelas');
    Route::get('/detail-kelas/{id}', [InstructorController::class, 'detailKelas'])->name('instructor.detail-kelas');
    Route::get('/profile', [InstructorController::class, 'profile'])->name('profile');
    Route::get('/diskusi', [InstructorController::class, 'diskusi'])->name('diskusi');
});

// Rute untuk login pengguna biasa
Route::prefix('')->middleware('redirect.if.authenticated:user')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login'); // Menampilkan form login
    Route::post('/login', [AuthController::class, 'login']); // Proses login user
    // for google login
    Route::get('/login/google', [AuthController::class, 'handleGoogleOauth'])->name('login.google');
    Route::get('/register/google', [AuthController::class, 'handleGoogleOauth'])->name('register.google');
    Route::get('/auth/google/login', [AuthController::class, 'handleGoogleCallback']);
});

// Rute untuk login admin
Route::prefix('admin')->middleware('redirect.if.authenticated:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showAdmin'])->name('login.Admin'); // Menampilkan form login admin
    Route::post('/login', [AuthController::class, 'loginAdmin']); // Proses login admin
});

// Rute untuk login instrutor
Route::prefix('instructor')->middleware('redirect.if.authenticated:instructor')->group(function () {
    Route::get('/login', [AuthController::class, 'showInstructor'])->name('login.instructor'); // Menampilkan form login admin
    Route::post('/login', [AuthController::class, 'loginInstructor']); // Proses login admin
});

Route::prefix('')->group(function () {
    Route::get('/register', [RegisController::class, 'show'])->name('show'); // Menampilkan form registrasi
    Route::post('/register', [RegisController::class, 'store'])->name('register'); // Proses registrasi user
});


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/activate', [AuthController::class, 'activation'])->name('activate.post');
Route::get('/activate', [AuthController::class, 'activate'])->name('activate');

Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

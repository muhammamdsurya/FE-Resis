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

Route::get('/bundling', [publicController::class, 'bundling'])->name('bundling');
Route::get('/detail-bundling/{courseBundleId}', [publicController::class, 'detailBundling'])->name('detail.bundling');


Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy-policy', function () {
    return view('policy');
})->name('policy');

Route::get('/register', function () {
    return view('register');
})->name('show'); // Menampilkan form registrasi


// Grup rute untuk rute-rute yang terkait dengan admin
Route::prefix('admin')->middleware(['whoami:admin'])->group(function () {
    // data register
    Route::get('/complete-data/admin/{id}', [AdminController::class, 'completeData'])->name('admin.data');
    Route::post('/complete-data', [AdminController::class, 'completePost'])->name('complete.post.admin');
    Route::get('/regis/data-pengajar/{personId}', [AdminController::class, 'completeDataPengajar'])->name('instructor.data');
    Route::post('/complete-data/pengajar', [AdminController::class, 'completePostPengajar'])->name('complete.post.pengajar');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard/sales', [AdminController::class, 'getSalesData'])->name('admin.sales');
    Route::get('/dashboard/sales/month', [AdminController::class, 'getSalesMonth'])->name('admin.salesMonth');
    //course
    Route::get('/kelas', [AdminController::class, 'kelas'])->name('admin.kelas');
    Route::get('/diskusi', [UserController::class, 'diskusi'])->name('diskusi');
    Route::get('/detail-kelas/{id}', [AdminController::class, 'detailKelas'])->name('detail-kelas');
    Route::get('/diskusi-kelas/{courseId}', [AdminController::class, 'diskusi'])->name('admin.diskusi');
    Route::post('/kelas', [CourseController::class, 'kelas'])->name('kelas.post');
    Route::post('/kelas/{CourseId}', [courseController::class, 'editKelas'])->name('kelas.edit');
    Route::delete('/kelas/delete/{CourseId}', [courseController::class, 'destroyCourse'])->name('course.destroy');


    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::get('/bundling', [AdminController::class, 'bundling'])->name('admin.bundling');
    Route::get('/sales', [AdminController::class, 'sales'])->name('sales');
    Route::get('/data-admin', [AdminController::class, 'dataAdmin'])->name('data.admin');
    Route::get('/data-pengajar', [AdminController::class, 'dataPengajar'])->name('data.pengajar');
    Route::get('/data-siswa', [AdminController::class, 'dataSiswa'])->name('data.siswa');
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
    Route::delete('/kelas/{id}/destroy', [courseController::class, 'destroy'])->name('categories.destroy');
    Route::put('/kelas/{id}/edit', [courseController::class, 'editCategory'])->name('categories.edit');

    // data Course
    Route::post('/data/kelas/{id}/content/create', [courseContentController::class, 'createCourseContent'])->name('admin.kelas.content.post');
    Route::post('/data/kelas/{courseId}/content/update/{contentId}', [courseContentController::class, 'updateCourseContent'])->name('admin.kelas.content.update');
    Route::delete('/data/kelas/{courseId}/content/{id}/delete', [courseContentController::class, 'deleteContent'])->name('admin.kelas.content.delete');

    // download
    Route::get('data-admin/download', [AdminController::class, 'downloadAdmin'])->name('admin.dataAdmin.download');
    Route::get('data-user/download', [AdminController::class, 'downloadUser'])->name('admin.dataUser.download');
    Route::get('data-instructor/download', [AdminController::class, 'downloadInstructor'])->name('admin.dataInstructor.download');
    Route::get('data-sales/download', [AdminController::class, 'downloadSales'])->name('admin.dataSales.download');
    Route::get('data-course/download', [AdminController::class, 'downloadCourse'])->name('admin.dataCourse.download');
    Route::get('data-bundling/download', [AdminController::class, 'downloadCourseBundling'])->name('admin.dataBundling.download');

    // admin data
    Route::delete('data-admin/{id}', [AdminController::class, 'deleteAdmin'])->name('admin.dataAdmin.delete');
    Route::delete('data-pengajar/{id}/delete', [AdminController::class, 'deletePengajar'])->name('admin.dataPengajar.delete');
    Route::post('data-pengajar/{id}/edit', [AdminController::class, 'editPengajar'])->name('admin.dataPengajar.edit');
    Route::post('data-admin/admin/post', [AuthController::class, 'regisAdmin'])->name('admin.dataAdmin.regis');
    Route::post('data-admin/instructor/post', [AuthController::class, 'regisInstructor'])->name('admin.dataInstructor.regis');

    // CourseForum
    Route::post('/diskusi-kelas/{courseId}/reply', [courseForumController::class, 'replyCourseForum'])->name('admin.diskusi.post.reply');
    Route::post('/diskusi-kelas/{courseId}/reply/image', [courseForumController::class, 'imageReplyForum'])->name('admin.diskusi.post.reply.img');
    Route::post('/diskusi-kelas/{courseId}/delete', [courseForumController::class, 'deleteCourseForum'])->name('admin.diskusi.delete');
    Route::post('/diskusi-kelas/{courseId}/reply/delete', [courseForumController::class, 'deleteReplyCourseForum'])->name('admin.diskusi.reply.delete');
});


Route::prefix('user')->middleware(['whoami:user', 'completed.data'])->group(function () {
    Route::get('/', [UserController::class, 'completeData'])->name('user.data');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/kelas', [UserController::class, 'kelas'])->name('user.kelas');
    Route::get('/transaksi', [UserController::class, 'transaksi'])->name('transaksi');
    Route::get('/materi', [UserController::class, 'materi'])->name('materi');
    Route::get('/diskusi-kelas/{courseId}', [UserController::class, 'diskusi'])->name('diskusi');
    Route::get('/detail-kelas/{courseId}', [UserController::class, 'detailKelas'])->name('user.detail');

    Route::post('/complete-data', [UserDataController::class, 'completePost'])->name('complete.post');

    Route::post('/update-data', [UserDataController::class, 'updateData'])->name('update.data');

    Route::post('/diskusi-kelas/{courseId}', [courseForumController::class, 'createCourseForum'])->name('diskusi.post');
    Route::post('/diskusi-kelas/{courseId}/delete', [courseForumController::class, 'deleteCourseForum'])->name('diskusi.delete');
    Route::post('/diskusi-kelas/{courseId}/image', [courseForumController::class, 'imageForum'])->name('diskusi.post.img');
    Route::post('/diskusi-kelas/{courseId}/reply', [courseForumController::class, 'replyCourseForum'])->name('diskusi.post.reply');
    Route::post('/diskusi-kelas/{courseId}/reply/image', [courseForumController::class, 'imageReplyForum'])->name('diskusi.post.reply.img');
    Route::post('/diskusi-kelas/{courseId}/reply/delete', [courseForumController::class, 'deleteReplyCourseForum'])->name('diskusi.reply.delete');

    Route::post('/quiz/answer/{contentId}', [userCourseController::class, 'answerQuiz'])->name('quiz.answer');
    Route::post('/kelas/rate', [userCourseController::class, 'rate'])->name('kelas.rate');

    Route::post('/checkout', [transactionController::class, 'checkout'])->name('user.checkout');
});


Route::prefix('instructor')->middleware(['whoami:instructor'])->group(function () {
    Route::get('/dashboard', [InstructorController::class, 'dashboard'])->name('instructor.dashboard');
    Route::get('/kelas', [InstructorController::class, 'kelas'])->name('instructor.kelas');
    Route::get('/detail-kelas/{id}', [InstructorController::class, 'detailKelas'])->name('instructor.detail-kelas');
    Route::get('/profile', [InstructorController::class, 'profile'])->name('profile');

     // CourseForum
     Route::get('/diskusi-kelas/{courseId}', [InstructorController::class, 'diskusi'])->name('instructor.diskusi');
     Route::post('/diskusi-kelas/{courseId}/reply', [courseForumController::class, 'replyCourseForum'])->name('instructor.diskusi.post.reply');
     Route::post('/diskusi-kelas/{courseId}/reply/image', [courseForumController::class, 'imageReplyForum'])->name('instructor.diskusi.post.reply.img');
     Route::post('/diskusi-kelas/{courseId}/reply/delete', [courseForumController::class, 'deleteReplyCourseForum'])->name('instructor.diskusi.reply.delete');
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
    Route::get('/login', [AuthController::class, 'showAdmin'])->name('show.login.admin'); // Menampilkan form login admin
    Route::post('/login', [AuthController::class, 'loginAdmin'])->name('login.admin'); // Proses login admin
});

// Rute untuk login instrutor
Route::prefix('instructor')->middleware('redirect.if.authenticated:instructor')->group(function () {
    Route::get('/login', [AuthController::class, 'showInstructor'])->name('login.instructor'); // Menampilkan form login admin
    Route::post('/login', [AuthController::class, 'loginInstructor']); // Proses login admin
});


Route::post('/register', [AuthController::class, 'register'])->name('register'); // Proses registrasi user

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/activate/{token}', [AuthController::class, 'activation'])->name('activate.post');
Route::get('/activate', [AuthController::class, 'activate'])->name('activate');

Route::post('/reset-password/post', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::put('/reset-password/{token}', [AuthController::class, 'putPassword'])->name('put.password');
Route::get('/reset-password', [AuthController::class, 'getReset'])->name('get.reset');
Route::get('/reset-password/public', [AuthController::class, 'getResetPublic'])->name('reset.password.public');

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/beranda');
});

Route::get('/beranda', function () {
    return view('welcome');
})->name('beranda');

Route::get('/kelas', function () {
    return view('kelas');
})->name('kelas');


Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');


Route::get('/login', function () {
    return view('login');
})->name('login');


Route::get('/register', function () {
    return view('register');
})->name('register');


Route::get('/detail-kelas', function () {
    return view('detailKelas');
})->name('detail-kelas');


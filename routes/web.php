<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TahunAjaranController;

/*
|--------------------------------------------------------------------------
| Web Routes - SIAK SD Negeri 007 Sekupang
|--------------------------------------------------------------------------
*/


Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('/login', 'loginProses')->name('loginProses');
    Route::post('/logout', 'logout')->name('logout');
});


Route::middleware(['auth', 'checkrole'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('tahun-ajaran', TahunAjaranController::class);
});

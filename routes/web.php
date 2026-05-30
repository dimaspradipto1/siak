<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\JenisKehadiranController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\NilaiController;

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
    Route::resource('semester', SemesterController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('walikelas', WaliKelasController::class);
    Route::resource('orang-tua', OrangTuaController::class);
    Route::resource('ekstrakurikuler', EkstrakurikulerController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('matapelajaran', MataPelajaranController::class);
    Route::resource('jeniskehadiran', JenisKehadiranController::class);
    Route::resource('kehadiran', KehadiranController::class);
    Route::resource('nilai', NilaiController::class);
});

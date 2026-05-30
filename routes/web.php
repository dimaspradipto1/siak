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
use App\Http\Controllers\JenisCatatanController;
use App\Http\Controllers\CatatanSiswaController;
use App\Http\Controllers\PengumumanController;

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
    Route::get('pegawai/export', [PegawaiController::class, 'export'])->name('pegawai.export');
    Route::post('pegawai/import', [PegawaiController::class, 'import'])->name('pegawai.import');
    Route::get('pegawai/template', [PegawaiController::class, 'template'])->name('pegawai.template');
    Route::resource('pegawai', PegawaiController::class);
    Route::get('guru/export', [GuruController::class, 'export'])->name('guru.export');
    Route::post('guru/import', [GuruController::class, 'import'])->name('guru.import');
    Route::get('guru/template', [GuruController::class, 'template'])->name('guru.template');
    Route::resource('guru', GuruController::class);
    Route::resource('tahun-ajaran', TahunAjaranController::class);
    Route::resource('semester', SemesterController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('walikelas', WaliKelasController::class);
    Route::get('orang-tua/export', [OrangTuaController::class, 'export'])->name('orang-tua.export');
    Route::post('orang-tua/import', [OrangTuaController::class, 'import'])->name('orang-tua.import');
    Route::get('orang-tua/template', [OrangTuaController::class, 'template'])->name('orang-tua.template');
    Route::resource('orang-tua', OrangTuaController::class);
    Route::resource('ekstrakurikuler', EkstrakurikulerController::class);
    Route::get('siswa/export', [SiswaController::class, 'export'])->name('siswa.export');
    Route::post('siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
    Route::get('siswa/template', [SiswaController::class, 'template'])->name('siswa.template');
    Route::resource('siswa', SiswaController::class);
    Route::get('matapelajaran/export', [MataPelajaranController::class, 'export'])->name('matapelajaran.export');
    Route::post('matapelajaran/import', [MataPelajaranController::class, 'import'])->name('matapelajaran.import');
    Route::get('matapelajaran/template', [MataPelajaranController::class, 'template'])->name('matapelajaran.template');
    Route::resource('matapelajaran', MataPelajaranController::class);
    Route::resource('jeniskehadiran', JenisKehadiranController::class);
    Route::resource('kehadiran', KehadiranController::class);
    Route::resource('nilai', NilaiController::class);
    Route::resource('jeniscatatan', JenisCatatanController::class);
    Route::resource('catatansiswa', CatatanSiswaController::class);
    Route::resource('pengumuman', PengumumanController::class);
});

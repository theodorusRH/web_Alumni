<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
// use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\AlumniNewsController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\DosenController;

// Halaman utama
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->is_admin
            ? redirect()->route('dashboard.index')
            : redirect()->route('dashboard.user');
    }
    return app(AlumniNewsController::class)->home();
})->name('home');

// Public Pages
Route::get('/home/{id}', [AlumniNewsController::class, 'showhome'])->name('home.showhome');
Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/kegiatan/{id}', [KegiatanController::class, 'show'])->name('kegiatan.show');
Route::get('/alumninews', [AlumniNewsController::class, 'index'])->name('alumninews.index');
Route::get('/alumninews/{id}', [AlumniNewsController::class, 'show'])->name('alumninews.show');
Route::get('/lowongan', [LowonganController::class, 'publicIndex'])->name('lowongan.index');

// KONTAK
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.kirim');

//PERTANYAAN


Route::get('/profile', [UserController::class, 'profile'])->name('profile');

// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Dashboard (authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'index'])->name('dashboard.index');
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('dashboard.user');

    //PROFILE
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});

//DOSEN
Route::middleware(['auth'])->get('/dosen/tugasakhir', [DosenController::class, 'index'])->name('dosen.tugasakhir');

// Admin-only routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/mahasiswa/{nrp}', [MahasiswaController::class, 'detailMahasiswa'])->name('mahasiswa.detail');
    Route::post('/mahasiswa', [MahasiswaController::class, 'storeMahasiswa'])->name('mahasiswa.store');
    Route::put('/mahasiswa/{nrp}', [MahasiswaController::class, 'updateMahasiswa'])->name('mahasiswa.update');
    Route::delete('/mahasiswa/{nrp}', [MahasiswaController::class, 'destroyMahasiswa'])->name('mahasiswa.destroy');

    Route::get('/alumni', [AlumniController::class, 'alumni'])->name('alumni');

    Route::get('/pendidikan', [PendidikanController::class, 'index'])->name('pendidikan.index');
    Route::get('/pendidikan/{nrp}', [PendidikanController::class, 'index'])->name('pendidikan.show');
    Route::post('/pendidikan/{nrp}', [PendidikanController::class, 'store'])->name('pendidikan.store');
    Route::put('/pendidikan/{id}', [PendidikanController::class, 'update'])->name('pendidikan.update');
    Route::delete('/pendidikan/{id}', [PendidikanController::class, 'destroy'])->name('pendidikan.destroy');

    // Route::get('/pekerjaan', [PekerjaanController::class, 'index'])->name('pekerjaan.index');
    Route::get('/pekerjaan', [PekerjaanController::class, 'index'])->name('pekerjaan.index');
    Route::get('/pekerjaan/{nrp}', [PekerjaanController::class, 'index'])->name('pekerjaan.show');
    Route::post('/pekerjaan', [PekerjaanController::class, 'storePekerjaan'])->name('pekerjaan.store');
    Route::put('/pekerjaan/{id}', [PekerjaanController::class, 'updatePekerjaan'])->name('pekerjaan.update');
    Route::delete('/pekerjaan/{id}', [PekerjaanController::class, 'destroyPekerjaan'])->name('pekerjaan.destroy');

    Route::get('/perusahaan', [AlumniController::class, 'perusahaan'])->name('perusahaan');
    Route::post('/perusahaan', [AlumniController::class, 'storePerusahaan'])->name('perusahaan.store');
    Route::put('/perusahaan/{id}', [AlumniController::class, 'updatePerusahaan'])->name('perusahaan.update');
    Route::delete('/perusahaan/{id}', [AlumniController::class, 'destroyPerusahaan'])->name('perusahaan.destroy');

    Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
    Route::get('/lowongan/create', [LowonganController::class, 'create'])->name('lowongan.create');
    Route::post('/lowongan', [LowonganController::class, 'storeLowongan'])->name('lowongan.store');
    Route::get('/lowongan/{id}/edit', [LowonganController::class, 'edit'])->name('lowongan.edit');
    Route::put('/lowongan/{id}', [LowonganController::class, 'updateLowongan'])->name('lowongan.update');
    Route::delete('/lowongan/{id}', [LowonganController::class, 'destroyLowongan'])->name('lowongan.destroy');

    Route::get('/propinsi', [AlumniController::class, 'propinsi'])->name('propinsi');
    Route::post('/propinsi', [AlumniController::class, 'storePropinsi'])->name('propinsi.store');
    Route::get('/jurusan', [AlumniController::class, 'jurusan'])->name('jurusan');
    Route::post('/jurusan', [AlumniController::class, 'storeJurusan'])->name('jurusan.store');
    Route::get('/jenis-pekerjaan', [AlumniController::class, 'jenisPekerjaan'])->name('jenis-pekerjaan');
    Route::post('/jenis-pekerjaan', [AlumniController::class, 'storeJenisPekerjaan'])->name('jenis-pekerjaan.store');

    Route::get('/laporan', [AlumniController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/export', [AlumniController::class, 'exportLaporan'])->name('laporan.export');

    Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan.index');
    Route::delete('/pertanyaan/{idpertanyaan}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');

    // 👇 Tambahan manajemen kegiatan
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->name('kegiatan.create');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::get('/kegiatan/{id}/edit', [KegiatanController::class, 'edit'])->name('kegiatan.edit');
    Route::put('/kegiatan/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

    Route::get('/alumninews', [AlumniNewsController::class, 'index'])->name('alumninews.index');
    Route::get('/alumninews/create', [AlumniNewsController::class, 'create'])->name('alumninews.create');
    Route::post('/alumninews', [AlumniNewsController::class, 'store'])->name('alumninews.store');
    Route::get('/alumninews/{id}/edit', [AlumniNewsController::class, 'edit'])->name('alumninews.edit');
    Route::put('/alumninews/{id}', [AlumniNewsController::class, 'update'])->name('alumninews.update');
    Route::delete('/alumninews/{id}', [AlumniNewsController::class, 'destroy'])->name('alumninews.destroy');
});

// API untuk data alumni
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::get('/mahasiswa', [MahasiswaController::class, 'getMahasiswa'])->name('mahasiswa');
    Route::get('/alumni', [MahasiswaController::class, 'getAlumni'])->name('alumni');
    Route::get('/pekerjaan', [MahasiswaController::class, 'getPekerjaan'])->name('pekerjaan');
    Route::get('/perusahaan', [MahasiswaController::class, 'getPerusahaan'])->name('perusahaan');
    Route::get('/lowongan', [MahasiswaController::class, 'getLowongan'])->name('lowongan');
    Route::get('/statistics', [MahasiswaController::class, 'getStatistics'])->name('statistics');
});

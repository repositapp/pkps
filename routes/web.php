<?php

use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GuruMapelController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KelasSiswaController;
use App\Http\Controllers\MobileAuthController;
use App\Http\Controllers\MobileGuruController;
use App\Http\Controllers\MobileOrtuController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\PelajaranController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;












/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Admin Auth
Route::middleware('guest:web')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/authentication', [AuthController::class, 'authenticate'])->name('authentication');
});

// Route::get('/force-logout', function () {
//     Auth::logout();
//     request()->session()->invalidate();
//     request()->session()->regenerateToken();
//     return redirect('/login')->with('success', 'Logout paksa berhasil.');
// });


Route::prefix('panel')->middleware(['auth:web', 'role:admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Manajemen Siswa
    Route::resource('siswa', SiswaController::class)->except(['show']);
    // Manajemen Guru
    Route::resource('guru', GuruController::class)->except(['show']);
    // Manajemen Ortu
    Route::resource('ortu', OrtuController::class)->except(['show']);
    // Manajemen Kelas
    Route::resource('kelas', KelasController::class)->except(['show']);
    // Manajemen Pelajaran
    Route::resource('pelajaran', PelajaranController::class)->except(['show']);
    // Manajemen Tahun Ajaran
    Route::resource('tahunajaran', TahunAjaranController::class)->except(['show']);
    // Relasi Guru - Mapel - Kelas
    Route::resource('mapel', GuruMapelController::class)->except(['show']);
    // Relasi Siswa - Kelas
    Route::resource('siswakelas', KelasSiswaController::class)->except(['show']);
    // Settings
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('aplikasi', AplikasiController::class)->except(['show', 'create', 'store', 'destroy', 'edit']);
});

// Mobile Auth
Route::middleware('guest:user')->prefix('mobile')->group(function () {
    Route::get('/login', [MobileAuthController::class, 'login'])->name('mobile.login');
    Route::post('/authenticate', [MobileAuthController::class, 'authenticate'])->name('mobile.authenticate');
});

// Mobile Guru
Route::prefix('mobile/guru')->middleware(['auth:user', 'role:guru'])->group(function () {
    Route::get('/dashboard', [MobileGuruController::class, 'dashboard'])->name('mobile.guru.dashboard');
    Route::get('/jadwal', [MobileGuruController::class, 'jadwal'])->name('mobile.guru.jadwal');
    Route::get('/profil', [MobileGuruController::class, 'profil'])->name('mobile.guru.profil');

    // Absensi
    Route::get('/absensi', [MobileGuruController::class, 'absensiIndex'])->name('mobile.guru.absensi.index');
    Route::get('/absensi/kelas', [MobileGuruController::class, 'absensiPilihKelas'])->name('mobile.guru.absensi.pilih-kelas');
    Route::get('/absensi/create/{kelas_id}', [MobileGuruController::class, 'absensiCreate'])->name('mobile.guru.absensi.create');
    Route::post('/absensi/store', [MobileGuruController::class, 'absensiStore'])->name('mobile.guru.absensi.store');
    Route::get('/absensi/laporan', [MobileGuruController::class, 'laporanAbsensi'])->name('mobile.guru.absensi.laporan');
    Route::get('/absensi/laporan/cetak/{kelas_id}', [MobileGuruController::class, 'laporanAbsensiCetak'])->name('mobile.guru.absensi.laporan.cetak');

    // Perilaku
    Route::get('/perilaku', [MobileGuruController::class, 'perilakuIndex'])->name('mobile.guru.perilaku.index');
    Route::get('/perilaku/kelas', [MobileGuruController::class, 'perilakuPilihKelas'])->name('mobile.guru.perilaku.pilih-kelas');
    Route::get('/perilaku/create/{kelas_id}', [MobileGuruController::class, 'perilakuCreate'])->name('mobile.guru.perilaku.create');
    Route::post('/perilaku/store', [MobileGuruController::class, 'perilakuStore'])->name('mobile.guru.perilaku.store');
    Route::get('/perilaku/laporan', [MobileGuruController::class, 'laporanPerilaku'])->name('mobile.guru.perilaku.laporan');
    Route::get('/perilaku/laporan/cetak/{kelas_id}', [MobileGuruController::class, 'laporanPerilakuCetak'])->name('mobile.guru.perilaku.laporan.cetak');

    // Laporan
    Route::get('/laporan', [MobileGuruController::class, 'laporanIndex'])->name('mobile.guru.laporan.index');
    Route::get('/laporan/siswa/{siswa_id}', [MobileGuruController::class, 'laporanDetail'])->name('mobile.guru.laporan.detail');
});

// Mobile Ortu
Route::prefix('mobile/ortu')->middleware(['auth:user', 'role:ortu'])->group(function () {
    Route::get('/dashboard', [MobileOrtuController::class, 'dashboard'])->name('mobile.ortu.dashboard');
    Route::get('/absensi', [MobileOrtuController::class, 'absensi'])->name('mobile.ortu.absensi');
    Route::get('/perilaku', [MobileOrtuController::class, 'perilaku'])->name('mobile.ortu.perilaku');
    Route::get('/profil', [MobileOrtuController::class, 'profil'])->name('mobile.ortu.profil');
});

// Logout
Route::post('/mobile/logout', [MobileAuthController::class, 'logout'])->name('mobile.logout');

<?php

use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
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

Route::middleware('guest:web')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/authentication', [AuthController::class, 'authenticate'])->name('authentication');

    Route::get('/registrasi', [AuthController::class, 'registrasi'])->name('registrasi');
    Route::post('/registrasi', [AuthController::class, 'register'])->name('registrasi.post');
});

Route::middleware('guest:user')->group(function () {
    Route::get('/user/login', [UserAuthController::class, 'index'])->name('user.login');
    Route::post('/user/authentication', [UserAuthController::class, 'authenticate'])->name('user.authentication');

    // Route Registrasi
    Route::get('/user/register', [UserAuthController::class, 'registrasi'])->name('user.register');
    Route::post('/user/register', [UserAuthController::class, 'register'])->name('user.register.post');
});

// Route::get('/force-logout', function () {
//     Auth::logout();
//     request()->session()->invalidate();
//     request()->session()->regenerateToken();
//     return redirect('/login')->with('success', 'Logout paksa berhasil.');
// });


Route::prefix('panel')->middleware(['auth:web', 'role:admin_komunitas,admin_barber'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Manajemen Barber
    Route::resource('barber', BarberController::class)->except(['show']);
    Route::put('/barber/{id}/toggle-status', [BarberController::class, 'toggleStatus'])->name('barber.toggleStatus');
    Route::put('/barber/{id}/toggle-verification', [BarberController::class, 'toggleVerification'])->name('barber.toggleVerification');
    // Manajemen Pemesanan
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::put('/pemesanan/{id}/konfirmasi', [PemesananController::class, 'konfirmasi'])->name('pemesanan.konfirmasi');
    Route::put('/pemesanan/{id}/batalkan', [PemesananController::class, 'batalkan'])->name('pemesanan.batalkan');
    Route::put('/pemesanan/{id}/proses', [PemesananController::class, 'proses'])->name('pemesanan.proses');
    Route::put('/pemesanan/{id}/selesai', [PemesananController::class, 'selesai'])->name('pemesanan.selesai');
    // Manajemen Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::put('/transaksi/{id}/konfirmasi', [TransaksiController::class, 'konfirmasi'])->name('transaksi.konfirmasi');
    // Jika diperlukan fitur edit transaksi (misalnya untuk mengisi metode pembayaran)
    Route::get('/transaksi/{id}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
    // Manajemen Layanan
    Route::resource('layanan', LayananController::class)->except(['show']);
    Route::put('/layanan/{id}/toggle-status', [LayananController::class, 'toggleStatus'])->name('layanan.toggleStatus');
    // Manajemen Jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/edit/{hari}', [JadwalController::class, 'edit'])->name('jadwal.edit'); // Edit berdasarkan hari
    Route::put('/jadwal/{hari}', [JadwalController::class, 'update'])->name('jadwal.update');
    // Toggle status hari kerja/libur
    Route::put('/jadwal/{id}/toggle-status', [JadwalController::class, 'toggleStatus'])->name('jadwal.toggleStatus');
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
    // Settings
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('aplikasi', AplikasiController::class)->except(['show', 'create', 'store', 'destroy', 'edit']);
});

Route::prefix('mobile')->middleware(['auth:user', 'role:pelanggan'])->group(function () {
    Route::post('/user/logout', [UserAuthController::class, 'logout'])->name('user.logout');
    // Dashboard
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('barber', [BarberController::class, 'show'])->name('barber');
    Route::get('barber/detail/{id}', [BarberController::class, 'detail'])->name('barber.detail');
    Route::post('barber/detail/booking', [BarberController::class, 'booking'])->name('barber.booking');
    Route::get('transaksi', [TransaksiController::class, 'indexTransaksi'])->name('transaksi');
    Route::get('/transaksi/detail/{id}', [TransaksiController::class, 'detail'])->name('transaksi.detail');
    Route::get('profil', [UserController::class, 'profil'])->name('profil');
    Route::put('/profil/{id}', [UserController::class, 'updateProfil'])->name('profil.update');
});

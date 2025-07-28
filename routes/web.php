<?php

use App\Http\Controllers\AplikasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\UserController;
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

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/authentication', [AuthController::class, 'authenticate'])->name('authentication');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/registrasi', [AuthController::class, 'registrasi'])->name('registrasi');
Route::post('/registrasi', [AuthController::class, 'register'])->name('registrasi.post');

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/pengumuman/{slug}', [PengumumanController::class, 'show'])->name('pengumuman.show');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/{slug}', [MenuController::class, 'show'])->name('menu.show');

Route::prefix('panel')->middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Master Data
    Route::resource('kategori', KategoriController::class)->except(['show']);
    // Pengumuman
    Route::resource('pengumuman', PengumumanController::class)->except(['show']);
    // Modul
    Route::resource('halaman', HalamanController::class)->except(['show']);
    Route::resource('menu', MenuController::class)->except(['show']);
    Route::get('/menu/load-targets', [MenuController::class, 'loadTargets'])->name('menu.target');
    // Settings
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('aplikasi', AplikasiController::class)->except(['show', 'create', 'store', 'destroy', 'edit']);
});

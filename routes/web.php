<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KasirController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Middleware Admin (Bisa akses semua)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('kasir', KasirController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('supplier', SupplierController::class);
    Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');
});

// Admin & Kasir bisa melihat index penjualan & detail penjualan
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');

    Route::get('/penjualan/struk/{penjualanid}', [PenjualanController::class, 'Struk'])->name('penjualan.struk');

    Route::get('/penjualan/laporan', [PenjualanController::class, 'laporan'])->name('penjualan.laporan');
    Route::get('/penjualan/laporan/cetak', [PenjualanController::class, 'cetakLaporan'])->name('penjualan.cetakLaporan');

    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/laporan', [PenjualanController::class, 'laporan'])->name('penjualan.laporan');
    Route::get('/penjualan/laporan/cetak', [PenjualanController::class, 'cetakLaporan'])->name('penjualan.cetakLaporan');

    });

// Middleware Kasir
Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
});

// Resource Route untuk Penjualan dan Detail Penjualan
Route::resource('penjualan', PenjualanController::class);

// Menangani DELETE secara eksplisit jika ada masalah dengan resource route
// Route::delete('/penjualan', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

// Register & Login Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('pages.register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'postlogin'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Halaman utama tampilan
Route::get('/tampilan', function () {
    return view('pages.tampilan');
})->name('pages.tampilan');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'search'])->name('search');

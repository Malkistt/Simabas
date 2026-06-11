<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboard;
use App\Http\Controllers\Nasabah\DashboardController as NasabahDashboard;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\HargaSampahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\AuthController;

// Ubah kata '/register' menjadi '/daftar-baru'
Route::get('/daftar-baru', [AuthController::class, 'showRegister'])->name('register.custom');
Route::post('/daftar-baru', [AuthController::class, 'register'])->name('register.custom.post');
// 1. ROUTE PUBLIK (Tidak butuh login)
Route::get('/', function () { return view('welcome'); });

// Contoh pengelompokan rute untuk Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // Pindahkan rute-rute admin ke dalam sini
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
    
    Route::resource('jenis-sampah', App\Http\Controllers\JenisSampahController::class);
    // Tambahkan rute admin lainnya di sini...
});

// 2. ROUTE TERPROTEKSI (Wajib Login)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Grouping berdasarkan Role (Menggunakan middleware 'role' yang kita buat)
    // Contoh pengelompokan rute untuk Admin
    Route::middleware(['auth'])->prefix('admin')->group(function () {
        
        // Pindahkan rute-rute admin ke dalam sini
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
        
        Route::resource('jenis-sampah', App\Http\Controllers\JenisSampahController::class);
        // Tambahkan rute admin lainnya di sini...
    });

    Route::prefix('petugas')->group(function () {
        Route::get('/dashboard', [PetugasDashboard::class, 'index']);
    });

    Route::prefix('nasabah')->group(function () {
        Route::get('/dashboard', [NasabahDashboard::class, 'index']);
    });
    // Resource Global (Yang bisa diakses multi-role)
    Route::resource('nasabah', NasabahController::class);
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    
    // Transaksi
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/cetak/{id}', [TransaksiController::class, 'cetakStruk'])->name('transaksi.cetak');
    
    // Penarikan
    Route::get('/penarikan/create', [PenarikanController::class, 'create'])->name('penarikan.create');
    Route::post('/penarikan/store', [PenarikanController::class, 'store'])->name('penarikan.store');

    Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::middleware(['auth'])->group(function () {
    // Rute Riwayat Transaksi Nasabah
    Route::get('/nasabah/riwayat', [RiwayatController::class, 'index'])->name('nasabah.riwayat');
    Route::get('/nasabah/riwayat/detail/{id}', [RiwayatController::class, 'detail'])->name('nasabah.riwayat.detail');
    });
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/profil/profil', [App\Http\Controllers\ProfileController::class, 'edit'])->name('nasabah.profil.edit');
        Route::post('/profil/profil/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('nasabah.profil.update');
    });

    Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('harga_sampah', [App\Http\Controllers\Admin\HargaSampahController::class, 'index'])->name('admin.harga.index');
    Route::post('harga_sampah/update/{id}', [App\Http\Controllers\Admin\HargaSampahController::class, 'update'])->name('admin.harga.update');
    Route::get('/riwayat-transaksi', [App\Http\Controllers\Admin\RiwayatController::class, 'index'])->name('admin.riwayat.index');
    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/laporan/cetak-pdf', [App\Http\Controllers\Admin\LaporanController::class, 'cetakPdf'])->name('admin.laporan.pdf');
    });
});
 

require __DIR__.'/auth.php';
    

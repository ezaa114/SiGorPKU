<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\PemilikGor;
use App\Http\Controllers\Pelanggan;

// Public Landing Page
Route::get('/', [App\Http\Controllers\LandingPageController::class, 'index'])->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register/pelanggan', [AuthController::class, 'showRegisterPelanggan'])->name('register.pelanggan');
    Route::post('/register/pelanggan', [AuthController::class, 'registerPelanggan']);

    Route::get('/register/pemilik', [AuthController::class, 'showRegisterPemilik'])->name('register.pemilik');
    Route::post('/register/pemilik', [AuthController::class, 'registerPemilik']);
});

Route::get('/pemilik/pending', [AuthController::class, 'pendingPemilik'])
    ->name('pemilik.pending')
    ->middleware('auth:pemilik');

Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

// 1. ADMIN ROUTES
Route::middleware(['role.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transaksi', [Admin\DashboardController::class, 'transaksi'])->name('transaksi');
    
    // Pemilik GOR Verification & Listing
    Route::get('/pemilik-gor', [Admin\PemilikGorController::class, 'index'])->name('pemilik-gor.index');
    Route::get('/pemilik-gor/{id}', [Admin\PemilikGorController::class, 'show'])->name('pemilik-gor.show');
    Route::post('/pemilik-gor/{id}/verifikasi', [Admin\PemilikGorController::class, 'verifikasi'])->name('pemilik-gor.verifikasi');

    // Jenis Lapangan CRUD
    Route::get('/jenis-lapangan', [Admin\JenisLapanganController::class, 'index'])->name('jenis-lapangan.index');
    Route::get('/jenis-lapangan/create', [Admin\JenisLapanganController::class, 'create'])->name('jenis-lapangan.create');
    Route::post('/jenis-lapangan', [Admin\JenisLapanganController::class, 'store'])->name('jenis-lapangan.store');
    Route::get('/jenis-lapangan/{id}/edit', [Admin\JenisLapanganController::class, 'edit'])->name('jenis-lapangan.edit');
    Route::post('/jenis-lapangan/{id}/update', [Admin\JenisLapanganController::class, 'update'])->name('jenis-lapangan.update');
    Route::post('/jenis-lapangan/{id}/delete', [Admin\JenisLapanganController::class, 'destroy'])->name('jenis-lapangan.delete');

    // Profile Management
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// 2. PEMILIK GOR ROUTES
Route::middleware(['role.pemilik'])->prefix('pemilik')->name('pemilik.')->group(function () {
    Route::get('/dashboard', [PemilikGor\DashboardController::class, 'index'])->name('dashboard');
    
    // Venue Management
    Route::get('/venue', [PemilikGor\VenueController::class, 'index'])->name('venue.index');
    Route::get('/venue/create', [PemilikGor\VenueController::class, 'create'])->name('venue.create');
    Route::post('/venue', [PemilikGor\VenueController::class, 'store'])->name('venue.store');
    Route::get('/venue/{id}/edit', [PemilikGor\VenueController::class, 'edit'])->name('venue.edit');
    Route::post('/venue/{id}/update', [PemilikGor\VenueController::class, 'update'])->name('venue.update');
    Route::post('/venue/{id}/delete', [PemilikGor\VenueController::class, 'destroy'])->name('venue.delete');

    // Lapangan Management
    Route::get('/lapangan', [PemilikGor\LapanganController::class, 'index'])->name('lapangan.index');
    Route::get('/lapangan/create', [PemilikGor\LapanganController::class, 'create'])->name('lapangan.create');
    Route::post('/lapangan', [PemilikGor\LapanganController::class, 'store'])->name('lapangan.store');
    Route::get('/lapangan/{id}/edit', [PemilikGor\LapanganController::class, 'edit'])->name('lapangan.edit');
    Route::post('/lapangan/{id}/update', [PemilikGor\LapanganController::class, 'update'])->name('lapangan.update');
    Route::post('/lapangan/{id}/delete', [PemilikGor\LapanganController::class, 'destroy'])->name('lapangan.delete');

    // Jadwal Management
    Route::get('/jadwal', [PemilikGor\JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/create', [PemilikGor\JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal', [PemilikGor\JadwalController::class, 'store'])->name('jadwal.store');
    Route::post('/jadwal/{id}/delete', [PemilikGor\JadwalController::class, 'destroy'])->name('jadwal.delete');

    // Pembayaran Management (Pesanan masuk & Konfirmasi)
    Route::get('/pembayaran', [PemilikGor\PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/{id}/konfirmasi', [PemilikGor\PembayaranController::class, 'konfirmasi'])->name('pembayaran.konfirmasi');

    // Profile Management
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// 3. PELANGGAN ROUTES
Route::middleware(['role.pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [Pelanggan\DashboardController::class, 'index'])->name('dashboard');

    // Venue Info
    Route::get('/venue/{id}', [Pelanggan\BookingController::class, 'showVenue'])->name('venue.show');

    // Booking Flow
    Route::get('/booking', [Pelanggan\BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create', [Pelanggan\BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [Pelanggan\BookingController::class, 'store'])->name('booking.store');

    // Pemesanan & Pembayaran
    Route::get('/pemesanan', [Pelanggan\PemesananController::class, 'index'])->name('pemesanan.index');
    Route::get('/pemesanan/{id}', [Pelanggan\PemesananController::class, 'show'])->name('pemesanan.show');
    Route::post('/pemesanan/{id}/bayar', [Pelanggan\PemesananController::class, 'bayar'])->name('pemesanan.bayar');

    // Profile Management
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

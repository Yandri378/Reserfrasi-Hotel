<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalyticsController;

// Root Route - Redirect to login atau home
Route::get('/', function () {
    return auth()->check() ? redirect()->route('home') : redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'store'])->name('store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Home Route
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Protected Routes - Reservasi User
Route::middleware('auth')->group(function () {
    Route::resource('reservasi', ReservasiController::class);
    
    // PDF Routes - Cetak Bukti & Laporan
    Route::get('/reservasi/{reservasi}/print', [PDFController::class, 'printBukti'])->name('pdf.bukti');
    Route::get('/laporan/bulanan/pdf', [PDFController::class, 'laporanBulanan'])->name('pdf.laporan-bulanan');
    Route::get('/laporan/tahunan/pdf', [PDFController::class, 'laporanTahunan'])->name('pdf.laporan-tahunan');
    Route::get('/laporan/bulanan', [PDFController::class, 'viewLaporanBulanan'])->name('laporan.bulanan');
    Route::get('/laporan/tahunan', [PDFController::class, 'viewLaporanTahunan'])->name('laporan.tahunan');
    
    // Analytics Routes
    Route::get('/analytics', [AnalyticsController::class, 'dashboard'])->name('analytics.dashboard');
    Route::get('/api/chart-harian', [AnalyticsController::class, 'chartDataHarian'])->name('api.chart-harian');
    Route::get('/api/chart-bulanan', [AnalyticsController::class, 'chartDataBulanan'])->name('api.chart-bulanan');
    Route::get('/api/chart-status', [AnalyticsController::class, 'chartDataStatus'])->name('api.chart-status');
});

// Admin Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/reservasi/{reservasi}', [AdminController::class, 'detail'])->name('detail');
    Route::post('/reservasi/{reservasi}/approve', [AdminController::class, 'approve'])->name('approve');
    Route::post('/reservasi/{reservasi}/reject', [AdminController::class, 'reject'])->name('reject');
    Route::post('/reservasi/{reservasi}/update-status', [AdminController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/reservasi', [AdminController::class, 'allReservasi'])->name('all-reservasi');
});

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">Dashboard</h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div style="font-size: 40px; color: #3498db; margin-bottom: 15px;">
                    <i class="fas fa-list"></i>
                </div>
                <h3 class="card-title" style="font-size: 28px; color: #2c3e50; margin: 0;">{{ $totalReservasi }}</h3>
                <p class="card-text text-muted">Total Reservasi</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div style="font-size: 40px; color: #f39c12; margin-bottom: 15px;">
                    <i class="fas fa-clock"></i>
                </div>
                <h3 class="card-title" style="font-size: 28px; color: #2c3e50; margin: 0;">{{ $reservasiPending }}</h3>
                <p class="card-text text-muted">Reservasi Pending</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div style="font-size: 40px; color: #27ae60; margin-bottom: 15px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="card-title" style="font-size: 28px; color: #2c3e50; margin: 0;">{{ $reservasiConfirmed }}</h3>
                <p class="card-text text-muted">Reservasi Confirmed</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div style="font-size: 40px; color: #e74c3c; margin-bottom: 15px;">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3 class="card-title" style="font-size: 24px; color: #2c3e50; margin: 0;">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </h3>
                <p class="card-text text-muted">Total Pendapatan</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Akses Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('reservasi.create') }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-plus-circle"></i> Tambah Reservasi
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('reservasi.index') }}" class="btn btn-info btn-lg w-100">
                            <i class="fas fa-list"></i> Lihat Daftar Reservasi
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('reservasi.index') }}" class="btn btn-warning btn-lg w-100">
                            <i class="fas fa-filter"></i> Filter Reservasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Message -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card bg-light">
            <div class="card-body text-center">
                <h5>Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</h5>
                <p class="text-muted mb-0">Gunakan menu di sebelah kiri untuk mengelola reservasi hotel Anda.</p>
            </div>
        </div>
    </div>
</div>
@endsection

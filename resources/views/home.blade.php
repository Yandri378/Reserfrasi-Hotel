@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .fade-in {
        animation: fadeIn 1s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px);}
        to { opacity: 1; transform: translateY(0);}
    }
    .card {
        border-radius: 18px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        border: 1px solid rgba(255, 215, 0, 0.08);
        transition: box-shadow 0.3s, transform 0.2s;
    }
    .card:hover {
        box-shadow: 0 12px 40px 0 rgba(255, 215, 0, 0.18);
        transform: scale(1.02);
    }
    .card-title {
        color: #FFD700 !important;
        font-weight: 700;
    }
    .card-header {
        background: linear-gradient(90deg, #232526 60%, #FFD700 100%);
        color: #fff;
        border-radius: 18px 18px 0 0;
        border-bottom: 1px solid #FFD700;
    }
    .btn-lg {
        font-size: 1.2rem;
        font-weight: 600;
        border-radius: 10px;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px 0 rgba(255, 215, 0, 0.10);
    }
    .btn-lg:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 16px 0 rgba(255, 215, 0, 0.18);
    }
    .bg-light {
        background: linear-gradient(90deg, #232526 60%, #FFD700 100%) !important;
        color: #fff !important;
        border-radius: 18px;
    }
    .welcome-anim {
        animation: popIn 1.2s cubic-bezier(.68,-0.55,.27,1.55);
    }
    @keyframes popIn {
        0% { opacity: 0; transform: scale(0.8);}
        80% { opacity: 1; transform: scale(1.05);}
        100% { opacity: 1; transform: scale(1);}
    }
</style>

<div class="row fade-in">
    <div class="col-md-12">
        <h1 class="mb-4">
            <i class="fas fa-gem text-warning me-2"></i>
            <span style="color:#FFD700;">Dashboard</span>
        </h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4 fade-in">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div style="font-size: 40px; color: #3498db; margin-bottom: 15px;">
                    <i class="fas fa-list"></i>
                </div>
                <h3 class="card-title">{{ $totalReservasi }}</h3>
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
                <h3 class="card-title">{{ $reservasiPending }}</h3>
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
                <h3 class="card-title">{{ $reservasiConfirmed }}</h3>
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
                <h3 class="card-title" style="font-size: 24px;">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </h3>
                <p class="card-text text-muted">Total Pendapatan</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4 fade-in">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt text-warning me-2"></i>Akses Cepat</h5>
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
<div class="row mt-4 welcome-anim">
    <div class="col-md-12">
        <div class="card bg-light">
            <div class="card-body text-center">
                <h5>
                    <i class="fas fa-crown text-warning me-2"></i>
                    Selamat datang, <strong>{{ Auth::user()->name }}</strong>!
                </h5>
                <p class="text-white mb-0">Gunakan menu di sebelah kiri untuk mengelola reservasi hotel Anda.</p>
            </div>
        </div>
    </div>
</div>
@endsection

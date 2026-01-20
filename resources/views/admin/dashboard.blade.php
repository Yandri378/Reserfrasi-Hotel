@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h1 class="mb-4">👨‍💼 Admin Dashboard - Manajemen Reservasi</h1>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div style="font-size: 40px; color: #3498db; margin-bottom: 10px;">
                    <i class="fas fa-list"></i>
                </div>
                <h5>{{ $totalReservasi }}</h5>
                <p class="text-muted mb-0">Total Reservasi</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div style="font-size: 40px; color: #f39c12; margin-bottom: 10px;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <h5>{{ $pendingReservasi }}</h5>
                <p class="text-muted mb-0">Pending (Menunggu ACC)</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div style="font-size: 40px; color: #27ae60; margin-bottom: 10px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h5>{{ $confirmedReservasi }}</h5>
                <p class="text-muted mb-0">Confirmed</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <div style="font-size: 40px; color: #e74c3c; margin-bottom: 10px;">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h5>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h5>
                <p class="text-muted mb-0">Total Pendapatan</p>
            </div>
        </div>
    </div>
</div>

<!-- Pending Reservasi -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">⏳ Reservasi Menunggu Persetujuan</h5>
            </div>
            <div class="card-body">
                @if($reservasiPending->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tamu</th>
                                    <th>Email</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Kamar</th>
                                    <th>Total Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservasiPending as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_tamu }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_check_in)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_check_out)->format('d-m-Y') }}</td>
                                        <td class="text-capitalize">{{ str_replace('_', ' ', $item->jenis_kamar) }}</td>
                                        <td><strong>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong></td>
                                        <td>
                                            <a href="{{ route('admin.detail', $item) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> Tidak ada reservasi yang menunggu persetujuan. Semua sudah di-approve!
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">⚡ Akses Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('admin.all-reservasi') }}" class="btn btn-primary w-100">
                            <i class="fas fa-list"></i> Lihat Semua Reservasi
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('analytics.dashboard') }}" class="btn btn-success w-100">
                            <i class="fas fa-chart-bar"></i> Lihat Analytics
                        </a>
                    </div>
                    <div class="col-md-4 mb-2">
                        <a href="{{ route('analytics.dashboard') }}" class="btn btn-warning w-100">
                            <i class="fas fa-file-pdf"></i> Export Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

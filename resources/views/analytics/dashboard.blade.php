@extends('layouts.app')

@section('title', 'Analytics & Laporan')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
    .chart-container {
        position: relative;
        height: 400px;
        margin-bottom: 40px;
    }
    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        text-align: center;
    }
    .stat-card h3 {
        color: #999;
        font-size: 12px;
        text-transform: uppercase;
        margin: 0 0 10px 0;
    }
    .stat-card .value {
        font-size: 32px;
        font-weight: bold;
        color: #2c3e50;
    }
</style>
@endsection

@section('content')
<h1 class="mb-4">📊 Analytics & Laporan</h1>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <h3>Total Reservasi</h3>
            <div class="value">{{ $totalReservasi }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3>Bulan Ini</h3>
            <div class="value">{{ $reservasiBulanIni }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3>Total Pendapatan</h3>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <h3>Rata-rata Harga</h3>
            <div class="value">Rp {{ number_format($rataRataHarga, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<!-- Chart: Grafik Harian -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">📈 Grafik Reservasi Harian (30 Hari Terakhir)</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="chartHarian"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart: Grafik Bulanan -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">📊 Grafik Reservasi Bulanan (12 Bulan Terakhir)</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="chartBulanan"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart: Status Breakdown -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">🏷️ Status Reservasi</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart: Jenis Kamar -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">🛏️ Jenis Kamar</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="chartKamar"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Laporan PDF -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">📄 Export Laporan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6>Laporan Bulanan</h6>
                        <form action="{{ route('pdf.laporan-bulanan') }}" method="GET" class="form-inline">
                            <div class="row w-100">
                                <div class="col-md-5">
                                    <select name="bulan" class="form-control" required>
                                        <option value="">-- Pilih Bulan --</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::createFromDate(now()->year, $i, 1)->locale('id')->isoFormat('MMMM') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <select name="tahun" class="form-control" required>
                                        <option value="">-- Pilih Tahun --</option>
                                        @for($i = now()->year; $i >= now()->year - 5; $i--)
                                            <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-file-pdf"></i> Download
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h6>Laporan Tahunan</h6>
                        <form action="{{ route('pdf.laporan-tahunan') }}" method="GET" class="form-inline">
                            <div class="row w-100">
                                <div class="col-md-7">
                                    <select name="tahun" class="form-control" required>
                                        <option value="">-- Pilih Tahun --</option>
                                        @for($i = now()->year; $i >= now()->year - 10; $i--)
                                            <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fas fa-file-pdf"></i> Download
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Breakdown Bulanan -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">📋 Breakdown Reservasi per Bulan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Bulan</th>
                                <th>Jumlah Reservasi</th>
                                <th>Total Pendapatan</th>
                                <th>Rata-rata</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataBulanan as $data)
                                <tr>
                                    <td>{{ $data['bulan'] }}</td>
                                    <td>{{ $data['jumlah'] }}</td>
                                    <td>Rp {{ number_format($data['pendapatan'], 0, ',', '.') }}</td>
                                    <td>
                                        @if($data['jumlah'] > 0)
                                            Rp {{ number_format($data['pendapatan'] / $data['jumlah'], 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Grafik Harian
    new Chart(document.getElementById('chartHarian'), {
        type: 'line',
        data: {
            labels: {!! json_encode($labelHarian) !!},
            datasets: [{
                label: 'Jumlah Reservasi',
                data: {!! json_encode($grafikHarian) !!},
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3498db',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'top' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Grafik Bulanan
    new Chart(document.getElementById('chartBulanan'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($labelBulanan) !!},
            datasets: [{
                label: 'Jumlah Reservasi',
                data: {!! json_encode($grafikBulanan) !!},
                backgroundColor: '#3498db',
                borderColor: '#2980b9',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'top' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Chart Status
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Confirmed', 'Checked In', 'Checked Out', 'Cancelled'],
            datasets: [{
                data: [
                    {{ $statusData['pending'] }},
                    {{ $statusData['confirmed'] }},
                    {{ $statusData['checked_in'] }},
                    {{ $statusData['checked_out'] }},
                    {{ $statusData['cancelled'] }}
                ],
                backgroundColor: [
                    '#f39c12',
                    '#27ae60',
                    '#3498db',
                    '#95a5a6',
                    '#e74c3c'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' }
            }
        }
    });

    // Chart Jenis Kamar
    new Chart(document.getElementById('chartKamar'), {
        type: 'pie',
        data: {
            labels: ['Standar', 'Deluxe', 'Suite', 'Presidential'],
            datasets: [{
                data: [
                    {{ $jenisKamarData['standar'] }},
                    {{ $jenisKamarData['deluxe'] }},
                    {{ $jenisKamarData['suite'] }},
                    {{ $jenisKamarData['presidential'] }}
                ],
                backgroundColor: [
                    '#9b59b6',
                    '#3498db',
                    '#1abc9c',
                    '#e67e22'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' }
            }
        }
    });
</script>
@endsection

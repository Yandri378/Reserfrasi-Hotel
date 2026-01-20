<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            gap: 15px;
        }
        .stat-box {
            flex: 1;
            background: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .stat-box h3 {
            margin: 0 0 5px 0;
            color: #999;
            font-size: 12px;
            text-transform: uppercase;
        }
        .stat-box .value {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
        }
        .section-title {
            background: #3498db;
            color: white;
            padding: 12px 15px;
            margin: 25px 0 15px 0;
            font-weight: bold;
            font-size: 14px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th {
            background: #34495e;
            color: white;
            border: 1px solid #2c3e50;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
        }
        .table td {
            border: 1px solid #bdc3c7;
            padding: 10px;
            font-size: 12px;
        }
        .table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #bdc3c7;
            color: #999;
            font-size: 11px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN RESERVASI TAHUNAN</h1>
            <p>Tahun: {{ $tahun }}</p>
            <p>Tanggal Cetak: {{ now()->format('d-m-Y H:i:s') }}</p>
        </div>

        <!-- Statistics -->
        <div class="stats">
            <div class="stat-box">
                <h3>Total Reservasi</h3>
                <div class="value">{{ $totalReservasi }}</div>
            </div>
            <div class="stat-box">
                <h3>Confirmed</h3>
                <div class="value">{{ $statusConfirmed }}</div>
            </div>
            <div class="stat-box">
                <h3>Completed</h3>
                <div class="value">{{ $statusCompleted }}</div>
            </div>
            <div class="stat-box">
                <h3>Total Pendapatan</h3>
                <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Breakdown Per Bulan -->
        <div class="section-title">📊 BREAKDOWN BULANAN</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Jumlah Reservasi</th>
                    <th>Total Pendapatan</th>
                    <th>Rata-rata per Reservasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($perBulan as $bulan)
                    <tr>
                        <td>{{ $bulan['nama'] }}</td>
                        <td>{{ $bulan['count'] }}</td>
                        <td class="text-right">Rp {{ number_format($bulan['total'], 0, ',', '.') }}</td>
                        <td class="text-right">
                            @if($bulan['count'] > 0)
                                Rp {{ number_format($bulan['total'] / $bulan['count'], 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Detail Semua Reservasi -->
        <div class="page-break"></div>
        <div class="section-title">📋 DETAIL SEMUA RESERVASI</div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tamu</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Kamar</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_tamu }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_check_in)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_check_out)->format('d-m-Y') }}</td>
                        <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $item->jenis_kamar) }}</td>
                        <td class="text-right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $item->status)) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #999;">Tidak ada data reservasi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini dibuat secara otomatis oleh Sistem Manajemen Reservasi Hotel</p>
            <p>&copy; {{ now()->year }} - Hotel Reservation System. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>

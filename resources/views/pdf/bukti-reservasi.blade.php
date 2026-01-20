<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #333;
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .section-title {
            background: #3498db;
            color: white;
            padding: 8px 15px;
            margin: 20px 0 10px 0;
            font-weight: bold;
        }
        .content {
            margin: 20px 0;
        }
        .row {
            display: flex;
            margin-bottom: 12px;
        }
        .label {
            width: 150px;
            font-weight: bold;
            color: #333;
        }
        .value {
            flex: 1;
            color: #555;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table th {
            background: #ecf0f1;
            border: 1px solid #bdc3c7;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        .table td {
            border: 1px solid #bdc3c7;
            padding: 10px;
        }
        .table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .summary {
            background: #ecf0f1;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #bdc3c7;
            color: #999;
            font-size: 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
        }
        .status-pending {
            background: #f39c12;
        }
        .status-confirmed {
            background: #27ae60;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🏨 BUKTI RESERVASI HOTEL</h1>
            <p>Nomor Reservasi: {{ str_pad($reservasi->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p>Tanggal Cetak: {{ now()->format('d-m-Y H:i:s') }}</p>
        </div>

        <!-- Data Tamu -->
        <div class="section-title">📋 DATA TAMU</div>
        <div class="content">
            <div class="row">
                <div class="label">Nama Tamu:</div>
                <div class="value">{{ $reservasi->nama_tamu }}</div>
            </div>
            <div class="row">
                <div class="label">Email:</div>
                <div class="value">{{ $reservasi->email }}</div>
            </div>
            <div class="row">
                <div class="label">No. Telepon:</div>
                <div class="value">{{ $reservasi->no_telpon }}</div>
            </div>
            <div class="row">
                <div class="label">Jumlah Tamu:</div>
                <div class="value">{{ $reservasi->jumlah_tamu }} orang</div>
            </div>
        </div>

        <!-- Detail Reservasi -->
        <div class="section-title">🔑 DETAIL RESERVASI</div>
        <div class="content">
            <div class="row">
                <div class="label">Check-in:</div>
                <div class="value">{{ \Carbon\Carbon::parse($reservasi->tanggal_check_in)->format('d-m-Y') }}</div>
            </div>
            <div class="row">
                <div class="label">Check-out:</div>
                <div class="value">{{ \Carbon\Carbon::parse($reservasi->tanggal_check_out)->format('d-m-Y') }}</div>
            </div>
            <div class="row">
                <div class="label">Durasi Menginap:</div>
                <div class="value">{{ $reservasi->jumlah_malam }} malam</div>
            </div>
            <div class="row">
                <div class="label">Jenis Kamar:</div>
                <div class="value" style="text-transform: capitalize;">{{ str_replace('_', ' ', $reservasi->jenis_kamar) }}</div>
            </div>
            <div class="row">
                <div class="label">No. Kamar:</div>
                <div class="value">{{ $reservasi->no_kamar ?? 'Belum ditetapkan' }}</div>
            </div>
            <div class="row">
                <div class="label">Status:</div>
                <div class="value">
                    <span class="status-badge status-{{ $reservasi->status }}">
                        {{ ucwords(str_replace('_', ' ', $reservasi->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Ringkasan Harga -->
        <div class="section-title">💰 RINGKASAN HARGA</div>
        <div class="summary">
            <div class="summary-row">
                <span>Harga per Malam:</span>
                <span>Rp {{ number_format($reservasi->harga_per_malam, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Jumlah Malam:</span>
                <span>{{ $reservasi->jumlah_malam }} × Rp {{ number_format($reservasi->harga_per_malam, 0, ',', '.') }}</span>
            </div>
            <hr style="margin: 10px 0; border: none; border-top: 1px solid #bdc3c7;">
            <div class="summary-row" style="font-size: 18px; color: #e74c3c;">
                <span>TOTAL HARGA:</span>
                <span>Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($reservasi->catatan)
            <div class="section-title">📝 CATATAN</div>
            <div class="content">
                <div class="value">{{ $reservasi->catatan }}</div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Bukti ini menunjukkan bahwa Anda telah melakukan reservasi di hotel kami.</p>
            <p>Harap tunjukkan bukti ini saat check-in.</p>
            <p>Terima kasih telah mempercayai kami!</p>
        </div>
    </div>
</body>
</html>

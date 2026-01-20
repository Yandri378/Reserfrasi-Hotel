@extends('layouts.app')

@section('title', 'Semua Reservasi - Admin')

@section('content')
<style>
    /* Elegant gold and dark theme */
    body {
        font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
        background: linear-gradient(135deg, #232526 0%, #414345 100%);
        color: #fff;
    }
    .card {
        background: rgba(34, 34, 34, 0.95);
        border-radius: 18px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        border: 1px solid rgba(255, 215, 0, 0.08);
        margin-bottom: 2rem;
        transition: box-shadow 0.3s;
    }
    .card:hover {
        box-shadow: 0 12px 40px 0 rgba(255, 215, 0, 0.18);
    }
    .card-header {
        background: linear-gradient(90deg, #232526 60%, #FFD700 100%);
        color: #fff;
        border-radius: 18px 18px 0 0;
        border-bottom: 1px solid #FFD700;
    }
    .form-label {
        color: #FFD700;
        font-weight: 500;
    }
    .form-control, .form-select {
        background: #232526;
        color: #fff;
        border: 1px solid #FFD700;
        border-radius: 8px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #fff;
        box-shadow: 0 0 0 2px #FFD70033;
    }
    .btn-primary {
        background: linear-gradient(90deg, #FFD700 60%, #bfa100 100%);
        border: none;
        color: #232526;
        font-weight: 600;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px 0 rgba(255, 215, 0, 0.15);
    }
    .btn-primary:hover {
        transform: scale(1.05);
        background: linear-gradient(90deg, #bfa100 60%, #FFD700 100%);
        color: #232526;
        box-shadow: 0 4px 16px 0 rgba(255, 215, 0, 0.25);
    }
    .table {
        color: #fff;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 0;
    }
    .table-dark {
        background: linear-gradient(90deg, #232526 60%, #FFD700 100%);
        color: #fff;
    }
    .table-hover tbody tr {
        transition: background 0.2s, transform 0.2s;
    }
    .table-hover tbody tr:hover {
        background: #FFD70022;
        transform: scale(1.01);
        cursor: pointer;
    }
    .badge.bg-warning { background: linear-gradient(90deg, #FFD700 60%, #bfa100 100%); color: #232526; }
    .badge.bg-success { background: linear-gradient(90deg, #43e97b 60%, #38f9d7 100%); }
    .badge.bg-info { background: linear-gradient(90deg, #56ccf2 60%, #2f80ed 100%); }
    .badge.bg-secondary { background: linear-gradient(90deg, #757f9a 60%, #d7dde8 100%); color: #232526; }
    .badge.bg-danger { background: linear-gradient(90deg, #ff5858 60%, #f09819 100%); }
    .btn-info {
        background: linear-gradient(90deg, #56ccf2 60%, #2f80ed 100%);
        border: none;
        color: #fff;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-info:hover {
        transform: scale(1.08);
        background: linear-gradient(90deg, #2f80ed 60%, #56ccf2 100%);
        color: #fff;
        box-shadow: 0 4px 16px 0 rgba(86, 204, 242, 0.25);
    }
    .pagination .page-link {
        background: #232526;
        color: #FFD700;
        border: 1px solid #FFD700;
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(90deg, #FFD700 60%, #bfa100 100%);
        color: #232526;
        border: none;
    }
    /* Animasi fade-in */
    .fade-in {
        animation: fadeIn 1s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px);}
        to { opacity: 1; transform: translateY(0);}
    }
</style>

<h1 class="mb-4 fade-in">
    <i class="fas fa-clipboard-list me-2 text-warning"></i>
    <span style="color:#FFD700;">Semua Reservasi</span>
</h1>

<!-- Filter -->
<div class="card fade-in">
    <div class="card-header">
        <h6 class="mb-0">
            <i class="fas fa-filter me-2 text-warning"></i>
            <span style="color:#FFD700;">Filter</span>
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.all-reservasi') }}" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label"><i class="fas fa-info-circle me-1"></i>Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="from_date" class="form-label"><i class="fas fa-calendar-alt me-1"></i>Dari Tanggal</label>
                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label for="to_date" class="form-label"><i class="fas fa-calendar-check me-1"></i>Sampai Tanggal</label>
                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Daftar Reservasi -->
<div class="card fade-in">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-chart-bar me-2 text-warning"></i>
            <span style="color:#FFD700;">Total: {{ $reservasi->total() }} Reservasi</span>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-hashtag"></i> No</th>
                        <th><i class="fas fa-user"></i> Nama Tamu</th>
                        <th><i class="fas fa-envelope"></i> Email</th>
                        <th><i class="fas fa-sign-in-alt"></i> Check-in</th>
                        <th><i class="fas fa-sign-out-alt"></i> Check-out</th>
                        <th><i class="fas fa-bed"></i> Kamar</th>
                        <th><i class="fas fa-money-bill-wave"></i> Total</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                        <th><i class="fas fa-cogs"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservasi as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($reservasi->currentPage() - 1) * $reservasi->perPage() }}</td>
                            <td>{{ $item->nama_tamu }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_check_in)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_check_out)->format('d-m-Y') }}</td>
                            <td class="text-capitalize">{{ str_replace('_', ' ', $item->jenis_kamar) }}</td>
                            <td><strong>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong></td>
                            <td>
                                @php
                                    $statusColor = [
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'checked_in' => 'info',
                                        'checked_out' => 'secondary',
                                        'cancelled' => 'danger',
                                    ];
                                    $color = $statusColor[$item->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} text-capitalize px-3 py-2 fs-6 shadow-sm">
                                    <i class="fas fa-circle me-1"></i>
                                    {{ str_replace('_', ' ', $item->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.detail', $item) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <p class="text-muted"><i class="fas fa-info-circle me-2"></i>Tidak ada reservasi yang sesuai dengan filter</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $reservasi->links() }}
        </div>
    </div>
</div>
@endsection

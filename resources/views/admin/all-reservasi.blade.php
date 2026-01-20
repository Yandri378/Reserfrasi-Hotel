@extends('layouts.app')

@section('title', 'Semua Reservasi - Admin')

@section('content')
<h1 class="mb-4">📋 Semua Reservasi</h1>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-header">
        <h6 class="mb-0">🔍 Filter</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.all-reservasi') }}" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
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
                <label for="from_date" class="form-label">Dari Tanggal</label>
                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>

            <div class="col-md-3">
                <label for="to_date" class="form-label">Sampai Tanggal</label>
                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>

            <div class="col-md-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Daftar Reservasi -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">📊 Total: {{ $reservasi->total() }} Reservasi</h5>
    </div>
    <div class="card-body">
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
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
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
                                <span class="badge bg-{{ $color }} text-capitalize">
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
                                <p class="text-muted">Tidak ada reservasi yang sesuai dengan filter</p>
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

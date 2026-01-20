@extends('layouts.app')

@section('title', 'Detail Reservasi - Admin')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">📋 Detail Reservasi #{{ str_pad($reservasi->id, 6, '0', STR_PAD_LEFT) }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">📌 Data Tamu</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Nama:</strong></td>
                                <td>{{ $reservasi->nama_tamu }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $reservasi->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. Telpon:</strong></td>
                                <td>{{ $reservasi->no_telpon }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Tamu:</strong></td>
                                <td>{{ $reservasi->jumlah_tamu }} orang</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-muted">🔑 Detail Check-in/out</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Check-in:</strong></td>
                                <td>{{ \Carbon\Carbon::parse($reservasi->tanggal_check_in)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Check-out:</strong></td>
                                <td>{{ \Carbon\Carbon::parse($reservasi->tanggal_check_out)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Durasi:</strong></td>
                                <td>{{ $reservasi->jumlah_malam }} malam</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @php
                                        $statusColor = [
                                            'pending' => 'warning',
                                            'confirmed' => 'success',
                                            'checked_in' => 'info',
                                            'checked_out' => 'secondary',
                                            'cancelled' => 'danger',
                                        ];
                                        $color = $statusColor[$reservasi->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }} text-capitalize">
                                        {{ str_replace('_', ' ', $reservasi->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">🛏️ Detail Kamar</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Jenis Kamar:</strong></td>
                                <td class="text-capitalize">{{ str_replace('_', ' ', $reservasi->jenis_kamar) }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. Kamar:</strong></td>
                                <td>{{ $reservasi->no_kamar ?? 'Belum ditetapkan' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Harga/Malam:</strong></td>
                                <td>Rp {{ number_format($reservasi->harga_per_malam, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-muted">💰 Ringkasan Harga</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Subtotal:</strong></td>
                                <td>Rp {{ number_format($reservasi->harga_per_malam * $reservasi->jumlah_malam, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pajak/Biaya:</strong></td>
                                <td>Rp 0</td>
                            </tr>
                            <tr class="table-active">
                                <td><strong>Total Harga:</strong></td>
                                <td><strong>Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($reservasi->catatan)
                    <hr>
                    <h6 class="text-muted">📝 Catatan</h6>
                    <p>{{ $reservasi->catatan }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Action Panel -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">⚡ Tindakan Admin</h5>
            </div>
            <div class="card-body">
                @if($reservasi->status == 'pending')
                    <!-- Approve -->
                    <form action="{{ route('admin.approve', $reservasi) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mb-2" onclick="return confirm('Setujui reservasi ini?')">
                            <i class="fas fa-check-circle"></i> Approve
                        </button>
                    </form>

                    <!-- Reject -->
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times-circle"></i> Reject
                    </button>
                @else
                    <div class="alert alert-info">
                        <p class="mb-0"><strong>Status saat ini:</strong> <span class="badge bg-info">{{ ucwords(str_replace('_', ' ', $reservasi->status)) }}</span></p>
                    </div>

                    <form action="{{ route('admin.updateStatus', $reservasi) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">Update Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $reservasi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $reservasi->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="checked_in" {{ $reservasi->status == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                                <option value="checked_out" {{ $reservasi->status == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                                <option value="cancelled" {{ $reservasi->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                @endif

                <hr>

                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">ℹ️ Informasi</h6>
            </div>
            <div class="card-body" style="font-size: 12px;">
                <p><strong>Dibuat:</strong> {{ $reservasi->created_at->format('d-m-Y H:i') }}</p>
                <p><strong>Diupdate:</strong> {{ $reservasi->updated_at->format('d-m-Y H:i') }}</p>
                <p class="mb-0"><strong>ID Tamu:</strong> {{ $reservasi->user_id }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">❌ Tolak Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.reject', $reservasi) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="alasan" class="form-control @error('alasan') is-invalid @enderror" rows="4" placeholder="Masukkan alasan penolakan..." required></textarea>
                        @error('alasan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menolak reservasi ini?')">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

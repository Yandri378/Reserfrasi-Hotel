@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Detail Reservasi</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Data Tamu</h6>
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
                                    <td><strong>No. Telepon:</strong></td>
                                    <td>{{ $reservasi->no_telpon }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Tamu:</strong></td>
                                    <td>{{ $reservasi->jumlah_tamu }} orang</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted">Status & Tanggal</h6>
                            <table class="table table-sm table-borderless">
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
                                <tr>
                                    <td><strong>Check-in:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($reservasi->tanggal_check_in)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Check-out:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($reservasi->tanggal_check_out)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>No. Kamar:</strong></td>
                                    <td>{{ $reservasi->no_kamar ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Detail Kamar</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>Jenis Kamar:</strong></td>
                                    <td class="text-capitalize">{{ str_replace('_', ' ', $reservasi->jenis_kamar) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Malam:</strong></td>
                                    <td>{{ $reservasi->jumlah_malam }} malam</td>
                                </tr>
                                <tr>
                                    <td><strong>Harga per Malam:</strong></td>
                                    <td>Rp {{ number_format($reservasi->harga_per_malam, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted">Ringkasan Harga</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>Subtotal:</strong></td>
                                    <td>Rp {{ number_format($reservasi->harga_per_malam * $reservasi->jumlah_malam, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pajak & Biaya:</strong></td>
                                    <td>Rp 0</td>
                                </tr>
                                <tr class="table-active">
                                    <td><strong>Total Harga:</strong></td>
                                    <td><strong>Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if ($reservasi->catatan)
                        <hr>
                        <h6 class="text-muted">Catatan</h6>
                        <p>{{ $reservasi->catatan }}</p>
                    @endif

                    <hr>

                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('reservasi.index') }}" class="btn btn-secondary w-100">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('reservasi.edit', $reservasi) }}" class="btn btn-warning w-100">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('pdf.bukti', $reservasi) }}" class="btn btn-primary w-100" target="_blank">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('reservasi.destroy', $reservasi) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

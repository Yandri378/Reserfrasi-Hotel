@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Daftar Reservasi</h4>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <a href="{{ route('reservasi.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> Tambah Reservasi
                    </a>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tamu</th>
                                    <th>Email</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Jenis Kamar</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reservasi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_tamu }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_check_in)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_check_out)->format('d-m-Y') }}</td>
                                        <td>
                                            <span class="badge bg-info text-capitalize">
                                                {{ str_replace('_', ' ', $item->jenis_kamar) }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
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
                                            <a href="{{ route('reservasi.show', $item) }}" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('reservasi.edit', $item) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('reservasi.destroy', $item) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-muted">Tidak ada data reservasi</p>
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
        </div>
    </div>
</div>
@endsection

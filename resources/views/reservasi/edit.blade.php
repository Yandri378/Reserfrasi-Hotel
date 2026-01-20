@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Reservasi</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Ada kesalahan!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('reservasi.update', $reservasi) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_tamu" class="form-label">Nama Tamu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_tamu') is-invalid @enderror" 
                                       id="nama_tamu" name="nama_tamu" value="{{ old('nama_tamu', $reservasi->nama_tamu) }}" required>
                                @error('nama_tamu') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $reservasi->email) }}" required>
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="no_telpon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_telpon') is-invalid @enderror" 
                                       id="no_telpon" name="no_telpon" value="{{ old('no_telpon', $reservasi->no_telpon) }}" required>
                                @error('no_telpon') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jumlah_tamu" class="form-label">Jumlah Tamu <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('jumlah_tamu') is-invalid @enderror" 
                                       id="jumlah_tamu" name="jumlah_tamu" value="{{ old('jumlah_tamu', $reservasi->jumlah_tamu) }}" min="1" required>
                                @error('jumlah_tamu') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_check_in" class="form-label">Tanggal Check-in <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_check_in') is-invalid @enderror" 
                                       id="tanggal_check_in" name="tanggal_check_in" 
                                       value="{{ old('tanggal_check_in', $reservasi->tanggal_check_in) }}" required>
                                @error('tanggal_check_in') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_check_out" class="form-label">Tanggal Check-out <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_check_out') is-invalid @enderror" 
                                       id="tanggal_check_out" name="tanggal_check_out" 
                                       value="{{ old('tanggal_check_out', $reservasi->tanggal_check_out) }}" required>
                                @error('tanggal_check_out') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jenis_kamar" class="form-label">Jenis Kamar <span class="text-danger">*</span></label>
                                <select class="form-select @error('jenis_kamar') is-invalid @enderror" 
                                        id="jenis_kamar" name="jenis_kamar" required onchange="updateHarga()">
                                    @foreach ($hargaKamar as $key => $harga)
                                        <option value="{{ $key }}" data-harga="{{ $harga }}" 
                                                {{ old('jenis_kamar', $reservasi->jenis_kamar) == $key ? 'selected' : '' }}>
                                            {{ ucfirst($key) }} - Rp {{ number_format($harga, 0, ',', '.') }}/malam
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_kamar') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="harga_per_malam" class="form-label">Harga per Malam <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="harga_per_malam_display" disabled>
                                <input type="hidden" id="harga_per_malam" name="harga_per_malam" 
                                       value="{{ old('harga_per_malam', $reservasi->harga_per_malam) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="pending" {{ old('status', $reservasi->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('status', $reservasi->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="checked_in" {{ old('status', $reservasi->status) == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                                    <option value="checked_out" {{ old('status', $reservasi->status) == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                                    <option value="cancelled" {{ old('status', $reservasi->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                      id="catatan" name="catatan" rows="3">{{ old('catatan', $reservasi->catatan) }}</textarea>
                            @error('catatan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('reservasi.index') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-save"></i> Update Reservasi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateHarga() {
        const select = document.getElementById('jenis_kamar');
        const selectedOption = select.options[select.selectedIndex];
        const harga = selectedOption.dataset.harga;
        
        document.getElementById('harga_per_malam').value = harga;
        document.getElementById('harga_per_malam_display').value = 'Rp ' + 
            parseInt(harga).toLocaleString('id-ID');
    }

    // Update harga saat page load
    window.addEventListener('load', updateHarga);
</script>
@endsection

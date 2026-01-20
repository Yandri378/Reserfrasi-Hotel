<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi';

    protected $fillable = [
        'user_id',
        'nama_tamu',
        'email',
        'no_telpon',
        'no_kamar',
        'tanggal_check_in',
        'tanggal_check_out',
        'jumlah_malam',
        'jumlah_tamu',
        'jenis_kamar',
        'harga_per_malam',
        'total_harga',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal_check_in' => 'date',
        'tanggal_check_out' => 'date',
        'harga_per_malam' => 'decimal:2',
        'total_harga' => 'decimal:2',
    ];

    /**
     * Relasi dengan User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hitung jumlah malam
     */
    public function hitungJumlahMalam()
    {
        $checkIn = \Carbon\Carbon::parse($this->tanggal_check_in);
        $checkOut = \Carbon\Carbon::parse($this->tanggal_check_out);
        return $checkOut->diffInDays($checkIn);
    }

    /**
     * Hitung total harga
     */
    public function hitungTotalHarga()
    {
        return $this->jumlah_malam * $this->harga_per_malam;
    }
}

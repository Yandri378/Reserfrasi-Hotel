<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservasi = Reservasi::with('user')->latest()->paginate(10);
        return view('reservasi.index', compact('reservasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hargaKamar = [
            'standar' => 500000,
            'deluxe' => 750000,
            'suite' => 1000000,
            'presidential' => 1500000,
        ];
        return view('reservasi.create', compact('hargaKamar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telpon' => 'required|string|max:15',
            'tanggal_check_in' => 'required|date|after_or_equal:today',
            'tanggal_check_out' => 'required|date|after:tanggal_check_in',
            'jumlah_tamu' => 'required|integer|min:1',
            'jenis_kamar' => 'required|in:standar,deluxe,suite,presidential',
            'harga_per_malam' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        // Hitung jumlah malam
        $checkIn = \Carbon\Carbon::parse($validated['tanggal_check_in']);
        $checkOut = \Carbon\Carbon::parse($validated['tanggal_check_out']);
        $jumlahMalam = $checkOut->diffInDays($checkIn);

        // Hitung total harga
        $totalHarga = $jumlahMalam * $validated['harga_per_malam'];

        // Tambahkan data tambahan
        $validated['user_id'] = auth()->id() ?? 1;
        $validated['jumlah_malam'] = $jumlahMalam;
        $validated['total_harga'] = $totalHarga;
        $validated['status'] = 'pending';

        Reservasi::create($validated);

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservasi $reservasi)
    {
        return view('reservasi.show', compact('reservasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservasi $reservasi)
    {
        $hargaKamar = [
            'standar' => 500000,
            'deluxe' => 750000,
            'suite' => 1000000,
            'presidential' => 1500000,
        ];
        return view('reservasi.edit', compact('reservasi', 'hargaKamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservasi $reservasi)
    {
        $validated = $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telpon' => 'required|string|max:15',
            'tanggal_check_in' => 'required|date',
            'tanggal_check_out' => 'required|date|after:tanggal_check_in',
            'jumlah_tamu' => 'required|integer|min:1',
            'jenis_kamar' => 'required|in:standar,deluxe,suite,presidential',
            'harga_per_malam' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
        ]);

        // Hitung jumlah malam
        $checkIn = \Carbon\Carbon::parse($validated['tanggal_check_in']);
        $checkOut = \Carbon\Carbon::parse($validated['tanggal_check_out']);
        $jumlahMalam = $checkOut->diffInDays($checkIn);

        // Hitung total harga
        $totalHarga = $jumlahMalam * $validated['harga_per_malam'];

        $validated['jumlah_malam'] = $jumlahMalam;
        $validated['total_harga'] = $totalHarga;

        $reservasi->update($validated);

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservasi $reservasi)
    {
        $reservasi->delete();
        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil dihapus!');
    }
}

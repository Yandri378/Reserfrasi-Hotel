<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard dengan pending reservasi
     */
    public function index()
    {
        $totalReservasi = Reservasi::count();
        $pendingReservasi = Reservasi::where('status', 'pending')->count();
        $confirmedReservasi = Reservasi::where('status', 'confirmed')->count();
        $totalPendapatan = Reservasi::sum('total_harga');

        $reservasiPending = Reservasi::where('status', 'pending')->with('user')->latest()->get();

        return view('admin.dashboard', compact(
            'totalReservasi',
            'pendingReservasi',
            'confirmedReservasi',
            'totalPendapatan',
            'reservasiPending'
        ));
    }

    /**
     * Lihat detail reservasi untuk approval
     */
    public function detail(Reservasi $reservasi)
    {
        return view('admin.detail-reservasi', compact('reservasi'));
    }

    /**
     * Approve/Accept reservasi (ubah status pending ke confirmed)
     */
    public function approve(Reservasi $reservasi)
    {
        if ($reservasi->status !== 'pending') {
            return back()->with('error', 'Hanya reservasi dengan status pending yang bisa di-approve!');
        }

        $reservasi->update(['status' => 'confirmed']);

        return back()->with('success', 'Reservasi berhasil di-approve! Status diubah menjadi Confirmed.');
    }

    /**
     * Reject/Tolak reservasi
     */
    public function reject(Reservasi $reservasi, Request $request)
    {
        $validated = $request->validate([
            'alasan' => 'required|string|min:10',
        ]);

        if ($reservasi->status !== 'pending') {
            return back()->with('error', 'Hanya reservasi dengan status pending yang bisa di-reject!');
        }

        $reservasi->update([
            'status' => 'cancelled',
            'catatan' => ($reservasi->catatan ? $reservasi->catatan . "\n" : "") . "Ditolak. Alasan: " . $validated['alasan'],
        ]);

        return back()->with('success', 'Reservasi berhasil ditolak.');
    }

    /**
     * Update status reservasi
     */
    public function updateStatus(Reservasi $reservasi, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
        ]);

        $reservasi->update(['status' => $validated['status']]);

        return back()->with('success', 'Status reservasi berhasil diperbarui menjadi ' . $validated['status']);
    }

    /**
     * Lihat semua reservasi
     */
    public function allReservasi(Request $request)
    {
        $query = Reservasi::with('user');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from_date') && $request->from_date != '') {
            $query->whereDate('tanggal_check_in', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date != '') {
            $query->whereDate('tanggal_check_out', '<=', $request->to_date);
        }

        $reservasi = $query->latest()->paginate(15);

        return view('admin.all-reservasi', compact('reservasi'));
    }
}

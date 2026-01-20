<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PDFController extends Controller
{
    /**
     * Cetak bukti reservasi PDF
     */
    public function printBukti(Reservasi $reservasi)
    {
        $pdf = Pdf::loadView('pdf.bukti-reservasi', ['reservasi' => $reservasi]);
        return $pdf->download('Bukti-Reservasi-' . $reservasi->id . '.pdf');
    }

    /**
     * Export laporan bulanan PDF
     */
    public function laporanBulanan(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $reservasi = Reservasi::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->with('user')
            ->get();

        $totalReservasi = $reservasi->count();
        $totalPendapatan = $reservasi->sum('total_harga');
        $statusConfirmed = $reservasi->where('status', 'confirmed')->count();
        $statusCompleted = $reservasi->where('status', 'checked_out')->count();

        $namabulan = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');

        $pdf = Pdf::loadView('pdf.laporan-bulanan', compact(
            'reservasi',
            'bulan',
            'tahun',
            'namabulan',
            'totalReservasi',
            'totalPendapatan',
            'statusConfirmed',
            'statusCompleted'
        ));

        return $pdf->download('Laporan-Reservasi-' . $namabulan . '.pdf');
    }

    /**
     * Export laporan tahunan PDF
     */
    public function laporanTahunan(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);

        $reservasi = Reservasi::whereYear('created_at', $tahun)
            ->with('user')
            ->get();

        $totalReservasi = $reservasi->count();
        $totalPendapatan = $reservasi->sum('total_harga');
        $statusConfirmed = $reservasi->where('status', 'confirmed')->count();
        $statusCompleted = $reservasi->where('status', 'checked_out')->count();

        // Breakdown per bulan
        $perBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanData = $reservasi->filter(function ($item) use ($i) {
                return $item->created_at->month == $i;
            });

            $perBulan[$i] = [
                'nama' => Carbon::createFromDate($tahun, $i, 1)->locale('id')->isoFormat('MMMM'),
                'count' => $bulanData->count(),
                'total' => $bulanData->sum('total_harga'),
            ];
        }

        $pdf = Pdf::loadView('pdf.laporan-tahunan', compact(
            'reservasi',
            'tahun',
            'totalReservasi',
            'totalPendapatan',
            'statusConfirmed',
            'statusCompleted',
            'perBulan'
        ));

        return $pdf->download('Laporan-Tahunan-' . $tahun . '.pdf');
    }

    /**
     * View laporan bulanan (preview)
     */
    public function viewLaporanBulanan(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $reservasi = Reservasi::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->with('user')
            ->get();

        $totalReservasi = $reservasi->count();
        $totalPendapatan = $reservasi->sum('total_harga');
        $statusConfirmed = $reservasi->where('status', 'confirmed')->count();
        $statusCompleted = $reservasi->where('status', 'checked_out')->count();

        $namabulan = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM YYYY');

        return view('pdf.laporan-bulanan', compact(
            'reservasi',
            'bulan',
            'tahun',
            'namabulan',
            'totalReservasi',
            'totalPendapatan',
            'statusConfirmed',
            'statusCompleted'
        ));
    }

    /**
     * View laporan tahunan (preview)
     */
    public function viewLaporanTahunan(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);

        $reservasi = Reservasi::whereYear('created_at', $tahun)
            ->with('user')
            ->get();

        $totalReservasi = $reservasi->count();
        $totalPendapatan = $reservasi->sum('total_harga');
        $statusConfirmed = $reservasi->where('status', 'confirmed')->count();
        $statusCompleted = $reservasi->where('status', 'checked_out')->count();

        // Breakdown per bulan
        $perBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanData = $reservasi->filter(function ($item) use ($i) {
                return $item->created_at->month == $i;
            });

            $perBulan[$i] = [
                'nama' => Carbon::createFromDate($tahun, $i, 1)->locale('id')->isoFormat('MMMM'),
                'count' => $bulanData->count(),
                'total' => $bulanData->sum('total_harga'),
            ];
        }

        return view('pdf.laporan-tahunan', compact(
            'reservasi',
            'tahun',
            'totalReservasi',
            'totalPendapatan',
            'statusConfirmed',
            'statusCompleted',
            'perBulan'
        ));
    }
}

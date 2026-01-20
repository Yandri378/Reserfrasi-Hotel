<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Dashboard dengan grafik harian dan bulanan
     */
    public function dashboard()
    {
        // Data Harian (30 hari terakhir)
        $hariIni = now();
        $grafikHarian = [];
        $labelHarian = [];

        for ($i = 29; $i >= 0; $i--) {
            $tanggal = $hariIni->copy()->subDays($i);
            $count = Reservasi::whereDate('created_at', $tanggal)->count();
            $grafikHarian[] = $count;
            $labelHarian[] = $tanggal->format('d M');
        }

        // Data Bulanan (12 bulan)
        $grafikBulanan = [];
        $labelBulanan = [];
        $dataBulanan = [];

        for ($i = 11; $i >= 0; $i--) {
            $bulanLalu = $hariIni->copy()->subMonths($i);
            $count = Reservasi::whereMonth('created_at', $bulanLalu->month)
                ->whereYear('created_at', $bulanLalu->year)
                ->count();
            $pendapatan = Reservasi::whereMonth('created_at', $bulanLalu->month)
                ->whereYear('created_at', $bulanLalu->year)
                ->sum('total_harga');

            $grafikBulanan[] = $count;
            $labelBulanan[] = $bulanLalu->format('M Y');
            $dataBulanan[] = [
                'bulan' => $bulanLalu->locale('id')->isoFormat('MMMM YYYY'),
                'jumlah' => $count,
                'pendapatan' => $pendapatan,
            ];
        }

        // Status breakdown
        $statusData = [
            'pending' => Reservasi::where('status', 'pending')->count(),
            'confirmed' => Reservasi::where('status', 'confirmed')->count(),
            'checked_in' => Reservasi::where('status', 'checked_in')->count(),
            'checked_out' => Reservasi::where('status', 'checked_out')->count(),
            'cancelled' => Reservasi::where('status', 'cancelled')->count(),
        ];

        // Jenis kamar breakdown
        $jenisKamarData = [
            'standar' => Reservasi::where('jenis_kamar', 'standar')->count(),
            'deluxe' => Reservasi::where('jenis_kamar', 'deluxe')->count(),
            'suite' => Reservasi::where('jenis_kamar', 'suite')->count(),
            'presidential' => Reservasi::where('jenis_kamar', 'presidential')->count(),
        ];

        // Stats umum
        $totalReservasi = Reservasi::count();
        $totalPendapatan = Reservasi::sum('total_harga');
        $rataRataHarga = $totalReservasi > 0 ? $totalPendapatan / $totalReservasi : 0;
        $reservasiBulanIni = Reservasi::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('analytics.dashboard', compact(
            'grafikHarian',
            'labelHarian',
            'grafikBulanan',
            'labelBulanan',
            'dataBulanan',
            'statusData',
            'jenisKamarData',
            'totalReservasi',
            'totalPendapatan',
            'rataRataHarga',
            'reservasiBulanIni'
        ));
    }

    /**
     * API untuk chart data (untuk AJAX)
     */
    public function chartDataHarian()
    {
        $hariIni = now();
        $data = [];
        $labels = [];

        for ($i = 29; $i >= 0; $i--) {
            $tanggal = $hariIni->copy()->subDays($i);
            $count = Reservasi::whereDate('created_at', $tanggal)->count();
            $data[] = $count;
            $labels[] = $tanggal->format('d M');
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * API untuk chart data bulanan
     */
    public function chartDataBulanan()
    {
        $hariIni = now();
        $data = [];
        $dataPendapatan = [];
        $labels = [];

        for ($i = 11; $i >= 0; $i--) {
            $bulanLalu = $hariIni->copy()->subMonths($i);
            $count = Reservasi::whereMonth('created_at', $bulanLalu->month)
                ->whereYear('created_at', $bulanLalu->year)
                ->count();
            $pendapatan = Reservasi::whereMonth('created_at', $bulanLalu->month)
                ->whereYear('created_at', $bulanLalu->year)
                ->sum('total_harga');

            $data[] = $count;
            $dataPendapatan[] = $pendapatan;
            $labels[] = $bulanLalu->format('M Y');
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'dataPendapatan' => $dataPendapatan,
        ]);
    }

    /**
     * API untuk status breakdown
     */
    public function chartDataStatus()
    {
        $data = [
            'pending' => Reservasi::where('status', 'pending')->count(),
            'confirmed' => Reservasi::where('status', 'confirmed')->count(),
            'checked_in' => Reservasi::where('status', 'checked_in')->count(),
            'checked_out' => Reservasi::where('status', 'checked_out')->count(),
            'cancelled' => Reservasi::where('status', 'cancelled')->count(),
        ];

        return response()->json($data);
    }
}

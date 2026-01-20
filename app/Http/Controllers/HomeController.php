<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $totalReservasi = Reservasi::count();
        $reservasiPending = Reservasi::where('status', 'pending')->count();
        $reservasiConfirmed = Reservasi::where('status', 'confirmed')->count();
        $totalPendapatan = Reservasi::sum('total_harga');

        return view('home', compact('totalReservasi', 'reservasiPending', 'reservasiConfirmed', 'totalPendapatan'));
    }
}

<?php

namespace App\Http\Controllers\PemilikGor;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\Lapangan;
use App\Models\Jadwal;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;

        $venues = Venue::where('id_pemilik', $pemilikId)->get();
        $venueIds = $venues->pluck('id_venue');

        $lapangans = Lapangan::whereIn('id_venue', $venueIds)->get();
        $lapanganIds = $lapangans->pluck('id_lapangan');

        $jadwals = Jadwal::whereIn('id_lapangan', $lapanganIds)->get();
        $jadwalIds = $jadwals->pluck('id_jadwal');

        $pesanans = Pemesanan::with(['pelanggan', 'jadwal.lapangan'])
            ->whereIn('id_jadwal', $jadwalIds)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $stats = [
            'total_venue'     => $venues->count(),
            'total_lapangan'  => $lapangans->count(),
            'jadwal_aktif'    => $jadwals->where('tanggal', '>=', now()->toDateString())->count(),
            'booking_masuk'   => Pemesanan::whereIn('id_jadwal', $jadwalIds)->count(),
        ];

        return view('pemilik.dashboard', compact('venues', 'pesanans', 'stats'));
    }
}

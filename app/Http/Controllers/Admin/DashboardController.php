<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PemilikGor;
use App\Models\Venue;
use App\Models\Pelanggan;
use App\Models\Pemesanan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pemilik'         => PemilikGor::count(),
            'pending_pemilik'       => PemilikGor::where('status_verifikasi', 'pending')->count(),
            'total_venue'           => Venue::count(),
            'aktif_venue'           => Venue::where('status', 'aktif')->count(),
            'total_pelanggan'       => Pelanggan::count(),
            'total_booking'         => Pemesanan::count(),
            'dikonfirmasi_booking'  => Pemesanan::where('status_pesan', 'dikonfirmasi')->count(),
        ];

        $pendingOwners = PemilikGor::where('status_verifikasi', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingOwners'));
    }

    public function transaksi()
    {
        // Get all transactions including customer, schedule, court, and payments details
        $pemesanans = Pemesanan::with(['pelanggan', 'jadwal.lapangan.venue', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.transaksi', compact('pemesanans'));
    }
}

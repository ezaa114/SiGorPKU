<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\JenisLapangan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Venue::whereIn('status', ['aktif', 'renovasi', 'tutup'])
            ->whereHas('pemilikGor', function($q) {
                $q->where('status_verifikasi', 'terverifikasi');
            });

        if ($request->filled('search')) {
            $query->where('nama_venue', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        if ($request->filled('jenis')) {
            $query->whereHas('lapangans', function($q) use ($request) {
                $q->where('id_jenis', $request->jenis);
            });
        }

        $venues = $query->with(['lapangans.jenisLapangan', 'pemilikGor'])->get();
        $categories = JenisLapangan::all();

        return view('pelanggan.dashboard', compact('venues', 'categories'));
    }
}

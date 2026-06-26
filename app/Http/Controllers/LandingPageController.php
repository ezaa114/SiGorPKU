<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\JenisLapangan;
use Illuminate\Http\Request;

class LandingPageController extends Controller
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

        // Get unique subdistricts (kecamatan) for filter dropdown
        $kecamatans = Venue::whereIn('status', ['aktif', 'renovasi', 'tutup'])
            ->whereHas('pemilikGor', function($q) {
                $q->where('status_verifikasi', 'terverifikasi');
            })
            ->distinct()
            ->pluck('kecamatan');

        return view('landing', compact('venues', 'categories', 'kecamatans'));
    }
}

<?php

namespace App\Http\Controllers\PemilikGor;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\VenueClosure;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{
    public function index()
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venues = Venue::where('id_pemilik', $pemilikId)->orderBy('created_at', 'desc')->get();
        
        return view('pemilik.venue.index', compact('venues'));
    }

    public function create()
    {
        return view('pemilik.venue.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_venue' => 'required|string|max:150',
            'alamat'     => 'required|string',
            'kecamatan'  => 'required|string|max:100',
            'no_telepon' => 'nullable|string|max:20',
            'gambar_url' => 'nullable|url|max:255',
            'gambar_file'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;

        $gambarPath = null;
        if ($request->hasFile('gambar_file')) {
            $gambarPath = $request->file('gambar_file')->store('venues', 'public');
        } elseif ($request->gambar_url) {
            $gambarPath = $request->gambar_url;
        }

        Venue::create([
            'id_pemilik' => $pemilikId,
            'nama_venue' => $request->nama_venue,
            'alamat'     => $request->alamat,
            'kecamatan'  => $request->kecamatan,
            'no_telepon' => $request->no_telepon,
            'gambar_venue' => $gambarPath,
            'status'     => 'aktif',
        ]);

        return redirect()
            ->route('pemilik.venue.index')
            ->with('success', 'Venue / GOR baru berhasil didaftarkan.');
    }

    public function edit($id)
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venue = Venue::where('id_pemilik', $pemilikId)->findOrFail($id);

        return view('pemilik.venue.edit', compact('venue'));
    }

    public function update(Request $request, $id)
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venue = Venue::where('id_pemilik', $pemilikId)->findOrFail($id);

        $request->validate([
            'nama_venue' => 'required|string|max:150',
            'alamat'     => 'required|string',
            'kecamatan'  => 'required|string|max:100',
            'no_telepon' => 'nullable|string|max:20',
            'gambar_url' => 'nullable|url|max:255',
            'gambar_file'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status'     => 'required|in:aktif,nonaktif,renovasi,tutup',
        ]);

        $gambarPath = $venue->gambar_venue;
        if ($request->hasFile('gambar_file')) {
            if ($venue->gambar_venue && !filter_var($venue->gambar_venue, FILTER_VALIDATE_URL)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($venue->gambar_venue);
            }
            $gambarPath = $request->file('gambar_file')->store('venues', 'public');
        } elseif ($request->filled('gambar_url')) {
            if ($venue->gambar_venue && !filter_var($venue->gambar_venue, FILTER_VALIDATE_URL)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($venue->gambar_venue);
            }
            $gambarPath = $request->gambar_url;
        } elseif ($request->has('gambar_url') && empty($request->gambar_url)) {
            if ($venue->gambar_venue && !filter_var($venue->gambar_venue, FILTER_VALIDATE_URL)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($venue->gambar_venue);
            }
            $gambarPath = null;
        }

        $venue->update([
            'nama_venue' => $request->nama_venue,
            'alamat'     => $request->alamat,
            'kecamatan'  => $request->kecamatan,
            'no_telepon' => $request->no_telepon,
            'gambar_venue' => $gambarPath,
            'status'     => $request->status,
        ]);

        return redirect()
            ->route('pemilik.venue.index')
            ->with('success', 'Informasi venue / GOR berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venue = Venue::where('id_pemilik', $pemilikId)->findOrFail($id);

        $venue->delete();

        return redirect()
            ->route('pemilik.venue.index')
            ->with('success', 'Venue / GOR beserta seluruh lapangannya berhasil dihapus.');
    }

    public function closures($id)
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venue = Venue::where('id_pemilik', $pemilikId)->findOrFail($id);
        
        $closures = VenueClosure::where('id_venue', $venue->id_venue)
            ->orderBy('tanggal', 'asc')
            ->get();
            
        return view('pemilik.venue.closures', compact('venue', 'closures'));
    }

    public function storeClosure(Request $request, $id)
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venue = Venue::where('id_pemilik', $pemilikId)->findOrFail($id);
        
        $request->validate([
            'tanggal'    => 'required|date|after_or_equal:today',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Check if there are active bookings for this venue on the specified date
        $hasBookings = Pemesanan::whereHas('jadwal.lapangan', function($q) use ($venue) {
                $q->where('id_venue', $venue->id_venue);
            })
            ->whereHas('jadwal', function($q) use ($request) {
                $q->where('tanggal', $request->tanggal);
            })
            ->whereIn('status_pesan', ['menunggu_pembayaran', 'lunas'])
            ->exists();

        if ($hasBookings) {
            return redirect()
                ->back()
                ->with('error', 'Tidak dapat menutup GOR pada tanggal tersebut karena sudah ada pesanan aktif (lunas/menunggu pembayaran) dari pelanggan.');
        }

        // Check for duplicates
        $exists = VenueClosure::where('id_venue', $venue->id_venue)
            ->where('tanggal', $request->tanggal)
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->with('error', 'Tanggal tersebut sudah didaftarkan sebagai hari libur.');
        }

        VenueClosure::create([
            'id_venue'   => $venue->id_venue,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('pemilik.venue.closures', $venue->id_venue)
            ->with('success', 'Hari libur GOR berhasil ditambahkan.');
    }

    public function destroyClosure($id, $closure_id)
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venue = Venue::where('id_pemilik', $pemilikId)->findOrFail($id);
        
        $closure = VenueClosure::where('id_venue', $venue->id_venue)
            ->findOrFail($closure_id);
            
        $closure->delete();

        return redirect()
            ->route('pemilik.venue.closures', $venue->id_venue)
            ->with('success', 'Hari libur berhasil dihapus, GOR kembali dibuka.');
    }
}

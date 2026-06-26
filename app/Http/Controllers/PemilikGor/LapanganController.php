<?php

namespace App\Http\Controllers\PemilikGor;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Venue;
use App\Models\JenisLapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LapanganController extends Controller
{
    private function getOwnerVenueIds()
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        return Venue::where('id_pemilik', $pemilikId)->pluck('id_venue')->toArray();
    }

    public function index()
    {
        $venueIds = $this->getOwnerVenueIds();
        $lapangans = Lapangan::whereIn('id_venue', $venueIds)
            ->with(['venue', 'jenisLapangan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pemilik.lapangan.index', compact('lapangans'));
    }

    public function create()
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venues = Venue::where('id_pemilik', $pemilikId)->where('status', 'aktif')->get();
        $categories = JenisLapangan::all();

        return view('pemilik.lapangan.create', compact('venues', 'categories'));
    }

    public function store(Request $request)
    {
        $venueIds = $this->getOwnerVenueIds();

        $request->validate([
            'id_venue'      => 'required|integer|in:' . implode(',', $venueIds),
            'id_jenis'      => 'required|exists:jenis_lapangans,id_jenis',
            'nama_lapangan' => 'required|string|max:100',
            'harga_per_jam' => 'required|numeric|min:0',
            'gambar_url'    => 'nullable|url|max:255',
            'gambar_file'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar_file')) {
            $gambarPath = $request->file('gambar_file')->store('lapangans', 'public');
        } elseif ($request->gambar_url) {
            $gambarPath = $request->gambar_url;
        }

        Lapangan::create([
            'id_venue'      => $request->id_venue,
            'id_jenis'      => $request->id_jenis,
            'nama_lapangan' => $request->nama_lapangan,
            'harga_per_jam' => $request->harga_per_jam,
            'gambar_lapangan' => $gambarPath,
            'status'        => 'tersedia',
        ]);

        return redirect()
            ->route('pemilik.lapangan.index')
            ->with('success', 'Lapangan olahraga baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $venueIds = $this->getOwnerVenueIds();
        $lapangan = Lapangan::whereIn('id_venue', $venueIds)->findOrFail($id);

        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venues = Venue::where('id_pemilik', $pemilikId)->where('status', 'aktif')->get();
        $categories = JenisLapangan::all();

        return view('pemilik.lapangan.edit', compact('lapangan', 'venues', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $venueIds = $this->getOwnerVenueIds();
        $lapangan = Lapangan::whereIn('id_venue', $venueIds)->findOrFail($id);

        $request->validate([
            'id_venue'      => 'required|integer|in:' . implode(',', $venueIds),
            'id_jenis'      => 'required|exists:jenis_lapangans,id_jenis',
            'nama_lapangan' => 'required|string|max:100',
            'harga_per_jam' => 'required|numeric|min:0',
            'gambar_url'    => 'nullable|url|max:255',
            'gambar_file'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status'        => 'required|in:tersedia,nonaktif',
        ]);

        $gambarPath = $lapangan->gambar_lapangan;
        if ($request->hasFile('gambar_file')) {
            if ($lapangan->gambar_lapangan && !filter_var($lapangan->gambar_lapangan, FILTER_VALIDATE_URL)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($lapangan->gambar_lapangan);
            }
            $gambarPath = $request->file('gambar_file')->store('lapangans', 'public');
        } elseif ($request->filled('gambar_url')) {
            if ($lapangan->gambar_lapangan && !filter_var($lapangan->gambar_lapangan, FILTER_VALIDATE_URL)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($lapangan->gambar_lapangan);
            }
            $gambarPath = $request->gambar_url;
        } elseif ($request->has('gambar_url') && empty($request->gambar_url)) {
            if ($lapangan->gambar_lapangan && !filter_var($lapangan->gambar_lapangan, FILTER_VALIDATE_URL)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($lapangan->gambar_lapangan);
            }
            $gambarPath = null;
        }

        $lapangan->update([
            'id_venue'      => $request->id_venue,
            'id_jenis'      => $request->id_jenis,
            'nama_lapangan' => $request->nama_lapangan,
            'harga_per_jam' => $request->harga_per_jam,
            'gambar_lapangan' => $gambarPath,
            'status'        => $request->status,
        ]);

        return redirect()
            ->route('pemilik.lapangan.index')
            ->with('success', 'Informasi lapangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $venueIds = $this->getOwnerVenueIds();
        $lapangan = Lapangan::whereIn('id_venue', $venueIds)->findOrFail($id);

        // Prevent delete if field has active schedules/bookings
        if ($lapangan->jadwals()->where('ketersediaan', 'dipesan')->exists()) {
            return redirect()
                ->route('pemilik.lapangan.index')
                ->with('error', 'Lapangan tidak dapat dihapus karena memiliki jadwal yang sudah dipesan pelanggan.');
        }

        // Delete image if exists
        if ($lapangan->gambar_lapangan && !filter_var($lapangan->gambar_lapangan, FILTER_VALIDATE_URL)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($lapangan->gambar_lapangan);
        }

        $lapangan->delete();

        return redirect()
            ->route('pemilik.lapangan.index')
            ->with('success', 'Lapangan olahraga berhasil dihapus.');
    }
}

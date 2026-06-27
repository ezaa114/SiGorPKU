<?php

namespace App\Http\Controllers\PemilikGor;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Lapangan;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    private function getOwnerLapanganIds()
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venueIds = Venue::where('id_pemilik', $pemilikId)->pluck('id_venue')->toArray();
        return Lapangan::whereIn('id_venue', $venueIds)->pluck('id_lapangan')->toArray();
    }

    public function index()
    {
        $lapanganIds = $this->getOwnerLapanganIds();
        $jadwals = Jadwal::whereIn('id_lapangan', $lapanganIds)
            ->with('lapangan.venue')
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Get all closures for the owner's venues
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venueIds = Venue::where('id_pemilik', $pemilikId)->pluck('id_venue')->toArray();
        $closures = \App\Models\VenueClosure::whereIn('id_venue', $venueIds)->get();
        
        // Group closures by venue_id and date for quick lookup
        $closuresGrouped = [];
        foreach ($closures as $c) {
            $closuresGrouped[$c->id_venue][$c->tanggal->format('Y-m-d')] = $c;
        }

        return view('pemilik.jadwal.index', compact('jadwals', 'closuresGrouped'));
    }

    public function create()
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venueIds = Venue::where('id_pemilik', $pemilikId)->pluck('id_venue')->toArray();
        $lapangans = Lapangan::whereIn('id_venue', $venueIds)->where('status', 'tersedia')->get();

        return view('pemilik.jadwal.create', compact('lapangans'));
    }

    public function store(Request $request)
    {
        $lapanganIds = $this->getOwnerLapanganIds();

        $request->validate([
            'id_lapangan' => 'required|integer|in:' . implode(',', $lapanganIds),
            'mode'        => 'required|in:otomatis,manual',
            
            // Validation for otomatis mode
            'jam_buka'    => 'required_if:mode,otomatis|nullable|date_format:H:i',
            'jam_tutup'   => 'required_if:mode,otomatis|nullable|date_format:H:i|after:jam_buka',
            
            // Validation for manual mode
            'tanggal'     => 'required_if:mode,manual|nullable|date|after_or_equal:today',
            'jam_mulai'   => 'required_if:mode,manual|nullable|date_format:H:i',
            'jam_selesai' => 'required_if:mode,manual|nullable|date_format:H:i|after:jam_mulai',
        ]);

        $id_lapangan = $request->id_lapangan;

        if ($request->mode === 'otomatis') {
            $jam_buka = $request->jam_buka;
            $jam_tutup = $request->jam_tutup;

            $createdCount = 0;
            $skippedCount = 0;

            for ($day = 0; $day < 15; $day++) {
                $date = now()->addDays($day)->toDateString();
                
                $start = \Carbon\Carbon::parse($jam_buka);
                $end = \Carbon\Carbon::parse($jam_tutup);
                
                $temp = $start->copy();
                while ($temp->copy()->addHour()->lte($end)) {
                    $jam_mulai = $temp->format('H:i:s');
                    $jam_selesai = $temp->copy()->addHour()->format('H:i:s');

                    // Check for exact duplicate slot
                    $exists = Jadwal::where('id_lapangan', $id_lapangan)
                        ->where('tanggal', $date)
                        ->where('jam_mulai', $jam_mulai)
                        ->exists();

                    if (!$exists) {
                        Jadwal::create([
                            'id_lapangan'  => $id_lapangan,
                            'tanggal'      => $date,
                            'jam_mulai'    => $jam_mulai,
                            'jam_selesai'  => $jam_selesai,
                            'ketersediaan' => 'tersedia',
                        ]);
                        $createdCount++;
                    } else {
                        $skippedCount++;
                    }

                    $temp->addHour();
                }
            }

            return redirect()
                ->route('pemilik.jadwal.index')
                ->with('success', "Generate jadwal otomatis untuk 15 hari ke depan selesai. Berhasil membuat {$createdCount} slot baru (dan melewati {$skippedCount} slot duplikat secara otomatis).");
        } else {
            // Manual mode
            $date = $request->tanggal;
            $jam_mulai = \Carbon\Carbon::parse($request->jam_mulai)->format('H:i:s');
            $jam_selesai = \Carbon\Carbon::parse($request->jam_selesai)->format('H:i:s');

            // Check for exact duplicate slot
            $exists = Jadwal::where('id_lapangan', $id_lapangan)
                ->where('tanggal', $date)
                ->where('jam_mulai', $jam_mulai)
                ->exists();

            if ($exists) {
                return back()
                    ->withInput()
                    ->with('error', 'Slot jadwal untuk lapangan, tanggal, dan jam mulai tersebut sudah terdaftar.');
            }

            Jadwal::create([
                'id_lapangan'  => $id_lapangan,
                'tanggal'      => $date,
                'jam_mulai'    => $jam_mulai,
                'jam_selesai'  => $jam_selesai,
                'ketersediaan' => 'tersedia',
            ]);

            return redirect()
                ->route('pemilik.jadwal.index')
                ->with('success', 'Slot jadwal manual berhasil ditambahkan.');
        }
    }

    public function destroy($id)
    {
        $lapanganIds = $this->getOwnerLapanganIds();
        $jadwal = Jadwal::whereIn('id_lapangan', $lapanganIds)->findOrFail($id);

        if ($jadwal->ketersediaan === 'dipesan') {
            return redirect()
                ->route('pemilik.jadwal.index')
                ->with('error', 'Tidak dapat menghapus slot jadwal yang sudah dipesan oleh pelanggan.');
        }

        $jadwal->delete();

        return redirect()
            ->route('pemilik.jadwal.index')
            ->with('success', 'Slot jadwal berhasil dihapus.');
    }
}

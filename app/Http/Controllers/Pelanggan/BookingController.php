<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\Jadwal;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        return redirect()->route('pelanggan.dashboard');
    }

    public function showVenue($id)
    {
        // Query venue details, showing available fields and active available slots
        $venue = Venue::with(['lapangans.jenisLapangan', 'lapangans.jadwals' => function($q) {
            $q->where('ketersediaan', 'tersedia')
              ->whereBetween('tanggal', [now()->toDateString(), now()->addDays(2)->toDateString()])
              ->orderBy('tanggal', 'asc')
              ->orderBy('jam_mulai', 'asc');
        }])->findOrFail($id);

        if (($venue->pemilikGor->status_verifikasi ?? 'pending') !== 'terverifikasi') {
            abort(404, 'Gedung Olahraga (GOR) tidak ditemukan atau belum terverifikasi.');
        }

        if ($venue->status === 'renovasi') {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, Gedung Olahraga (GOR) "' . $venue->nama_venue . '" sedang dalam renovasi.');
        } elseif ($venue->status === 'tutup') {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, Gedung Olahraga (GOR) "' . $venue->nama_venue . '" sedang tutup sementara.');
        } elseif ($venue->status === 'nonaktif') {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Gedung Olahraga (GOR) tidak ditemukan atau dinonaktifkan.');
        }

        return view('pelanggan.venue.show', compact('venue'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwals,id_jadwal',
        ]);

        $jadwal = Jadwal::with('lapangan.venue.pemilikGor')->findOrFail($request->id_jadwal);

        if (!$jadwal->isTersedia()) {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, slot jadwal tersebut baru saja dipesan oleh pengguna lain.');
        }

        if (($jadwal->lapangan->venue->pemilikGor->status_verifikasi ?? 'pending') !== 'terverifikasi') {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, GOR ini belum diverifikasi oleh administrator.');
        }

        if ($jadwal->lapangan->venue->status !== 'aktif') {
            $statusMsg = $jadwal->lapangan->venue->status === 'renovasi' ? 'sedang dalam renovasi' : 'sedang tutup';
            return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, GOR ini ' . $statusMsg . ' sehingga tidak dapat dipesan.');
        }

        if ($jadwal->lapangan->status !== 'tersedia') {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, lapangan ini sedang dalam perbaikan / dinonaktifkan.');
        }

        // Calculate consecutive available slots on the same day and field
        $allSlots = Jadwal::where('id_lapangan', $jadwal->id_lapangan)
            ->where('tanggal', $jadwal->tanggal)
            ->orderBy('jam_mulai', 'asc')
            ->get();
            
        $start_time = $jadwal->jam_mulai;
        $consecutive_count = 0;
        $current_time = $start_time;
        
        while (true) {
            $nextSlot = $allSlots->where('jam_mulai', $current_time)
                ->where('ketersediaan', 'tersedia')
                ->first();
                
            if (!$nextSlot) {
                break;
            }
            
            $consecutive_count++;
            $current_time = $nextSlot->jam_selesai;
        }

        $hours = 1; // Default starting duration is 1 hour
        $totalHarga = $jadwal->lapangan->harga_per_jam;

        return view('pelanggan.booking.create', compact('jadwal', 'hours', 'totalHarga', 'consecutive_count'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal'  => 'required|exists:jadwals,id_jadwal',
            'durasi_jam' => 'required|integer|min:1|max:4',
        ]);

        // Prevent double booking with database transaction lock
        $jadwal = Jadwal::with('lapangan.venue.pemilikGor')->findOrFail($request->id_jadwal);

        if (!$jadwal->isTersedia()) {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, slot jadwal tersebut telah dipesan orang lain.');
        }

        if (($jadwal->lapangan->venue->pemilikGor->status_verifikasi ?? 'pending') !== 'terverifikasi') {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, GOR ini belum diverifikasi oleh administrator.');
        }

        if ($jadwal->lapangan->venue->status !== 'aktif') {
            $statusMsg = $jadwal->lapangan->venue->status === 'renovasi' ? 'sedang dalam renovasi' : 'sedang tutup';
            return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, GOR ini ' . $statusMsg . ' sehingga tidak dapat dipesan.');
        }

        if ($jadwal->lapangan->status !== 'tersedia') {
            return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, lapangan ini sedang dalam perbaikan / dinonaktifkan.');
        }

        // Verify and fetch all consecutive slots
        $allSlots = Jadwal::where('id_lapangan', $jadwal->id_lapangan)
            ->where('tanggal', $jadwal->tanggal)
            ->orderBy('jam_mulai', 'asc')
            ->get();
            
        $start_time = $jadwal->jam_mulai;
        $consecutive_slots = [];
        $current_time = $start_time;
        
        for ($i = 0; $i < $request->durasi_jam; $i++) {
            $slot = $allSlots->where('jam_mulai', $current_time)
                ->where('ketersediaan', 'tersedia')
                ->first();
                
            if (!$slot) {
                return redirect()->route('pelanggan.dashboard')->with('error', 'Maaf, salah satu slot jam sewa pilihan Anda sudah tidak tersedia.');
            }
            
            $consecutive_slots[] = $slot;
            $current_time = $slot->jam_selesai;
        }

        $pelangganId = Auth::guard('pelanggan')->user()->id_pelanggan;
        $totalHarga = $request->durasi_jam * $jadwal->lapangan->harga_per_jam;

        // Create Pemesanan
        $pemesanan = Pemesanan::create([
            'id_pelanggan' => $pelangganId,
            'id_jadwal'    => $jadwal->id_jadwal,
            'durasi_jam'   => $request->durasi_jam,
            'tgl_pesan'    => now()->toDateString(),
            'total_harga'  => $totalHarga,
            'status_pesan' => 'menunggu_pembayaran',
        ]);

        // Lock all consecutive slots
        foreach ($consecutive_slots as $slot) {
            $slot->update([
                'ketersediaan' => 'dipesan',
            ]);
        }

        return redirect()
            ->route('pelanggan.pemesanan.show', $pemesanan->id_pemesanan)
            ->with('success', 'Booking berhasil dibuat! Silakan upload bukti transfer bank untuk pembayaran.');
    }
}

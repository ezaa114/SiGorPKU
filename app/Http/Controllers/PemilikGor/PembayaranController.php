<?php

namespace App\Http\Controllers\PemilikGor;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Models\Venue;
use App\Models\Lapangan;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    private function getOwnerJadwalIds()
    {
        $pemilikId = Auth::guard('pemilik')->user()->id_pemilik;
        $venueIds = Venue::where('id_pemilik', $pemilikId)->pluck('id_venue')->toArray();
        $lapanganIds = Lapangan::whereIn('id_venue', $venueIds)->pluck('id_lapangan')->toArray();
        return Jadwal::whereIn('id_lapangan', $lapanganIds)->pluck('id_jadwal')->toArray();
    }

    public function index()
    {
        $jadwalIds = $this->getOwnerJadwalIds();

        $pemesanans = Pemesanan::whereIn('id_jadwal', $jadwalIds)
            ->with(['pelanggan', 'jadwal.lapangan.venue', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pemilik.pembayaran.index', compact('pemesanans'));
    }

    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:dikonfirmasi,ditolak',
        ]);

        $jadwalIds = $this->getOwnerJadwalIds();
        
        // Find the Pemesanan first
        $pemesanan = Pemesanan::whereIn('id_jadwal', $jadwalIds)->findOrFail($id);
        
        // Find or create associated payment model
        $pembayaran = $pemesanan->pembayaran;

        if (!$pembayaran) {
            $pembayaran = new Pembayaran([
                'id_pemesanan'   => $pemesanan->id_pemesanan,
                'tgl_bayar'      => now()->toDateString(),
                'jumlah_bayar'   => $pemesanan->total_harga,
                'bukti_transfer' => null,
                'metode_bayar'   => 'transfer_bank',
                'status_bayar'   => 'menunggu',
            ]);
        }

        if ($request->status === 'dikonfirmasi') {
            $pembayaran->status_bayar = 'dikonfirmasi';
            $pembayaran->save();

            $pemesanan->update([
                'status_pesan' => 'dikonfirmasi',
            ]);

            // Set all slots associated with this booking to dipesan/booked
            $startJadwal = $pemesanan->jadwal;
            $allSlots = \App\Models\Jadwal::where('id_lapangan', $startJadwal->id_lapangan)
                ->where('tanggal', $startJadwal->tanggal)
                ->orderBy('jam_mulai', 'asc')
                ->get();
                
            $current_time = $startJadwal->jam_mulai;
            for ($i = 0; $i < $pemesanan->durasi_jam; $i++) {
                $slot = $allSlots->where('jam_mulai', $current_time)->first();
                if ($slot) {
                    $slot->update(['ketersediaan' => 'dipesan']);
                    $current_time = $slot->jam_selesai;
                }
            }

            $msg = 'Pembayaran berhasil dikonfirmasi dan jadwal sewa telah terkunci.';
        } else {
            $pembayaran->status_bayar = 'ditolak';
            $pembayaran->save();

            $pemesanan->update([
                'status_pesan' => 'dibatalkan',
            ]);

            // Free up all consecutive slots associated with this booking
            $startJadwal = $pemesanan->jadwal;
            $allSlots = \App\Models\Jadwal::where('id_lapangan', $startJadwal->id_lapangan)
                ->where('tanggal', $startJadwal->tanggal)
                ->orderBy('jam_mulai', 'asc')
                ->get();
                
            $current_time = $startJadwal->jam_mulai;
            for ($i = 0; $i < $pemesanan->durasi_jam; $i++) {
                $slot = $allSlots->where('jam_mulai', $current_time)->first();
                if ($slot) {
                    $slot->update(['ketersediaan' => 'tersedia']);
                    $current_time = $slot->jam_selesai;
                }
            }

            $msg = 'Pembayaran ditolak dan slot jadwal telah dibuka kembali untuk publik.';
        }

        return redirect()
            ->route('pemilik.pembayaran.index')
            ->with('success', $msg);
    }
}

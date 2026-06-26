<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function index()
    {
        $pelangganId = Auth::guard('pelanggan')->user()->id_pelanggan;
        
        $pemesanans = Pemesanan::where('id_pelanggan', $pelangganId)
            ->with(['jadwal.lapangan.venue', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pelanggan.pemesanan.index', compact('pemesanans'));
    }

    public function show($id)
    {
        $pelangganId = Auth::guard('pelanggan')->user()->id_pelanggan;
        
        $pemesanan = Pemesanan::where('id_pelanggan', $pelangganId)
            ->with(['jadwal.lapangan.venue', 'pembayaran'])
            ->findOrFail($id);

        return view('pelanggan.pemesanan.show', compact('pemesanan'));
    }

    public function bayar(Request $request, $id)
    {
        $pelangganId = Auth::guard('pelanggan')->user()->id_pelanggan;
        $pemesanan = Pemesanan::where('id_pelanggan', $pelangganId)->findOrFail($id);

        $request->validate([
            'bukti_transfer' => 'required|file|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('bukti_transfer')) {
            // Save the file under storage/app/public/bukti_transfer/
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

            // Update or create payment record
            Pembayaran::updateOrCreate(
                ['id_pemesanan' => $pemesanan->id_pemesanan],
                [
                    'tgl_bayar'      => now()->toDateString(),
                    'jumlah_bayar'   => $pemesanan->total_harga,
                    'bukti_transfer' => $path,
                    'metode_bayar'   => 'transfer_bank',
                    'status_bayar'   => 'menunggu',
                ]
            );

            // Update booking status
            $pemesanan->update([
                'status_pesan' => 'menunggu_konfirmasi',
            ]);

            return redirect()
                ->route('pelanggan.pemesanan.show', $pemesanan->id_pemesanan)
                ->with('success', 'Bukti transfer berhasil diunggah. Menunggu konfirmasi pemilik GOR.');
        }

        return back()->with('error', 'Gagal mengunggah file bukti pembayaran.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::orderBy('created_at', 'desc')->get();
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    public function toggleStatus($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        
        $newStatus = $pelanggan->status === 'aktif' ? 'diblokir' : 'aktif';
        $pelanggan->update([
            'status' => $newStatus,
        ]);

        $message = $newStatus === 'diblokir' 
            ? "Akun pelanggan {$pelanggan->nama} berhasil diblokir." 
            : "Blokir akun pelanggan {$pelanggan->nama} berhasil dibuka.";

        return redirect()
            ->route('admin.pelanggan.index')
            ->with('success', $message);
    }
}

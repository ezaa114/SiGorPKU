<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PemilikGor;
use Illuminate\Http\Request;

class PemilikGorController extends Controller
{
    public function index()
    {
        $pemiliks = PemilikGor::orderBy('created_at', 'desc')->get();
        return view('admin.pemilik-gor.index', compact('pemiliks'));
    }

    public function show($id)
    {
        $pemilik = PemilikGor::with('venues')->findOrFail($id);
        return view('admin.pemilik-gor.show', compact('pemilik'));
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:terverifikasi,ditolak,pending',
        ]);

        $pemilik = PemilikGor::findOrFail($id);
        $pemilik->update([
            'status_verifikasi' => $request->status,
        ]);

        $statusText = $request->status === 'terverifikasi' ? 'disetujui' : ($request->status === 'ditolak' ? 'ditolak' : 'ditangguhkan');

        return redirect()
            ->route('admin.pemilik-gor.index')
            ->with('success', "Status pendaftaran GOR {$pemilik->nama_usaha} berhasil {$statusText}.");
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisLapangan;
use Illuminate\Http\Request;

class JenisLapanganController extends Controller
{
    public function index()
    {
        $jenis = JenisLapangan::orderBy('nama_jenis', 'asc')->get();
        return view('admin.jenis-lapangan.index', compact('jenis'));
    }

    public function create()
    {
        return view('admin.jenis-lapangan.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:50|unique:jenis_lapangans,nama_jenis',
            'deskripsi'  => 'nullable|string',
        ]);

        JenisLapangan::create([
            'nama_jenis' => $request->nama_jenis,
            'deskripsi'  => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.jenis-lapangan.index')
            ->with('success', 'Kategori olahraga baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenis = JenisLapangan::findOrFail($id);
        return view('admin.jenis-lapangan.form', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:50|unique:jenis_lapangans,nama_jenis,' . $id . ',id_jenis',
            'deskripsi'  => 'nullable|string',
        ]);

        $jenis = JenisLapangan::findOrFail($id);
        $jenis->update([
            'nama_jenis' => $request->nama_jenis,
            'deskripsi'  => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.jenis-lapangan.index')
            ->with('success', 'Kategori olahraga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenis = JenisLapangan::findOrFail($id);

        // Check if there are related fields using this category
        if ($jenis->lapangans()->exists()) {
            return redirect()
                ->route('admin.jenis-lapangan.index')
                ->with('error', 'Kategori olahraga tidak dapat dihapus karena sedang digunakan oleh beberapa lapangan.');
        }

        $jenis->delete();

        return redirect()
            ->route('admin.jenis-lapangan.index')
            ->with('success', 'Kategori olahraga berhasil dihapus.');
    }
}

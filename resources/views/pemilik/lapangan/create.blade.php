@extends('layouts.pemilik')

@section('title', 'Tambah Lapangan Baru')
@section('header_title', 'Registrasi Lapangan Baru')

@section('content')
<div class="max-w-xl mx-auto space-y-6 animate-fade-in-up">
    <!-- Breadcrumb back link -->
    <div>
        <a href="{{ route('pemilik.lapangan.index') }}" class="text-sm font-semibold text-blue-600 hover:underline inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Lapangan
        </a>
    </div>

    <!-- Form Card -->
    <div class="card p-8">
        <h3 class="text-xl font-extrabold text-slate-800 mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftarkan Lapangan Baru</h3>

        <!-- Form Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-error mb-6">
                <ul class="list-disc list-inside text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($venues->isEmpty())
            <div class="text-center py-6">
                <p class="text-sm text-slate-500 mb-4">Anda harus mendaftarkan Venue / GOR yang berstatus aktif terlebih dahulu sebelum membuat lapangan.</p>
                <a href="{{ route('pemilik.venue.create') }}" class="btn-primary py-2 px-6 font-bold text-xs">Daftarkan GOR Sekarang</a>
            </div>
        @else
            <form action="{{ route('pemilik.lapangan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                
                <div>
                    <label for="id_venue" class="form-label">Pilih Gedung Olahraga (Venue GOR)</label>
                    <select id="id_venue" name="id_venue" required class="form-input">
                        <option value="">Pilih Venue</option>
                        @foreach($venues as $venue)
                            <option value="{{ $venue->id_venue }}" {{ old('id_venue') == $venue->id_venue ? 'selected' : '' }}>{{ $venue->nama_venue }} ({{ $venue->kecamatan }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="id_jenis" class="form-label">Pilih Kategori Olahraga</label>
                    <select id="id_jenis" name="id_jenis" required class="form-input">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id_jenis }}" {{ old('id_jenis') == $category->id_jenis ? 'selected' : '' }}>{{ $category->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="nama_lapangan" class="form-label">Nama / Nomor Lapangan</label>
                    <input type="text" id="nama_lapangan" name="nama_lapangan" value="{{ old('nama_lapangan') }}" required class="form-input" placeholder="Contoh: Lapangan A (Vinyl) atau Lapangan Utama">
                </div>

                <div>
                    <label for="harga_per_jam" class="form-label">Harga Sewa per Jam (Rupiah)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-slate-400 text-sm font-semibold">Rp</span>
                        </div>
                        <input type="number" id="harga_per_jam" name="harga_per_jam" value="{{ old('harga_per_jam') }}" required class="form-input" style="padding-left: 2.75rem;" placeholder="Contoh: 45000">
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Masukkan nominal angka saja tanpa titik atau koma.</p>
                </div>

                <div>
                    <label class="form-label font-bold text-slate-700">Foto / Gambar Lapangan</label>
                    <p class="text-[11px] text-slate-500 mb-2">Pilih salah satu cara di bawah untuk menambahkan gambar lapangan ini:</p>
                    
                    <div class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <div>
                            <label for="gambar_url" class="text-xs font-semibold text-slate-650 block mb-1">Via URL Gambar (Internet)</label>
                            <input type="url" id="gambar_url" name="gambar_url" value="{{ old('gambar_url') }}" class="form-input text-xs" placeholder="Contoh: https://link-gambar.com/lapangan.jpg">
                        </div>
                        
                        <div class="relative flex items-center justify-center my-2">
                            <div class="border-t border-slate-200 w-full"></div>
                            <span class="absolute px-3 bg-slate-50 text-[10px] font-bold text-slate-400 uppercase">Atau</span>
                        </div>

                        <div>
                            <label for="gambar_file" class="text-xs font-semibold text-slate-650 block mb-1">Upload File Gambar dari Komputer</label>
                            <input type="file" id="gambar_file" name="gambar_file" accept="image/*" class="form-input text-xs">
                            <p class="text-[10px] text-slate-400 mt-1">Format: JPG, JPEG, PNG, WEBP (Maksimal 2MB)</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full btn-primary py-3 text-sm font-bold shadow-lg shadow-blue-500/20">
                    Simpan Lapangan
                </button>
            </form>
        @endif
    </div>
</div>
@endsection

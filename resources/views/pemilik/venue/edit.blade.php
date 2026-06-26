@extends('layouts.pemilik')

@section('title', 'Ubah Data GOR')
@section('header_title', 'Edit GOR / Venue')

@section('content')
<div class="max-w-xl mx-auto space-y-6 animate-fade-in-up">
    <!-- Breadcrumb back link -->
    <div>
        <a href="{{ route('pemilik.venue.index') }}" class="text-sm font-semibold text-blue-600 hover:underline inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Venue
        </a>
    </div>

    <!-- Form Card -->
    <div class="card p-8">
        <h3 class="text-xl font-extrabold text-slate-800 mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">Ubah Data GOR</h3>

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

        <form action="{{ route('pemilik.venue.update', $venue->id_venue) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            
            <div>
                <label for="nama_venue" class="form-label">Nama Gedung Olahraga (GOR)</label>
                <input type="text" id="nama_venue" name="nama_venue" value="{{ old('nama_venue', $venue->nama_venue) }}" required class="form-input" placeholder="Contoh: GOR Harapan Baru Pekanbaru">
            </div>

            <div>
                <label for="kecamatan" class="form-label">Kecamatan (Lokasi di Pekanbaru)</label>
                <select id="kecamatan" name="kecamatan" required class="form-input">
                    <option value="">Pilih Kecamatan</option>
                    @php
                        $kecamatans = ['Bukit Raya', 'Lima Puluh', 'Marpoyan Damai', 'Payung Sekaki', 'Pekanbaru Kota', 'Rumbai', 'Rumbai Barat', 'Rumbai Timur', 'Senapelan', 'Sukajadi', 'Tuah Madani', 'Tenayan Raya', 'Kulim'];
                    @endphp
                    @foreach($kecamatans as $kec)
                        <option value="{{ $kec }}" {{ old('kecamatan', $venue->kecamatan) == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="alamat" class="form-label">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" required class="form-input h-24" placeholder="Tulis alamat lengkap GOR">{{ old('alamat', $venue->alamat) }}</textarea>
            </div>

            <div>
                <label for="no_telepon" class="form-label">Nomor Telepon GOR / WhatsApp Admin (Opsional)</label>
                <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $venue->no_telepon) }}" class="form-input" placeholder="Contoh: 0812XXXXXXXX">
            </div>

            <div>
                <label class="form-label font-bold text-slate-700">Foto / Gambar GOR</label>
                
                @if($venue->gambar_venue)
                    <div class="mb-3">
                        <p class="text-xs text-slate-500 mb-1">Gambar saat ini:</p>
                        @if(filter_var($venue->gambar_venue, FILTER_VALIDATE_URL))
                            <img src="{{ $venue->gambar_venue }}" alt="{{ $venue->nama_venue }}" class="h-28 object-cover rounded-xl border border-slate-200 shadow-sm">
                        @else
                            <img src="{{ asset('storage/' . $venue->gambar_venue) }}" alt="{{ $venue->nama_venue }}" class="h-28 object-cover rounded-xl border border-slate-200 shadow-sm">
                        @endif
                    </div>
                @endif

                <p class="text-[11px] text-slate-500 mb-2">Pilih salah satu cara di bawah untuk memperbarui gambar GOR:</p>
                
                <div class="space-y-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div>
                        <label for="gambar_url" class="text-xs font-semibold text-slate-655 block mb-1">Via URL Gambar (Internet)</label>
                        <input type="url" id="gambar_url" name="gambar_url" value="{{ old('gambar_url', filter_var($venue->gambar_venue, FILTER_VALIDATE_URL) ? $venue->gambar_venue : '') }}" class="form-input text-xs" placeholder="Contoh: https://link-gambar.com/gor.jpg">
                    </div>
                    
                    <div class="relative flex items-center justify-center my-2">
                        <div class="border-t border-slate-200 w-full"></div>
                        <span class="absolute px-3 bg-slate-50 text-[10px] font-bold text-slate-400 uppercase">Atau</span>
                    </div>

                    <div>
                        <label for="gambar_file" class="text-xs font-semibold text-slate-655 block mb-1">Upload File Gambar Baru</label>
                        <input type="file" id="gambar_file" name="gambar_file" accept="image/*" class="form-input text-xs">
                        <p class="text-[10px] text-slate-400 mt-1">Format: JPG, JPEG, PNG, WEBP (Maksimal 2MB). Biarkan kosong jika tidak ingin mengubah.</p>
                    </div>
                </div>
            </div>

            <div>
                <label for="status" class="form-label">Status Venue</label>
                <select id="status" name="status" required class="form-input">
                    <option value="aktif" {{ old('status', $venue->status) === 'aktif' ? 'selected' : '' }}>Aktif (Tampil Publik)</option>
                    <option value="nonaktif" {{ old('status', $venue->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif (Sembunyikan dari Pencarian)</option>
                    <option value="renovasi" {{ old('status', $venue->status) === 'renovasi' ? 'selected' : '' }}>Renovasi (Sedang Diperbaiki)</option>
                    <option value="tutup" {{ old('status', $venue->status) === 'tutup' ? 'selected' : '' }}>Tutup (Tutup Sementara)</option>
                </select>
            </div>

            <button type="submit" class="w-full btn-primary py-3 text-sm font-bold shadow-lg shadow-blue-500/20">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection

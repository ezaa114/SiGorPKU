@extends('layouts.pemilik')

@section('title', 'Daftar Lapangan GOR')
@section('header_title', 'Lapangan Olahraga')

@section('content')
<div class="card p-6 animate-fade-in-up">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Lapangan Olahraga</h3>
            <p class="text-sm text-slate-500">Kelola daftar lapangan olahraga yang disewakan di venue GOR Anda.</p>
        </div>
        <a href="{{ route('pemilik.lapangan.create') }}" class="btn-primary py-2.5 px-5 text-xs font-bold inline-flex items-center gap-1.5 shadow-md shadow-blue-500/20">
            <i class="fa-solid fa-plus"></i> Tambah Lapangan Baru
        </a>
    </div>

    @if($lapangans->isEmpty())
        <div class="text-center py-12 text-slate-400 text-sm">
            <i class="fa-solid fa-futbol text-5xl text-slate-300 mb-4 block"></i>
            Anda belum mendaftarkan lapangan olahraga. Daftarkan lapangan pertama Anda sekarang.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-12 text-center">No</th>
                        <th>Venue / GOR</th>
                        <th>Nama Lapangan</th>
                        <th>Kategori Olahraga</th>
                        <th>Harga Sewa / Jam</th>
                        <th>Status Sewa</th>
                        <th class="text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lapangans as $index => $lapangan)
                        <tr>
                            <td class="text-center text-slate-500 font-semibold">{{ $index + 1 }}</td>
                            <td class="font-bold text-slate-800">{{ $lapangan->venue->nama_venue }}</td>
                            <td class="font-semibold text-slate-700">
                                <div class="flex items-center gap-3">
                                    @if($lapangan->gambar_lapangan)
                                        @if(filter_var($lapangan->gambar_lapangan, FILTER_VALIDATE_URL))
                                            <img src="{{ $lapangan->gambar_lapangan }}" alt="{{ $lapangan->nama_lapangan }}" class="w-10 h-10 object-cover rounded-lg border border-slate-100 shadow-sm">
                                        @else
                                            <img src="{{ asset('storage/' . $lapangan->gambar_lapangan) }}" alt="{{ $lapangan->nama_lapangan }}" class="w-10 h-10 object-cover rounded-lg border border-slate-100 shadow-sm">
                                        @endif
                                    @else
                                        <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 text-xs">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                    <span>{{ $lapangan->nama_lapangan }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-xs font-bold text-blue-600 bg-blue-50 border border-blue-100 px-2.5 py-0.5 rounded">
                                    {{ $lapangan->jenisLapangan->nama_jenis }}
                                </span>
                            </td>
                            <td class="font-bold text-slate-800">{{ $lapangan->harga_formatted }}</td>
                            <td>
                                <span class="badge {{ $lapangan->status === 'tersedia' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $lapangan->status === 'tersedia' ? 'Tersedia' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="inline-flex gap-2">
                                    <a href="{{ route('pemilik.lapangan.edit', $lapangan->id_lapangan) }}" class="btn-secondary py-1 px-3 text-xs font-bold inline-flex items-center gap-1">
                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit
                                    </a>
                                    <form action="{{ route('pemilik.lapangan.delete', $lapangan->id_lapangan) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-danger py-1 px-3 text-xs font-bold inline-flex items-center gap-1" onclick="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?')">
                                            <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@extends('layouts.pemilik')

@section('title', 'Daftar GOR / Venue')
@section('header_title', 'Venue & Gedung Olahraga')

@section('content')
<div class="card p-6 animate-fade-in-up">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Gedung Olahraga (Venue) Saya</h3>
            <p class="text-sm text-slate-500">Kelola informasi GOR dan fasilitas olahraga yang Anda miliki.</p>
        </div>
        <a href="{{ route('pemilik.venue.create') }}" class="btn-primary py-2.5 px-5 text-xs font-bold inline-flex items-center gap-1.5 shadow-md shadow-blue-500/20">
            <i class="fa-solid fa-plus"></i> Daftarkan GOR Baru
        </a>
    </div>

    @if($venues->isEmpty())
        <div class="text-center py-12 text-slate-400 text-sm">
            <i class="fa-solid fa-building text-5xl text-slate-300 mb-4 block"></i>
            Anda belum mendaftarkan GOR apa pun. Silakan tambahkan venue pertama Anda.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($venues as $venue)
                <div class="card p-6 flex flex-col justify-between hover:shadow-lg transition-all border border-slate-100">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            @if($venue->status === 'aktif')
                                <span class="badge badge-success gap-1">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Aktif
                                </span>
                            @elseif($venue->status === 'nonaktif')
                                <span class="badge badge-gray gap-1">
                                    <i class="fa-solid fa-eye-slash text-[10px]"></i> Nonaktif
                                </span>
                            @elseif($venue->status === 'renovasi')
                                <span class="badge badge-warning gap-1">
                                    <i class="fa-solid fa-hammer text-[10px] animate-bounce"></i> Renovasi
                                </span>
                            @elseif($venue->status === 'tutup')
                                <span class="badge badge-danger gap-1">
                                    <i class="fa-solid fa-door-closed text-[10px]"></i> Tutup
                                </span>
                            @endif
                            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">{{ $venue->kecamatan }}</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $venue->nama_venue }}</h4>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed flex items-start gap-1">
                            <i class="fa-solid fa-location-dot mt-0.5 text-slate-400"></i>
                            <span>{{ $venue->alamat }}</span>
                        </p>
                        @if($venue->no_telepon)
                            <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
                                <i class="fa-solid fa-phone text-slate-400"></i>
                                <span>{{ $venue->no_telepon }}</span>
                            </p>
                        @endif
                    </div>

                    <div class="border-t border-slate-100 mt-6 pt-4 flex justify-between items-center">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">
                            {{ $venue->lapangans()->count() }} Lapangan
                        </span>
                        
                        <div class="flex gap-1.5">
                            <a href="{{ route('pemilik.venue.closures', $venue->id_venue) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 inline-flex items-center gap-1">
                                <i class="fa-solid fa-calendar-minus text-[10px]"></i> Tutup Hari
                            </a>
                            <a href="{{ route('pemilik.venue.edit', $venue->id_venue) }}" class="btn-secondary py-1 px-2.5 text-xs font-bold inline-flex items-center gap-1">
                                <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit
                            </a>
                            <form action="{{ route('pemilik.venue.delete', $venue->id_venue) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn-danger py-1 px-2.5 text-xs font-bold inline-flex items-center gap-1" onclick="return confirm('Apakah Anda yakin ingin menghapus GOR ini? Seluruh lapangan dan jadwal di dalamnya akan ikut terhapus.')">
                                    <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

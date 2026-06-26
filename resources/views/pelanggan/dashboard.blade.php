@extends('layouts.pelanggan')

@section('title', 'Cari Lapangan Olahraga Pekanbaru')

@section('content')
<div class="space-y-12 animate-fade-in-up">

    <!-- Hero / Search Section -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-indigo-800 rounded-3xl shadow-xl py-12 px-6 md:px-12 text-center text-white relative overflow-hidden">
        <!-- Decorative backdrop gradients -->
        <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-blue-500/25 blur-2xl"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 rounded-full bg-indigo-500/25 blur-2xl"></div>

        <div class="relative max-w-3xl mx-auto space-y-6">
            <span class="bg-white/15 border border-white/20 text-white font-bold text-xs uppercase tracking-widest px-3.5 py-1.5 rounded-full inline-block">
                Wilayah Layanan: Kota Pekanbaru
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1.15;">
                Pesan Lapangan Olahraga Mudah & Cepat di Pekanbaru
            </h1>
            <p class="text-blue-100 text-sm md:text-base max-w-xl mx-auto">
                Badminton, Futsal, Mini Soccer, Voli, Basket. Pilih GOR, lihat jadwal langsung, dan booking instan secara online!
            </p>

            <!-- Search Form -->
            <form action="{{ route('pelanggan.dashboard') }}" method="GET" class="bg-white p-3 rounded-2xl shadow-xl flex flex-col md:flex-row gap-3 mt-6 text-slate-800">
                <div class="flex-grow flex items-center gap-2 px-3 border-b md:border-b-0 md:border-r border-slate-200 py-2">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama venue atau lapangan..." class="w-full text-sm outline-none border-none bg-transparent">
                </div>

                <div class="md:w-48 flex items-center gap-2 px-3 border-b md:border-b-0 md:border-r border-slate-200 py-2">
                    <i class="fa-solid fa-location-dot text-slate-400 text-sm"></i>
                    <select name="kecamatan" class="w-full text-sm outline-none border-none bg-transparent">
                        <option value="">Semua Kecamatan</option>
                        @php
                            $kecamatans = ['Bukit Raya', 'Lima Puluh', 'Marpoyan Damai', 'Payung Sekaki', 'Pekanbaru Kota', 'Rumbai', 'Rumbai Barat', 'Rumbai Timur', 'Senapelan', 'Sukajadi', 'Tuah Madani', 'Tenayan Raya', 'Kulim'];
                        @endphp
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:w-48 flex items-center gap-2 px-3 py-2">
                    <i class="fa-solid fa-basketball text-slate-400 text-sm"></i>
                    <select name="jenis" class="w-full text-sm outline-none border-none bg-transparent">
                        <option value="">Semua Olahraga</option>
                        @foreach($categories as $jl)
                            <option value="{{ $jl->id_jenis }}" {{ request('jenis') == $jl->id_jenis ? 'selected' : '' }}>{{ $jl->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-primary py-3 px-6 text-sm font-bold shadow-lg shadow-blue-500/20">
                    Cari Lapangan
                </button>
            </form>
        </div>
    </div>

    <!-- Active Venues List -->
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-extrabold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Venue Olahraga Terverifikasi
                </h3>
                <p class="text-sm text-slate-500 mt-1">Daftar gedung olahraga aktif dan berizin di Kota Pekanbaru</p>
            </div>
            <a href="{{ route('pelanggan.dashboard') }}" class="text-sm font-bold text-blue-600 hover:underline">Reset Filter</a>
        </div>

        @if($venues->isEmpty())
            <div class="card p-12 text-center text-slate-400">
                <i class="fa-solid fa-calendar-xmark text-5xl text-slate-300 mb-4 block"></i>
                <p class="font-bold text-slate-600">Tidak ada venue yang ditemukan.</p>
                <p class="text-xs text-slate-400 mt-1">Silakan cari dengan kata kunci lain atau reset filter.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($venues as $venue)
                    @php
                        $isVerified = ($venue->pemilikGor->status_verifikasi ?? 'pending') === 'terverifikasi';
                    @endphp
                    <div class="card overflow-hidden hover:shadow-xl transition-all group flex flex-col justify-between border border-slate-100 bg-white rounded-2xl">
                        <!-- Card Image / Header -->
                        <div class="h-44 bg-gradient-to-br {{ $venue->gambar_venue ? 'from-slate-800 to-slate-900' : 'from-slate-100 to-slate-200' }} flex items-center justify-center relative overflow-hidden">
                            @if($venue->gambar_venue)
                                @if(filter_var($venue->gambar_venue, FILTER_VALIDATE_URL))
                                    <img src="{{ $venue->gambar_venue }}" alt="{{ $venue->nama_venue }}" class="absolute inset-0 w-full h-full object-cover opacity-85 group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <img src="{{ asset('storage/' . $venue->gambar_venue) }}" alt="{{ $venue->nama_venue }}" class="absolute inset-0 w-full h-full object-cover opacity-85 group-hover:scale-110 transition-transform duration-500">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent"></div>
                            @endif
                            <span class="text-slate-300 font-extrabold text-7xl select-none group-hover:scale-110 transition-transform z-10 {{ $venue->gambar_venue ? 'text-white/20' : '' }}">SiGOR</span>
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-wrap gap-2 z-10">
                                <span class="bg-blue-600 text-white font-bold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full shadow-sm">
                                    {{ $venue->kecamatan }}
                                </span>
                                @if(!$isVerified)
                                    <span class="bg-red-600 text-white font-bold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full shadow-sm">
                                        Belum Terverifikasi
                                    </span>
                                @endif
                                @if($venue->status === 'renovasi')
                                    <span class="bg-amber-500 text-white font-bold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full shadow-sm">
                                        <i class="fa-solid fa-hammer mr-0.5 animate-bounce"></i> Renovasi
                                    </span>
                                @elseif($venue->status === 'tutup')
                                    <span class="bg-red-600 text-white font-bold text-[10px] uppercase tracking-wider px-2.5 py-1 rounded-full shadow-sm">
                                        <i class="fa-solid fa-door-closed mr-0.5"></i> Tutup
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-grow">
                            <h4 class="text-lg font-bold transition-colors {{ ($isVerified && $venue->status === 'aktif') ? 'text-slate-900 group-hover:text-blue-600' : 'text-slate-400 line-through' }}" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                {{ $venue->nama_venue }}
                            </h4>
                            <p class="text-xs mt-1.5 leading-relaxed flex items-start gap-1 {{ ($isVerified && $venue->status === 'aktif') ? 'text-slate-500' : 'text-slate-400 line-through' }}">
                                <i class="fa-solid fa-location-dot mt-0.5 text-slate-400"></i>
                                <span>{{ $venue->alamat }}</span>
                            </p>
                            
                            <!-- Categories supported in this venue -->
                            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap gap-1.5 font-bold">
                                @php
                                    $olahragaSupported = $venue->lapangans->map(fn($l) => $l->jenisLapangan->nama_jenis ?? null)->filter()->unique();
                                @endphp
                                @foreach($olahragaSupported as $ol)
                                    <span class="text-[10px] text-blue-600 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded">
                                        {{ $ol }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Card Action -->
                        <div class="p-6 pt-0">
                            @if($venue->status === 'renovasi')
                                <button disabled class="w-full bg-amber-50 border border-amber-200 text-amber-600 py-2.5 text-xs font-bold justify-center flex rounded-xl cursor-not-allowed shadow-inner">
                                    <i class="fa-solid fa-hammer mr-1.5"></i> Sedang Renovasi
                                </button>
                            @elseif($venue->status === 'tutup')
                                <button disabled class="w-full bg-slate-100 border border-slate-200 text-slate-500 py-2.5 text-xs font-bold justify-center flex rounded-xl cursor-not-allowed shadow-inner">
                                    <i class="fa-solid fa-door-closed mr-1.5"></i> Tutup Sementara
                                </button>
                            @elseif($isVerified)
                                <a href="{{ route('pelanggan.venue.show', $venue->id_venue) }}" class="w-full btn-primary py-2.5 text-xs font-bold justify-center flex">
                                    Lihat Lapangan & Jadwal
                                </a>
                            @else
                                <button disabled class="w-full bg-slate-200 border border-slate-300 text-slate-400 py-2.5 text-xs font-bold justify-center flex rounded-xl cursor-not-allowed line-through">
                                    Booking Dinonaktifkan
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection

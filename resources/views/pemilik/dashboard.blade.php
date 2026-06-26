@extends('layouts.pemilik')

@section('title', 'Pemilik GOR Dashboard')
@section('header_title', 'Ringkasan Bisnis')

@section('content')
<div class="space-y-8 animate-fade-in-up">

    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h3 class="text-2xl md:text-3xl font-extrabold" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Selamat Datang, {{ Auth::guard('pemilik')->user()->nama }}!
            </h3>
            <p class="text-blue-100 mt-2 text-sm md:text-base">
                Kelola dan pantau seluruh penyewaan lapangan di <strong class="text-white">{{ Auth::guard('pemilik')->user()->nama_usaha }}</strong> secara mudah.
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('pemilik.jadwal.index') }}" class="bg-white/10 hover:bg-white/20 text-white font-semibold py-2.5 px-5 rounded-lg border border-white/20 transition-all text-sm">
                Atur Jadwal
            </a>
            <a href="{{ route('pemilik.venue.index') }}" class="bg-white text-blue-600 hover:bg-slate-50 font-bold py-2.5 px-5 rounded-lg shadow transition-all text-sm">
                Kelola Venue
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="card p-6 flex items-center justify-between hover:shadow-lg transition-all">
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Total Venue</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ $stats['total_venue'] }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-building"></i>
            </div>
        </div>

        <div class="card p-6 flex items-center justify-between hover:shadow-lg transition-all">
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Total Lapangan</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ $stats['total_lapangan'] }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-futbol"></i>
            </div>
        </div>

        <div class="card p-6 flex items-center justify-between hover:shadow-lg transition-all">
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Jadwal Aktif</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ $stats['jadwal_aktif'] }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>

        <div class="card p-6 flex items-center justify-between hover:shadow-lg transition-all">
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Booking Masuk</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ $stats['booking_masuk'] }}
                </h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
        </div>
    </div>

    <!-- Quick Action / Table Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Bookings Table -->
        <div class="card p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-lg font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Pemesanan Terbaru
                </h4>
                <a href="{{ route('pemilik.pembayaran.index') }}" class="text-sm font-semibold text-blue-600 hover:underline">Lihat Semua</a>
            </div>

            @if($pesanans->isEmpty())
                <div class="text-center py-10 text-slate-400 text-sm">
                    <i class="fa-solid fa-calendar-xmark text-4xl text-slate-300 mb-3 block"></i>
                    Belum ada pemesanan lapangan olahraga.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>Lapangan</th>
                                <th>Jadwal</th>
                                <th>Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanans as $pesanan)
                                <tr>
                                    <td class="font-semibold text-slate-800">{{ $pesanan->pelanggan->nama }}</td>
                                    <td>{{ $pesanan->jadwal->lapangan->nama_lapangan }}</td>
                                    <td>
                                        <div class="text-xs text-slate-700">{{ $pesanan->jadwal->tanggal->format('d/m/Y') }}</div>
                                        <div class="text-[10px] text-slate-500">{{ $pesanan->waktu_sewa }}</div>
                                    </td>
                                    <td class="font-medium">{{ $pesanan->total_harga_formatted }}</td>
                                    <td>
                                        <span class="badge {{ $pesanan->status_label['class'] }}">
                                            {{ $pesanan->status_label['label'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Venue Summary Card -->
        <div class="card p-6">
            <h4 class="text-lg font-bold text-slate-800 mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Venue Anda
            </h4>
            
            @if($venues->isEmpty())
                <div class="text-center py-8 text-slate-400 text-sm flex-grow flex flex-col justify-center items-center">
                    <i class="fa-solid fa-circle-info text-3xl text-blue-400 mb-2"></i>
                    Anda belum mendaftarkan Venue / GOR.
                    <a href="{{ route('pemilik.venue.create') }}" class="btn-primary py-2 w-full text-center mt-4">
                        Daftar Venue Baru
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($venues as $venue)
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 hover:bg-slate-100 transition-all">
                            <h5 class="font-bold text-slate-800">{{ $venue->nama_venue }}</h5>
                            <p class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-location-dot"></i> {{ $venue->kecamatan }}, Pekanbaru</p>
                            <div class="flex justify-between items-center mt-3 pt-3 border-t border-slate-200/50">
                                <span class="text-xs font-semibold text-slate-500">{{ $venue->lapangans()->count() }} Lapangan</span>
                                <span class="badge {{ $venue->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                                    {{ ucfirst($venue->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection

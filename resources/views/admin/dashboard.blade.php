@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header_title', 'Ringkasan Platform')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="card p-6 flex items-center justify-between hover:shadow-lg transition-all">
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Pemilik GOR</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ \App\Models\PemilikGor::count() }}
                </h3>
                <p class="text-xs text-slate-500 mt-2">
                    <span class="text-amber-500 font-bold"><i class="fa-solid fa-clock"></i> {{ \App\Models\PemilikGor::where('status_verifikasi', 'pending')->count() }} pending</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card p-6 flex items-center justify-between hover:shadow-lg transition-all">
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Total Venue</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ \App\Models\Venue::count() }}
                </h3>
                <p class="text-xs text-emerald-500 font-bold mt-2">
                    <i class="fa-solid fa-circle-check"></i> {{ \App\Models\Venue::where('status', 'aktif')->count() }} aktif
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-building-circle-check"></i>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card p-6 flex items-center justify-between hover:shadow-lg transition-all">
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Total Pelanggan</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ \App\Models\Pelanggan::count() }}
                </h3>
                <p class="text-xs text-slate-500 mt-2">Terdaftar di Pekanbaru</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-user-tag"></i>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="card p-6 flex items-center justify-between hover:shadow-lg transition-all">
            <div>
                <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Total Booking</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ \App\Models\Pemesanan::count() }}
                </h3>
                <p class="text-xs text-slate-500 mt-2">
                    <span class="text-emerald-600 font-bold">{{ \App\Models\Pemesanan::where('status_pesan', 'dikonfirmasi')->count() }} selesai</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>
    </div>

    <!-- Quick Links & Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Pending Verification List -->
        <div class="card p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-lg font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Verifikasi Pemilik GOR Baru
                </h4>
                <a href="{{ route('admin.pemilik-gor.index') }}" class="text-sm font-semibold text-blue-600 hover:underline">Lihat Semua</a>
            </div>

            @if($pendingOwners->isEmpty())
                <div class="text-center py-8 text-slate-400 text-sm">
                    <i class="fa-solid fa-circle-check text-4xl text-emerald-400 mb-3 block"></i>
                    Tidak ada pendaftaran baru yang perlu diverifikasi.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Pemilik</th>
                                <th>Nama Usaha</th>
                                <th>Email / Telepon</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingOwners as $owner)
                                <tr>
                                    <td class="font-semibold text-slate-800">{{ $owner->nama }}</td>
                                    <td>{{ $owner->nama_usaha }}</td>
                                    <td>
                                        <div class="text-xs text-slate-500">{{ $owner->email }}</div>
                                        <div class="text-xs text-slate-400">{{ $owner->no_telepon }}</div>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.pemilik-gor.show', $owner->id_pemilik) }}" class="btn-primary py-1 px-3 text-xs">
                                            Proses
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Master Data Stats -->
        <div class="card p-6 flex flex-col justify-between">
            <div>
                <h4 class="text-lg font-bold text-slate-800 mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Jenis Lapangan
                </h4>
                <div class="space-y-3">
                    @foreach(\App\Models\JenisLapangan::all() as $jenis)
                        <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                            <span class="text-sm font-semibold text-slate-700">{{ $jenis->nama_jenis }}</span>
                            <span class="badge badge-info">{{ $jenis->lapangans()->count() }} Lapangan</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('admin.jenis-lapangan.index') }}" class="btn-secondary w-full text-center py-2.5 text-sm mt-6">
                Kelola Jenis Lapangan
            </a>
        </div>
    </div>

</div>
@endsection

@extends('layouts.admin')

@section('title', 'Detail Pemilik GOR')
@section('header_title', 'Detail Akun Pemilik GOR')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-in-up">

    <!-- Breadcrumb back link -->
    <div>
        <a href="{{ route('admin.pemilik-gor.index') }}" class="text-sm font-semibold text-blue-600 hover:underline inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pemilik GOR
        </a>
    </div>

    <!-- Main Detail Card -->
    <div class="card p-8 space-y-6">
        <div class="flex justify-between items-start border-b border-slate-100 pb-6">
            <div>
                <h3 class="text-2xl font-extrabold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $pemilik->nama_usaha }}</h3>
                <p class="text-sm text-slate-500 mt-1">Daftar Akun Pemilik GOR: {{ $pemilik->nama }}</p>
            </div>
            <div>
                @if($pemilik->status_verifikasi === 'pending')
                    <span class="badge badge-warning text-sm px-4 py-1.5">
                        <i class="fa-solid fa-clock mr-1"></i> Menunggu Verifikasi
                    </span>
                @elseif($pemilik->status_verifikasi === 'terverifikasi')
                    <span class="badge badge-success text-sm px-4 py-1.5">
                        <i class="fa-solid fa-circle-check mr-1"></i> Terverifikasi / Aktif
                    </span>
                @else
                    <span class="badge badge-danger text-sm px-4 py-1.5">
                        <i class="fa-solid fa-circle-xmark mr-1"></i> Pendaftaran Ditolak
                    </span>
                @endif
            </div>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase">Nama Lengkap Pemilik</span>
                <p class="text-slate-800 font-bold text-base">{{ $pemilik->nama }}</p>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase">Alamat Email</span>
                <p class="text-slate-800 font-bold text-base">{{ $pemilik->email }}</p>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase">Nomor Telepon / WhatsApp</span>
                <p class="text-slate-800 font-bold text-base">{{ $pemilik->no_telepon }}</p>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-400 uppercase">Tanggal Mendaftar</span>
                <p class="text-slate-800 font-bold text-base">{{ $pemilik->created_at->format('d F Y (H:i)') }}</p>
            </div>
        </div>

        <!-- Action Form / Verifikasi Buttons -->
        <div class="bg-slate-50 rounded-2xl border border-slate-100 p-6 flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
            <div class="text-center sm:text-left">
                <h4 class="font-bold text-slate-800">Proses Pendaftaran Akun</h4>
                <p class="text-xs text-slate-500 mt-0.5">Tentukan persetujuan pendaftaran pemilik GOR ini.</p>
            </div>
            <div class="flex gap-3 w-full sm:w-auto items-center justify-center">
                @if($pemilik->status_verifikasi === 'terverifikasi')
                    <div class="flex items-center gap-3">
                        <span class="badge badge-success text-sm px-4 py-1.5 flex items-center gap-1">
                            <i class="fa-solid fa-circle-check"></i> Terverifikasi / Aktif
                        </span>
                        <form action="{{ route('admin.pemilik-gor.verifikasi', $pemilik->id_pemilik) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-full w-8 h-8 flex items-center justify-center transition-all shadow-sm" title="Batalkan Verifikasi" onclick="return confirm('Apakah Anda yakin ingin membatalkan verifikasi pemilik GOR ini?')">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Reject Button/Form -->
                    <form action="{{ route('admin.pemilik-gor.verifikasi', $pemilik->id_pemilik) }}" method="POST" class="flex-1 sm:flex-none">
                        @csrf
                        <input type="hidden" name="status" value="ditolak">
                        <button type="submit" class="w-full btn-danger py-2 px-6 text-xs font-bold" onclick="return confirm('Apakah Anda yakin ingin menolak pendaftaran pemilik GOR ini?')">
                            <i class="fa-solid fa-circle-xmark mr-1"></i> Tolak Pendaftaran
                        </button>
                    </form>

                    <!-- Approve Button/Form -->
                    <form action="{{ route('admin.pemilik-gor.verifikasi', $pemilik->id_pemilik) }}" method="POST" class="flex-1 sm:flex-none">
                        @csrf
                        <input type="hidden" name="status" value="terverifikasi">
                        <button type="submit" class="w-full btn-success py-2 px-6 text-xs font-bold" onclick="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran pemilik GOR ini?')">
                            <i class="fa-solid fa-circle-check mr-1"></i> Setujui Akun
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

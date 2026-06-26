@extends('layouts.admin')

@section('title', 'Verifikasi Pemilik GOR')
@section('header_title', 'Verifikasi Akun Pemilik GOR')

@section('content')
<div class="card p-6 animate-fade-in-up">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Akun Pemilik GOR</h3>
        <p class="text-sm text-slate-500">Kelola persetujuan (approval) pendaftaran pemilik GOR baru agar dapat mengelola venue olahraga.</p>
    </div>

    @if($pemiliks->isEmpty())
        <div class="text-center py-12 text-slate-400 text-sm">
            <i class="fa-solid fa-users-slash text-5xl text-slate-300 mb-4 block"></i>
            Belum ada pemilik GOR yang mendaftar.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Pemilik</th>
                        <th>Nama Usaha / GOR</th>
                        <th>Alamat Email</th>
                        <th>No. Telepon</th>
                        <th>Status Verifikasi</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemiliks as $pemilik)
                        <tr>
                            <td class="font-semibold text-slate-800">{{ $pemilik->nama }}</td>
                            <td class="font-medium text-slate-700">{{ $pemilik->nama_usaha }}</td>
                            <td>{{ $pemilik->email }}</td>
                            <td>{{ $pemilik->no_telepon }}</td>
                            <td>
                                @if($pemilik->status_verifikasi === 'pending')
                                    <span class="badge badge-warning">
                                        <i class="fa-solid fa-clock mr-1"></i> Menunggu
                                    </span>
                                @elseif($pemilik->status_verifikasi === 'terverifikasi')
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-circle-check mr-1"></i> Terverifikasi
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fa-solid fa-circle-xmark mr-1"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="text-xs text-slate-500">{{ $pemilik->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.pemilik-gor.show', $pemilik->id_pemilik) }}" class="btn-secondary py-1.5 px-3 text-xs font-bold inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-eye"></i> Detail & Verifikasi
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

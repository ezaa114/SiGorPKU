@extends('layouts.admin')

@section('title', 'Kelola Pelanggan')
@section('header_title', 'Kelola Akun Pelanggan')

@section('content')
<div class="card p-6 animate-fade-in-up">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Akun Pelanggan</h3>
        <p class="text-sm text-slate-500">Melihat daftar pelanggan terdaftar, memblokir akun yang melanggar ketentuan, atau membuka blokir kembali.</p>
    </div>

    @if($pelanggans->isEmpty())
        <div class="text-center py-12 text-slate-400 text-sm">
            <i class="fa-solid fa-users-slash text-5xl text-slate-300 mb-4 block"></i>
            Belum ada pelanggan yang mendaftar.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>Alamat Email</th>
                        <th>No. Telepon</th>
                        <th>Status Akun</th>
                        <th>Tanggal Daftar</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggans as $pelanggan)
                        <tr>
                            <td class="font-semibold text-slate-800">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($pelanggan->nama, 0, 1) }}
                                    </div>
                                    <span>{{ $pelanggan->nama }}</span>
                                </div>
                            </td>
                            <td>{{ $pelanggan->email }}</td>
                            <td>{{ $pelanggan->no_telepon ?? '-' }}</td>
                            <td>
                                @if($pelanggan->status === 'aktif')
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-circle-check mr-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fa-solid fa-ban mr-1"></i> Diblokir
                                    </span>
                                @endif
                            </td>
                            <td class="text-xs text-slate-500">{{ $pelanggan->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.pelanggan.toggle-status', $pelanggan->id_pelanggan) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin {{ $pelanggan->status === 'aktif' ? 'memblokir' : 'membuka blokir' }} akun pelanggan {{ $pelanggan->nama }}?')">
                                    @csrf
                                    @if($pelanggan->status === 'aktif')
                                        <button type="submit" class="btn-danger py-1.5 px-3.5 text-xs font-bold inline-flex items-center gap-1.5 rounded-lg transition-colors">
                                            <i class="fa-solid fa-ban"></i> Blokir Akun
                                        </button>
                                    @else
                                        <button type="submit" class="btn-success py-1.5 px-3.5 text-xs font-bold inline-flex items-center gap-1.5 rounded-lg transition-colors">
                                            <i class="fa-solid fa-key"></i> Buka Blokir
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

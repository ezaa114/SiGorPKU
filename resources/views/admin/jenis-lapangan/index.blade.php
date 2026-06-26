@extends('layouts.admin')

@section('title', 'Kategori Olahraga')
@section('header_title', 'Kelola Kategori Olahraga')

@section('content')
<div class="card p-6 animate-fade-in-up">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Kategori Olahraga</h3>
            <p class="text-sm text-slate-500">Kelola master data kategori jenis lapangan olahraga yang didukung oleh SiGOR PKU.</p>
        </div>
        <a href="{{ route('admin.jenis-lapangan.create') }}" class="btn-primary py-2.5 px-5 text-xs font-bold inline-flex items-center gap-1.5 shadow-md shadow-blue-500/20">
            <i class="fa-solid fa-plus"></i> Tambah Kategori
        </a>
    </div>

    @if($jenis->isEmpty())
        <div class="text-center py-12 text-slate-400 text-sm">
            <i class="fa-solid fa-layer-group text-5xl text-slate-300 mb-4 block"></i>
            Belum ada kategori olahraga yang terdaftar.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-16 text-center">No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jenis as $index => $item)
                        <tr>
                            <td class="text-center text-slate-500 font-semibold">{{ $index + 1 }}</td>
                            <td class="font-bold text-slate-800">{{ $item->nama_jenis }}</td>
                            <td class="text-slate-600 leading-relaxed max-w-sm truncate">{{ $item->deskripsi ?? '-' }}</td>
                            <td class="text-center">
                                <div class="inline-flex gap-2">
                                    <!-- Edit Link -->
                                    <a href="{{ route('admin.jenis-lapangan.edit', $item->id_jenis) }}" class="btn-secondary py-1 px-3 text-xs font-bold inline-flex items-center gap-1">
                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.jenis-lapangan.delete', $item->id_jenis) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-danger py-1 px-3 text-xs font-bold inline-flex items-center gap-1" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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

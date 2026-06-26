@extends('layouts.admin')

@php
    $isEdit = isset($jenis);
    $actionUrl = $isEdit ? route('admin.jenis-lapangan.update', $jenis->id_jenis) : route('admin.jenis-lapangan.store');
    $title = $isEdit ? 'Ubah Kategori Olahraga' : 'Tambah Kategori Olahraga';
@endphp

@section('title', $title)
@section('header_title', $title)

@section('content')
<div class="max-w-xl mx-auto space-y-6 animate-fade-in-up">
    <!-- Breadcrumb back link -->
    <div>
        <a href="{{ route('admin.jenis-lapangan.index') }}" class="text-sm font-semibold text-blue-600 hover:underline inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Kategori
        </a>
    </div>

    <!-- Form Card -->
    <div class="card p-8">
        <h3 class="text-xl font-extrabold text-slate-800 mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $title }}</h3>

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

        <form action="{{ $actionUrl }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="nama_jenis" class="form-label">Nama Kategori Olahraga</label>
                <input type="text" id="nama_jenis" name="nama_jenis" value="{{ old('nama_jenis', $jenis->nama_jenis ?? '') }}" required class="form-input" placeholder="Contoh: Badminton, Futsal, Mini Soccer">
                <p class="text-[10px] text-slate-400 mt-1">Nama kategori bersifat unik dan maksimal 50 karakter.</p>
            </div>

            <div>
                <label for="deskripsi" class="form-label">Deskripsi Kategori (Opsional)</label>
                <textarea id="deskripsi" name="deskripsi" class="form-input h-32 leading-relaxed" placeholder="Tulis deskripsi singkat mengenai fasilitas atau ukuran lapangan standar untuk olahraga ini...">{{ old('deskripsi', $jenis->deskripsi ?? '') }}</textarea>
            </div>

            <button type="submit" class="w-full btn-primary py-3 text-sm font-bold shadow-lg shadow-blue-500/20">
                {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Kategori' }}
            </button>
        </form>
    </div>
</div>
@endsection

@extends('layouts.pemilik')

@section('title', 'Kelola Hari Libur GOR - ' . $venue->nama_venue)
@section('header_title', 'Tutup Hari / Libur GOR')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    <!-- Breadcrumb back link -->
    <div>
        <a href="{{ route('pemilik.venue.index') }}" class="text-sm font-semibold text-blue-600 hover:underline inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar GOR
        </a>
    </div>

    <!-- Alert Flash Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Form to Add Closure -->
        <div class="card p-6 h-fit border border-slate-100 shadow-sm bg-white rounded-2xl">
            <h3 class="text-lg font-bold text-slate-800 mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <i class="fa-solid fa-calendar-plus text-blue-600 mr-1.5"></i> Tutup GOR / Tambah Hari Libur
            </h3>
            <p class="text-xs text-slate-500 mb-5 leading-relaxed">Pilih tanggal di mana GOR <strong>{{ $venue->nama_venue }}</strong> akan diliburkan. Pelanggan tidak akan bisa memesan lapangan di tanggal tersebut.</p>

            <form action="{{ route('pemilik.venue.closures.store', $venue->id_venue) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="tanggal" class="form-label font-bold text-xs text-slate-600">Pilih Tanggal Tutup</label>
                    <input type="date" id="tanggal" name="tanggal" required min="{{ date('Y-m-d') }}" class="form-input text-sm">
                </div>
                <div>
                    <label for="keterangan" class="form-label font-bold text-xs text-slate-600">Alasan Tutup (Opsional)</label>
                    <input type="text" id="keterangan" name="keterangan" class="form-input text-sm" placeholder="Contoh: Libur Lebaran, Maintenance GOR">
                </div>
                <button type="submit" class="w-full btn-primary py-2.5 text-xs font-bold shadow-md shadow-blue-500/10 inline-flex justify-center items-center gap-1.5">
                    <i class="fa-solid fa-lock"></i> Tutup GOR pada Tanggal Ini
                </button>
            </form>
        </div>

        <!-- Right: Current Closures List -->
        <div class="lg:col-span-2 card p-6 border border-slate-100 shadow-sm bg-white rounded-2xl">
            <h3 class="text-lg font-bold text-slate-800 mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <i class="fa-solid fa-calendar-days text-blue-600 mr-1.5"></i> Daftar Hari Libur GOR Saat Ini
            </h3>

            @if($closures->isEmpty())
                <div class="text-center py-12 text-slate-400 text-sm">
                    <i class="fa-solid fa-calendar-check text-5xl text-slate-200 mb-4 block"></i>
                    Belum ada tanggal libur yang didaftarkan. GOR saat ini buka setiap hari.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr class="border-b border-slate-100 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                                <th class="py-3 px-4 w-12 text-center">No</th>
                                <th class="py-3 px-4">Tanggal Tutup</th>
                                <th class="py-3 px-4">Hari</th>
                                <th class="py-3 px-4">Keterangan</th>
                                <th class="py-3 px-4 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($closures as $index => $closure)
                                <tr class="border-b border-slate-100 text-sm hover:bg-slate-50 transition-colors">
                                    <td class="py-3 px-4 text-center text-slate-500 font-semibold">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-bold text-slate-800 font-mono">{{ $closure->tanggal->format('d F Y') }}</td>
                                    <td class="py-3 px-4 font-semibold text-slate-600">{{ $closure->tanggal->isoFormat('dddd') }}</td>
                                    <td class="py-3 px-4 text-slate-500">{{ $closure->keterangan ?? '-' }}</td>
                                    <td class="py-3 px-4 text-center">
                                        <form action="{{ route('pemilik.venue.closures.delete', [$venue->id_venue, $closure->id_closure]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-danger py-1 px-2.5 text-xs font-bold inline-flex items-center gap-1" onclick="return confirm('Apakah Anda yakin ingin menghapus hari libur ini? GOR akan dibuka kembali pada tanggal tersebut.')">
                                                <i class="fa-solid fa-unlock-keyhole text-[10px]"></i> Buka Kembali
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

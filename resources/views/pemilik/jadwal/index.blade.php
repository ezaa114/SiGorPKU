@extends('layouts.pemilik')

@section('title', 'Jadwal Sewa Lapangan')
@section('header_title', 'Jadwal Lapangan')

@section('content')
<div class="space-y-6">
    <!-- Alert Flash Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in-up">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-sm font-semibold flex items-center gap-2 shadow-sm animate-fade-in-up">
            <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="card p-6 bg-white border border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 animate-fade-in-up">
        <div>
            <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pengelolaan Jadwal Lapangan</h3>
            <p class="text-sm text-slate-500">Pilih lapangan dan tanggal di bawah untuk mengelola slot waktu operasional atau menghapus jadwal.</p>
        </div>
        <a href="{{ route('pemilik.jadwal.create') }}" class="btn-primary py-2.5 px-5 text-xs font-bold inline-flex items-center gap-1.5 shadow-md shadow-blue-500/20">
            <i class="fa-solid fa-plus"></i> Generate Jadwal Otomatis
        </a>
    </div>

    @if($jadwals->isEmpty())
        <div class="card p-12 text-center text-slate-400 bg-white border border-slate-100">
            <i class="fa-solid fa-calendar-xmark text-5xl text-slate-300 mb-4 block"></i>
            Belum ada slot jadwal sewa lapangan yang dibuat. Silakan tambahkan slot jadwal pertama Anda.
        </div>
    @else
        @php
            // Group jadwals by court (id_lapangan) and then by date
            $groupedJadwals = $jadwals->groupBy('id_lapangan')->map(function ($courtJadwals) {
                return $courtJadwals->groupBy(function ($j) {
                    return $j->tanggal->format('Y-m-d');
                });
            });

            // Keep track of court details
            $lapangansMap = $jadwals->pluck('lapangan')->unique('id_lapangan')->keyBy('id_lapangan');
        @endphp

        @foreach($groupedJadwals as $lapanganId => $datesJadwals)
            @php
                $lapangan = $lapangansMap[$lapanganId];
            @endphp
            <div class="card p-6 bg-white border border-slate-100 shadow-md rounded-2xl space-y-6 animate-fade-in-up">
                <!-- Header Lapangan -->
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-futbol"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-800 text-base" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $lapangan->nama_lapangan }}
                        </h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">
                            {{ $lapangan->jenisLapangan->nama_jenis }} &bull; {{ $lapangan->venue->nama_venue }}
                        </p>
                    </div>
                </div>

                <!-- Tanggal Selector (Tabs) -->
                <div class="space-y-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Pilih Tanggal Jadwal:</span>
                    <div class="flex flex-wrap gap-2">
                        @php $isFirst = true; @endphp
                        @foreach($datesJadwals as $dateStr => $slots)
                            @php
                                $carbonDate = \Carbon\Carbon::parse($dateStr);
                                $formattedDate = $carbonDate->isoFormat('D MMM YYYY');
                                $isPassed = $carbonDate->lt(today());
                                if ($isFirst) {
                                    $activeClass = $isPassed 
                                        ? 'bg-slate-400 text-white shadow-sm' 
                                        : 'bg-blue-600 text-white shadow-md shadow-blue-500/20';
                                } else {
                                    $activeClass = $isPassed 
                                        ? 'bg-slate-100/80 text-slate-400 border border-slate-200/40 hover:bg-slate-200/60' 
                                        : 'bg-slate-50 text-slate-600 border border-slate-200/60 hover:bg-slate-100';
                                }
                                $tabId = "tab-{$lapanganId}-{$dateStr}";
                            @endphp
                            <button type="button" 
                                    onclick="switchTab('{{ $lapanganId }}', '{{ $dateStr }}')"
                                    id="btn-{{ $tabId }}"
                                    data-passed="{{ $isPassed ? 'true' : 'false' }}"
                                    class="tab-btn-{{ $lapanganId }} px-3.5 py-2 text-xs font-bold rounded-xl transition-all {{ $activeClass }}">
                                {{ $formattedDate }}
                                <span class="ml-1 text-[10px] opacity-75 font-normal">({{ $slots->count() }})</span>
                            </button>
                            @php $isFirst = false; @endphp
                        @endforeach
                    </div>
                </div>

                <!-- Slot Waktu Grid -->
                <div class="pt-2 border-t border-slate-100/60">
                    @php $isFirst = true; @endphp
                    @foreach($datesJadwals as $dateStr => $slots)
                        @php
                            $tabId = "tab-{$lapanganId}-{$dateStr}";
                            $hiddenClass = $isFirst ? '' : 'hidden';
                        @endphp
                        <div id="content-{{ $tabId }}" class="tab-content-{{ $lapanganId }} {{ $hiddenClass }} space-y-4">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-blue-50/50 border border-blue-100/50 rounded-xl p-3 px-4 text-xs font-semibold text-blue-800 gap-3">
                                <span><i class="fa-solid fa-clock mr-1"></i> Slot Jam pada {{ \Carbon\Carbon::parse($dateStr)->isoFormat('dddd, D MMMM YYYY') }}</span>
                                <div class="flex items-center gap-3">
                                    @if(isset($closuresGrouped[$lapangan->id_venue][$dateStr]))
                                        <a href="{{ route('pemilik.venue.closures', $lapangan->id_venue) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-1 px-3 rounded-lg text-[10px] transition-all flex items-center gap-1.5 shadow-sm shadow-amber-500/10" title="Klik untuk mengelola/membuka kembali GOR">
                                            <i class="fa-solid fa-key"></i> GOR Ditutup pada Tanggal Ini (Kelola)
                                        </a>
                                    @else
                                        <form action="{{ route('pemilik.venue.closures.store', $lapangan->id_venue) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menutup GOR ini pada tanggal {{ \Carbon\Carbon::parse($dateStr)->isoFormat('D MMMM YYYY') }}? Seluruh slot jadwal yang belum dipesan pada tanggal ini otomatis tidak dapat disewa.')">
                                            @csrf
                                            <input type="hidden" name="tanggal" value="{{ $dateStr }}">
                                            <input type="hidden" name="keterangan" value="Ditutup dari halaman Jadwal">
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-lg text-[10px] transition-all flex items-center gap-1 shadow-sm">
                                                <i class="fa-solid fa-calendar-minus"></i> Tutup GOR pada Tanggal Ini
                                            </button>
                                        </form>
                                    @endif
                                    <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-[10px]">Total: {{ $slots->count() }} Slot</span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach($slots->sortBy('jam_mulai') as $jadwal)
                                    <div class="p-3 bg-slate-50 border border-slate-200/60 rounded-xl flex items-center justify-between shadow-sm">
                                        <div class="space-y-1">
                                            <span class="font-mono font-bold text-xs text-slate-700 block">{{ $jadwal->waktu }}</span>
                                            @if($isPassed)
                                                @if($jadwal->ketersediaan === 'tersedia')
                                                    <span class="text-[9px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full font-bold border border-slate-200 uppercase tracking-wider">Kedaluwarsa</span>
                                                @else
                                                    <span class="text-[9px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full font-bold border border-slate-200 uppercase tracking-wider" title="Jadwal sudah lampau">Selesai (Dipesan)</span>
                                                @endif
                                            @elseif($jadwal->ketersediaan === 'tersedia')
                                                <span class="text-[9px] text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full font-bold border border-emerald-100 uppercase tracking-wider">Tersedia</span>
                                            @else
                                                <span class="text-[9px] text-red-600 bg-red-50 px-2 py-0.5 rounded-full font-bold border border-red-100 uppercase tracking-wider">Dipesan</span>
                                            @endif
                                        </div>
                                        
                                        @if($isPassed)
                                            <span class="text-[10px] text-slate-400 font-semibold p-1.5" title="Slot sudah lewat masa aktif">
                                                <i class="fa-solid fa-clock-rotate-left"></i>
                                            </span>
                                        @elseif($jadwal->ketersediaan === 'tersedia')
                                            <form action="{{ route('pemilik.jadwal.delete', $jadwal->id_jadwal) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-500 hover:text-red-700 p-1.5 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Slot" onclick="return confirm('Apakah Anda yakin ingin menghapus slot jadwal ini?')">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-slate-400 italic font-semibold p-1.5" title="Slot sudah dipesan pelanggan">
                                                <i class="fa-solid fa-lock"></i>
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @php $isFirst = false; @endphp
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>

<script>
    function switchTab(lapanganId, dateStr) {
        // Hide all tab content for this court
        const contents = document.querySelectorAll('.tab-content-' + lapanganId);
        contents.forEach(el => el.classList.add('hidden'));

        // Reset all button styles for this court
        const buttons = document.querySelectorAll('.tab-btn-' + lapanganId);
        buttons.forEach(btn => {
            const isPassed = btn.getAttribute('data-passed') === 'true';
            if (isPassed) {
                btn.className = `tab-btn-${lapanganId} px-3.5 py-2 text-xs font-bold rounded-xl transition-all bg-slate-100/80 text-slate-400 border border-slate-200/40 hover:bg-slate-200/60`;
            } else {
                btn.className = `tab-btn-${lapanganId} px-3.5 py-2 text-xs font-bold rounded-xl transition-all bg-slate-50 text-slate-600 border border-slate-200/60 hover:bg-slate-100`;
            }
        });

        // Show the active tab content
        const targetContent = document.getElementById('content-tab-' + lapanganId + '-' + dateStr);
        if (targetContent) {
            targetContent.classList.remove('hidden');
        }

        // Set the clicked button to active state
        const targetButton = document.getElementById('btn-tab-' + lapanganId + '-' + dateStr);
        if (targetButton) {
            const isPassed = targetButton.getAttribute('data-passed') === 'true';
            if (isPassed) {
                targetButton.className = `tab-btn-${lapanganId} px-3.5 py-2 text-xs font-bold rounded-xl transition-all bg-slate-400 text-white shadow-sm`;
            } else {
                targetButton.className = `tab-btn-${lapanganId} px-3.5 py-2 text-xs font-bold rounded-xl transition-all bg-blue-600 text-white shadow-md shadow-blue-500/20`;
            }
        }
    }
</script>
@endsection

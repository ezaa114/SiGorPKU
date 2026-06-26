@extends('layouts.pelanggan')

@section('title', $venue->nama_venue)

@section('content')
<div class="space-y-8 animate-fade-in-up">
    @php
        $isVerified = ($venue->pemilikGor->status_verifikasi ?? 'pending') === 'terverifikasi';
    @endphp
    
    <!-- Breadcrumb back link -->
    <div>
        <a href="{{ route('pelanggan.dashboard') }}" class="text-sm font-semibold text-blue-600 hover:underline inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Pencarian
        </a>
    </div>

    <!-- Venue Banner Image if available -->
    @if($venue->gambar_venue)
        <div class="h-64 md:h-80 w-full rounded-2xl overflow-hidden relative border border-slate-100 shadow-md">
            @if(filter_var($venue->gambar_venue, FILTER_VALIDATE_URL))
                <img src="{{ $venue->gambar_venue }}" alt="{{ $venue->nama_venue }}" class="w-full h-full object-cover">
            @else
                <img src="{{ asset('storage/' . $venue->gambar_venue) }}" alt="{{ $venue->nama_venue }}" class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent"></div>
        </div>
    @endif

    <!-- Venue Detail Header -->
    <div class="card p-8 bg-white border border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-3">
                <span class="bg-blue-600 text-white font-bold text-xs uppercase tracking-wider px-3 py-1 rounded-full">
                    {{ $venue->kecamatan }}
                </span>
                @if($isVerified)
                    <span class="text-xs text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-0.5 rounded font-bold">
                        Terverifikasi
                    </span>
                @else
                    <span class="text-xs text-red-600 bg-red-50 border border-red-100 px-2.5 py-0.5 rounded font-bold">
                        Belum Terverifikasi
                    </span>
                @endif
            </div>
            <h2 class="text-3xl font-extrabold mt-3 {{ $isVerified ? 'text-slate-900' : 'text-slate-400 line-through' }}" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $venue->nama_venue }}</h2>
            <p class="text-slate-500 text-sm mt-2 flex items-start gap-1">
                <i class="fa-solid fa-location-dot mt-0.5 text-slate-400"></i>
                <span class="{{ $isVerified ? '' : 'line-through' }}">{{ $venue->alamat }}</span>
            </p>
        </div>

        @if($venue->no_telepon)
            <div class="w-full md:w-auto bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Telepon GOR</span>
                    <p class="text-sm font-bold text-slate-800">{{ $venue->no_telepon }}</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Fields & Schedules -->
        <div class="lg:col-span-2 space-y-6">
            <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pilih Lapangan & Jadwal Tersedia</h3>

            @if($venue->lapangans->isEmpty())
                <div class="card p-12 text-center text-slate-400 bg-white border border-slate-100">
                    <i class="fa-solid fa-futbol text-5xl text-slate-300 mb-4 block"></i>
                    <p class="font-bold">GOR ini belum mendaftarkan lapangan olahraga.</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($venue->lapangans as $lapangan)
                        <div class="card bg-white p-6 border border-slate-100 flex flex-col md:flex-row justify-between items-start gap-6 hover:shadow-md transition-all">
                            <!-- Field details -->
                            <div class="md:w-1/3 space-y-3">
                                @if($lapangan->gambar_lapangan)
                                    <div class="h-28 w-full rounded-xl overflow-hidden relative border border-slate-100 shadow-sm mb-3">
                                        @if(filter_var($lapangan->gambar_lapangan, FILTER_VALIDATE_URL))
                                            <img src="{{ $lapangan->gambar_lapangan }}" alt="{{ $lapangan->nama_lapangan }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('storage/' . $lapangan->gambar_lapangan) }}" alt="{{ $lapangan->nama_lapangan }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                @endif
                                <div class="space-y-1.5">
                                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-100 px-2.5 py-0.5 rounded uppercase tracking-wider">
                                        {{ $lapangan->jenisLapangan->nama_jenis }}
                                    </span>
                                    <h4 class="text-lg font-bold {{ $isVerified ? 'text-slate-900' : 'text-slate-400 line-through' }}" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $lapangan->nama_lapangan }}</h4>
                                    <p class="text-xs text-slate-500 font-bold mt-1">Tarif Sewa: <span class="text-blue-600 text-sm font-extrabold {{ $isVerified ? '' : 'line-through' }}">{{ $lapangan->harga_formatted }}</span> / jam</p>
                                    <span class="badge {{ $lapangan->status === 'tersedia' ? 'badge-success' : 'badge-danger' }} text-[10px]">
                                        {{ $lapangan->status === 'tersedia' ? 'Aktif / Tersedia' : 'Dalam Perbaikan' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Schedule Slots list -->
                            <div class="flex-grow w-full md:w-auto space-y-4">
                                <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">
                                    <i class="fa-solid fa-calendar-day text-blue-500 mr-1"></i> Pilih Tanggal & Slot Waktu:
                                </h5>
                                
                                @php
                                    // Group available slots by date
                                    $groupedSlots = $lapangan->jadwals->groupBy(function($s) {
                                        return $s->tanggal->format('Y-m-d');
                                    });
                                @endphp

                                @if($groupedSlots->isEmpty())
                                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl text-center text-slate-400 text-xs">
                                        <i class="fa-solid fa-clock-rotate-left mr-1"></i> Tidak ada slot jadwal sewa aktif yang tersedia untuk lapangan ini.
                                    </div>
                                @else
                                    <!-- Date Tabs -->
                                    <div class="flex flex-wrap gap-1.5 pb-2">
                                        @php $isFirstDate = true; @endphp
                                        @foreach($groupedSlots as $dateStr => $slots)
                                            @php
                                                $carbonDate = \Carbon\Carbon::parse($dateStr);
                                                $dayLabel = '';
                                                if ($carbonDate->isToday()) {
                                                    $dayLabel = 'Hari Ini';
                                                } elseif ($carbonDate->isTomorrow()) {
                                                    $dayLabel = 'Besok';
                                                } else {
                                                    $dayLabel = $carbonDate->isoFormat('dddd');
                                                }
                                                $formattedDate = $carbonDate->isoFormat('D MMM');
                                                $tabBtnId = "tab-{$lapangan->id_lapangan}-{$dateStr}";
                                                $activeBtnClass = $isFirstDate ? 'bg-blue-600 text-white shadow shadow-blue-500/10' : 'bg-slate-50 text-slate-600 border border-slate-200/50 hover:bg-slate-100';
                                            @endphp
                                            <button type="button" 
                                                    onclick="switchBookingTab('{{ $lapangan->id_lapangan }}', '{{ $dateStr }}')"
                                                    id="btn-{{ $tabBtnId }}"
                                                    class="booking-tab-btn-{{ $lapangan->id_lapangan }} px-3 py-1.5 rounded-lg text-[10px] font-bold transition-all {{ $activeBtnClass }}">
                                                {{ $dayLabel }} ({{ $formattedDate }})
                                            </button>
                                            @php $isFirstDate = false; @endphp
                                        @endforeach
                                    </div>

                                    <!-- Time Slots Grid -->
                                    <div>
                                        @php $isFirstDate = true; @endphp
                                        @foreach($groupedSlots as $dateStr => $slots)
                                            @php
                                                $tabBtnId = "tab-{$lapangan->id_lapangan}-{$dateStr}";
                                                $hiddenClass = $isFirstDate ? '' : 'hidden';
                                            @endphp
                                            <div id="content-{{ $tabBtnId }}" class="booking-tab-content-{{ $lapangan->id_lapangan }} {{ $hiddenClass }}">
                                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                                    @foreach($slots as $slot)
                                                        @if($isVerified && $lapangan->status === 'tersedia')
                                                            <a href="{{ route('pelanggan.booking.create', ['id_jadwal' => $slot->id_jadwal]) }}" class="p-2.5 bg-slate-50 border border-slate-200/60 rounded-xl text-center hover:bg-blue-600 hover:border-blue-600 hover:text-white transition-all group flex flex-col justify-center gap-1 cursor-pointer shadow-sm">
                                                                <span class="text-[9px] text-slate-400 group-hover:text-blue-200 font-bold uppercase tracking-wider">{{ $slot->tanggal->format('d M Y') }}</span>
                                                                <span class="text-xs font-mono font-bold text-slate-700 group-hover:text-white leading-none">{{ $slot->waktu }}</span>
                                                                <span class="text-[9px] text-emerald-600 group-hover:text-blue-100 font-bold">Booking Slot</span>
                                                            </a>
                                                        @else
                                                            <div class="p-2.5 bg-slate-100 border border-slate-200/65 rounded-xl text-center flex flex-col justify-center gap-1 cursor-not-allowed opacity-60 line-through">
                                                                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">{{ $slot->tanggal->format('d M Y') }}</span>
                                                                <span class="text-xs font-mono font-bold text-slate-500 leading-none">{{ $slot->waktu }}</span>
                                                                <span class="text-[9px] text-red-500 font-bold">
                                                                    {{ $lapangan->status === 'nonaktif' ? 'Perbaikan' : 'Ditutup' }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            @php $isFirstDate = false; @endphp
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Column: Sidebar (Maps & Info) -->
        <div class="space-y-6">
            <!-- Google Maps Card -->
            <div class="card p-6 bg-white border border-slate-100 space-y-4">
                <h4 class="font-bold text-slate-800 text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <i class="fa-solid fa-map-location-dot text-blue-600 mr-1.5"></i> Peta Lokasi GOR
                </h4>
                <div class="rounded-xl overflow-hidden shadow-inner border border-slate-200 h-64 bg-slate-50 relative">
                    <iframe 
                        width="100%" 
                        height="100%" 
                        frameborder="0" 
                        style="border:0" 
                        src="https://maps.google.com/maps?q={{ urlencode($venue->nama_venue . ', ' . $venue->alamat) }}&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="text-xs text-slate-500 leading-relaxed space-y-1">
                    <p class="font-bold text-slate-700"><i class="fa-solid fa-route mr-1 text-slate-400"></i> Alamat Lengkap:</p>
                    <p class="text-slate-600 bg-slate-50 border border-slate-100 rounded-lg p-2.5">{{ $venue->alamat }}</p>
                </div>
            </div>

            <!-- GOR Info Card -->
            <div class="card p-6 bg-white border border-slate-100 space-y-4">
                <h4 class="font-bold text-slate-800 text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <i class="fa-solid fa-circle-info text-blue-600 mr-1.5"></i> Informasi Tambahan
                </h4>
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400">Kecamatan</span>
                        <span class="font-bold text-slate-700">{{ $venue->kecamatan }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400">Sertifikasi Platform</span>
                        @if($isVerified)
                            <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded text-[10px] border border-emerald-100">Terverifikasi</span>
                        @else
                            <span class="font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded text-[10px] border border-red-100">Belum Terverifikasi</span>
                        @endif
                    </div>
                    @if($venue->no_telepon)
                    <div class="flex justify-between py-2">
                        <span class="text-slate-400">No. Telepon</span>
                        <span class="font-bold text-slate-700">{{ $venue->no_telepon }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function switchBookingTab(lapanganId, dateStr) {
        // Hide all slot contents for this court
        const contents = document.querySelectorAll('.booking-tab-content-' + lapanganId);
        contents.forEach(el => el.classList.add('hidden'));

        // Reset all button styles for this court
        const buttons = document.querySelectorAll('.booking-tab-btn-' + lapanganId);
        buttons.forEach(btn => {
            btn.className = `booking-tab-btn-${lapanganId} px-3 py-1.5 rounded-lg text-[10px] font-bold transition-all bg-slate-50 text-slate-600 border border-slate-200/50 hover:bg-slate-100`;
        });

        // Show the active date content
        const targetContent = document.getElementById('content-tab-' + lapanganId + '-' + dateStr);
        if (targetContent) {
            targetContent.classList.remove('hidden');
        }

        // Set the clicked button to active state
        const targetButton = document.getElementById('btn-tab-' + lapanganId + '-' + dateStr);
        if (targetButton) {
            targetButton.className = `booking-tab-btn-${lapanganId} px-3 py-1.5 rounded-lg text-[10px] font-bold transition-all bg-blue-600 text-white shadow shadow-blue-500/10`;
        }
    }
</script>
@endsection

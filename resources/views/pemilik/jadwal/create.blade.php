@extends('layouts.pemilik')

@section('title', 'Buat Slot Jadwal Baru')
@section('header_title', 'Registrasi Jadwal Lapangan')

@section('content')
<div class="max-w-xl mx-auto space-y-6 animate-fade-in-up">
    <!-- Breadcrumb back link -->
    <div>
        <a href="{{ route('pemilik.jadwal.index') }}" class="text-sm font-semibold text-blue-600 hover:underline inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Jadwal
        </a>
    </div>

    <!-- Form Card -->
    <div class="card p-8">
        <h3 class="text-xl font-extrabold text-slate-800 mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">Buat Slot Jadwal</h3>

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

        @if($lapangans->isEmpty())
            <div class="text-center py-6">
                <p class="text-sm text-slate-500 mb-4">Anda harus mendaftarkan Lapangan olahraga yang berstatus aktif terlebih dahulu sebelum membuat slot jadwal.</p>
                <a href="{{ route('pemilik.lapangan.create') }}" class="btn-primary py-2 px-6 font-bold text-xs">Daftarkan Lapangan Sekarang</a>
            </div>
        @else
            <!-- Mode Selector Tabs -->
            <div class="flex border-b border-slate-100 mb-6 gap-2">
                <button type="button" id="tab-otomatis" onclick="switchMode('otomatis')" class="flex-1 pb-3 text-sm font-bold border-b-2 border-blue-600 text-blue-600 transition-all text-center">
                    <i class="fa-solid fa-magic mr-1"></i> Generate Otomatis
                </button>
                <button type="button" id="tab-manual" onclick="switchMode('manual')" class="flex-1 pb-3 text-sm font-semibold border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition-all text-center">
                    <i class="fa-solid fa-keyboard mr-1"></i> Buat Manual (Kustom)
                </button>
            </div>

            <form action="{{ route('pemilik.jadwal.store') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Hidden input for mode -->
                <input type="hidden" name="mode" id="form-mode" value="otomatis">

                <div>
                    <label for="id_lapangan" class="form-label">Pilih Lapangan Olahraga</label>
                    <select id="id_lapangan" name="id_lapangan" required class="form-input">
                        <option value="">Pilih Lapangan</option>
                        @foreach($lapangans as $lapangan)
                            <option value="{{ $lapangan->id_lapangan }}" {{ old('id_lapangan') == $lapangan->id_lapangan ? 'selected' : '' }}>
                                {{ $lapangan->venue->nama_venue }} — {{ $lapangan->nama_lapangan }} ({{ $lapangan->jenisLapangan->nama_jenis }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Otomatis Mode Form Section -->
                <div id="section-otomatis" class="space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="jam_buka" class="form-label">Jam Buka GOR</label>
                            <input type="time" id="jam_buka" name="jam_buka" value="{{ old('jam_buka', '08:00') }}" class="form-input">
                        </div>
                        <div>
                            <label for="jam_tutup" class="form-label">Jam Tutup GOR</label>
                            <input type="time" id="jam_tutup" name="jam_tutup" value="{{ old('jam_tutup', '22:00') }}" class="form-input">
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-100 text-blue-800 text-[10px] rounded-lg p-3 leading-relaxed">
                        <strong>Informasi Pembuatan Jadwal Otomatis:</strong> 
                        Sistem akan secara otomatis membuat slot jadwal per 1 jam untuk <strong>15 hari ke depan</strong> mulai hari ini. Jika ada slot jadwal yang sudah pernah dibuat sebelumnya pada rentang waktu tersebut, sistem akan melewatinya secara otomatis tanpa menimbulkan error.
                    </div>
                </div>

                <!-- Manual Mode Form Section (Hidden by default) -->
                <div id="section-manual" class="space-y-5 hidden">
                    <div>
                        <label for="tanggal" class="form-label">Pilih Tanggal Jadwal</label>
                        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" min="{{ now()->toDateString() }}" class="form-input">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', '08:00') }}" class="form-input">
                        </div>
                        <div>
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', '09:00') }}" class="form-input">
                        </div>
                    </div>

                    <div class="bg-amber-50 border border-amber-100 text-amber-800 text-[10px] rounded-lg p-3 leading-relaxed">
                        <strong>Informasi Pembuatan Jadwal Manual:</strong> 
                        Anda dapat membuat slot jadwal tunggal secara spesifik pada tanggal dan rentang jam pilihan Anda.
                    </div>
                </div>

                <button type="submit" id="submit-btn" class="w-full btn-primary py-3 text-sm font-bold shadow-lg shadow-blue-500/20">
                    Generate Jadwal Otomatis (15 Hari)
                </button>
            </form>

            <script>
                function switchMode(mode) {
                    const tabOtomatis = document.getElementById('tab-otomatis');
                    const tabManual = document.getElementById('tab-manual');
                    const secOtomatis = document.getElementById('section-otomatis');
                    const secManual = document.getElementById('section-manual');
                    const formMode = document.getElementById('form-mode');
                    const submitBtn = document.getElementById('submit-btn');

                    // Inputs
                    const jamBuka = document.getElementById('jam_buka');
                    const jamTutup = document.getElementById('jam_tutup');
                    const tanggal = document.getElementById('tanggal');
                    const jamMulai = document.getElementById('jam_mulai');
                    const jamSelesai = document.getElementById('jam_selesai');

                    formMode.value = mode;

                    if (mode === 'otomatis') {
                        // Tabs active
                        tabOtomatis.className = "flex-1 pb-3 text-sm font-bold border-b-2 border-blue-600 text-blue-600 transition-all text-center";
                        tabManual.className = "flex-1 pb-3 text-sm font-semibold border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition-all text-center";
                        
                        // Sections visibility
                        secOtomatis.classList.remove('hidden');
                        secManual.classList.add('hidden');

                        // Inputs required
                        jamBuka.required = true;
                        jamTutup.required = true;
                        tanggal.required = false;
                        jamMulai.required = false;
                        jamSelesai.required = false;

                        // Submit btn label
                        submitBtn.innerText = "Generate Jadwal Otomatis (15 Hari)";
                    } else {
                        // Tabs active
                        tabManual.className = "flex-1 pb-3 text-sm font-bold border-b-2 border-blue-600 text-blue-600 transition-all text-center";
                        tabOtomatis.className = "flex-1 pb-3 text-sm font-semibold border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition-all text-center";
                        
                        // Sections visibility
                        secManual.classList.remove('hidden');
                        secOtomatis.classList.add('hidden');

                        // Inputs required
                        jamBuka.required = false;
                        jamTutup.required = false;
                        tanggal.required = true;
                        jamMulai.required = true;
                        jamSelesai.required = true;

                        // Submit btn label
                        submitBtn.innerText = "Simpan Slot Jadwal Kustom";
                    }
                }

                // Initialize default
                document.addEventListener('DOMContentLoaded', function() {
                    const oldMode = "{{ old('mode', 'otomatis') }}";
                    switchMode(oldMode);
                });
            </script>
        @endif
    </div>
</div>
@endsection

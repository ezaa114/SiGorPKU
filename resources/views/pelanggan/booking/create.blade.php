@extends('layouts.pelanggan')

@section('title', 'Konfirmasi Sewa Lapangan')

@section('content')
<div class="max-w-xl mx-auto space-y-6 animate-fade-in-up">
    <!-- Breadcrumb back link -->
    <div>
        <a href="{{ route('pelanggan.venue.show', $jadwal->lapangan->id_venue) }}" class="text-sm font-semibold text-blue-600 hover:underline inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke GOR
        </a>
    </div>

    <!-- Confirmation Card -->
    <div class="card p-8 bg-white border border-slate-100 shadow-xl">
        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight mb-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">Konfirmasi Sewa Lapangan</h3>

        <div class="space-y-4">
            <!-- GOR / Field Info -->
            <div class="flex items-center gap-4 bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-futbol"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800">{{ $jadwal->lapangan->venue->nama_venue }}</h4>
                    <p class="text-xs text-slate-500">{{ $jadwal->lapangan->nama_lapangan }} ({{ $jadwal->lapangan->jenisLapangan->nama_jenis }})</p>
                </div>
            </div>

            <!-- Booking details list -->
            <div class="border-t border-b border-slate-100 py-4 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Tanggal Sewa</span>
                    <span class="font-bold text-slate-800">{{ $jadwal->tanggal->format('d F Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Jam Sewa (Slot)</span>
                    <span class="font-bold text-slate-800 font-mono">{{ $jadwal->waktu }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Durasi Sewa</span>
                    <span class="font-bold text-slate-800">{{ $hours }} Jam</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Tarif Lapangan</span>
                    <span class="font-bold text-slate-800">{{ $jadwal->lapangan->harga_formatted }} / Jam</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Maks. Durasi Tersedia</span>
                    <span class="font-bold text-blue-600">{{ $consecutive_count }} Jam</span>
                </div>
            </div>

            <!-- Warning notice -->
            <div class="bg-amber-50 border border-amber-100 text-amber-800 text-[10px] rounded-lg p-3 leading-relaxed mt-4">
                <strong>Ketentuan Booking:</strong> Jadwal akan diblokir untuk Anda selama proses pembayaran. Harap segera melakukan transfer bank dan mengunggah bukti pembayaran agar pesanan Anda disetujui Pemilik GOR.
            </div>

            <!-- Action form -->
            <form action="{{ route('pelanggan.booking.store') }}" method="POST" class="pt-4 space-y-4">
                @csrf
                <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">
                
                <div class="flex justify-between items-center bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <label for="durasi_jam" class="text-sm font-bold text-slate-800">Pilih Durasi Sewa</label>
                    <select name="durasi_jam" id="durasi_jam" class="rounded-lg border-slate-200 text-sm font-bold text-slate-800 focus:border-blue-500 focus:ring-blue-500 py-1.5 px-3">
                        @for($i = 1; $i <= min(4, $consecutive_count); $i++)
                            <option value="{{ $i }}" {{ $i == $hours ? 'selected' : '' }}>{{ $i }} Jam</option>
                        @endfor
                    </select>
                </div>

                <!-- Invoice Total -->
                <div class="flex justify-between items-center py-2 border-t border-slate-100 pt-4">
                    <span class="text-sm font-semibold text-slate-500">Total Harga Sewa</span>
                    <span id="total_price_display" class="text-2xl font-extrabold text-blue-600">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                </div>

                <button type="submit" class="w-full btn-primary py-3 text-sm font-bold shadow-lg shadow-blue-500/20">
                    Konfirmasi & Buat Pesanan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const durasiSelect = document.getElementById('durasi_jam');
        const priceDisplay = document.getElementById('total_price_display');
        const basePrice = {{ $jadwal->lapangan->harga_per_jam }};

        if (durasiSelect && priceDisplay) {
            durasiSelect.addEventListener('change', function() {
                const hours = parseInt(this.value) || 1;
                const total = basePrice * hours;
                
                // Format price in IDR format
                const formattedPrice = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                priceDisplay.textContent = formattedPrice;
            });
        }
    });
</script>
@endsection

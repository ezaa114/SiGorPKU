@extends('layouts.pelanggan')

@section('title', 'Detail Pemesanan #' . str_pad($pemesanan->id_pemesanan, 5, '0', STR_PAD_LEFT))

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in-up">
    <!-- Breadcrumb back link -->
    <div>
        <a href="{{ route('pelanggan.pemesanan.index') }}" class="text-sm font-semibold text-blue-600 hover:underline inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Pemesanan Saya
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Invoice Details -->
        <div class="card p-6 bg-white border border-slate-100 lg:col-span-2 space-y-6">
            <div class="flex justify-between items-start border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Invoice Pemesanan</h3>
                    <p class="font-mono text-xs text-slate-500 mt-1">ID Booking: #SP-{{ str_pad($pemesanan->id_pemesanan, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
                <span class="badge {{ $pemesanan->status_label['class'] }}">
                    {{ $pemesanan->status_label['label'] }}
                </span>
            </div>

            <!-- Booking details -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-building-circle-check"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-800">{{ $pemesanan->jadwal->lapangan->venue->nama_venue }}</h4>
                        <p class="text-xs text-slate-500">{{ $pemesanan->jadwal->lapangan->venue->alamat }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div class="p-3 border border-slate-100 rounded-lg">
                        <span class="text-slate-400 font-semibold block uppercase mb-1">Lapangan</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $pemesanan->jadwal->lapangan->nama_lapangan }}</span>
                    </div>
                    <div class="p-3 border border-slate-100 rounded-lg">
                        <span class="text-slate-400 font-semibold block uppercase mb-1">Olahraga</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $pemesanan->jadwal->lapangan->jenisLapangan->nama_jenis }}</span>
                    </div>
                    <div class="p-3 border border-slate-100 rounded-lg col-span-2">
                        <span class="text-slate-400 font-semibold block uppercase mb-1">Tanggal & Waktu Sewa</span>
                        <span class="font-bold text-slate-800 text-sm">
                            {{ $pemesanan->jadwal->tanggal->format('d F Y') }} ({{ $pemesanan->waktu_sewa }} - {{ $pemesanan->durasi_jam }} Jam)
                        </span>
                    </div>
                </div>
            </div>

            <!-- Pricing invoice breakdown -->
            <div class="border-t border-slate-100 pt-4 space-y-2 text-xs">
                <div class="flex justify-between">
                    <span class="text-slate-500">Tarif Lapangan / Jam</span>
                    <span class="font-semibold text-slate-800">{{ $pemesanan->jadwal->lapangan->harga_formatted }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Durasi Sewa</span>
                    <span class="font-semibold text-slate-800">{{ $pemesanan->durasi_jam }} Jam</span>
                </div>
                <div class="flex justify-between items-center text-sm font-bold border-t border-slate-100 pt-2">
                    <span class="text-slate-800">Total Pembayaran</span>
                    <span class="text-blue-600 font-extrabold text-base">{{ $pemesanan->total_harga_formatted }}</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Payment Transfer Form / Info -->
        <div class="card p-6 bg-white border border-slate-100 space-y-6">
            <h4 class="text-base font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Status Pembayaran</h4>

            <!-- Case 1: Awaiting Payment Upload -->
            @if($pemesanan->status_pesan === 'menunggu_pembayaran')
                <div class="space-y-4 text-xs">
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-blue-800 space-y-2 leading-relaxed">
                        <p class="font-bold text-sm"><i class="fa-solid fa-building-columns mr-1"></i> Rekening Transfer:</p>
                        <p><strong>Bank Riau Kepri Syariah</strong></p>
                        <p class="font-mono text-sm font-bold">No. Rek: 124-50-60789</p>
                        <p>a.n. <strong>SiGOR PKU Marketplace</strong></p>
                        <p class="text-[10px] text-blue-500 mt-1">Harap transfer nominal sesuai total harga sewa.</p>
                    </div>

                    <form action="{{ route('pelanggan.pemesanan.bayar', $pemesanan->id_pemesanan) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="form-label font-bold text-slate-700">Upload Bukti Transfer</label>
                            <input type="file" name="bukti_transfer" required accept="image/*" class="form-input text-xs">
                            <p class="text-[10px] text-slate-400 mt-1">Format file: JPG, PNG, WEBP (Maksimal 2 MB).</p>
                        </div>
                        <button type="submit" class="w-full btn-primary py-2 px-4 text-xs font-bold shadow shadow-blue-500/20">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>

            <!-- Case 2: Awaiting Owner Confirmation -->
            @elseif($pemesanan->status_pesan === 'menunggu_konfirmasi')
                <div class="text-center py-6 space-y-3">
                    <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mx-auto text-xl">
                        <i class="fa-solid fa-hourglass-half animate-spin"></i>
                    </div>
                    <h5 class="font-bold text-slate-800 text-sm">Menunggu Konfirmasi</h5>
                    <p class="text-slate-500 text-xs leading-relaxed">Bukti transfer Anda telah dikirim dan sedang diperiksa oleh Pemilik GOR. Mohon cek status pesanan Anda secara berkala.</p>
                    
                    @if($pemesanan->pembayaran && $pemesanan->pembayaran->bukti_transfer)
                        <div class="pt-4 border-t border-slate-100">
                            <span class="text-[10px] text-slate-400 font-bold block uppercase mb-2">Bukti Yang Anda Unggah:</span>
                            <a href="{{ $pemesanan->pembayaran->bukti_bayar_url }}" target="_blank" class="text-xs text-blue-600 font-semibold hover:underline">
                                <i class="fa-solid fa-file-image mr-1"></i> Buka Bukti Upload
                            </a>
                        </div>
                    @endif
                </div>

            <!-- Case 3: Confirmed / Paid -->
            @elseif($pemesanan->status_pesan === 'dikonfirmasi')
                <div class="text-center py-6 space-y-3">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-xl">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <h5 class="font-bold text-emerald-700 text-sm">Booking Dikonfirmasi</h5>
                    <p class="text-slate-500 text-xs leading-relaxed">Pembayaran lunas! Silakan tunjukkan detail invoice ini kepada petugas GOR saat kedatangan Anda.</p>
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 text-left text-[11px] leading-relaxed text-slate-600">
                        <i class="fa-solid fa-circle-info text-blue-500"></i> Datanglah 15 menit sebelum slot jadwal sewa dimulai.
                    </div>
                </div>

            <!-- Case 4: Cancelled / Rejected -->
            @elseif($pemesanan->status_pesan === 'dibatalkan')
                <div class="text-center py-6 space-y-2">
                    <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto text-xl">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <h5 class="font-bold text-red-700 text-sm">Pesanan Dibatalkan</h5>
                    <p class="text-slate-500 text-xs leading-relaxed">
                        @if($pemesanan->pembayaran && $pemesanan->pembayaran->status_bayar === 'ditolak')
                            Bukti pembayaran Anda ditolak oleh Pemilik GOR karena tidak sesuai. Slot waktu sewa telah dibuka kembali.
                        @else
                            Pesanan sewa lapangan ini dibatalkan.
                        @endif
                    </p>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection

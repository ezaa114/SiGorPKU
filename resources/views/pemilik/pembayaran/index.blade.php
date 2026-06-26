@extends('layouts.pemilik')

@section('title', 'Pemesanan & Konfirmasi Pembayaran')
@section('header_title', 'Konfirmasi Pembayaran')

@section('content')
<div class="card p-6 animate-fade-in-up">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pemesanan Lapangan Olahraga</h3>
        <p class="text-sm text-slate-500">Pantau pemesanan masuk dan verifikasi bukti transfer pelanggan untuk mengunci jadwal sewa.</p>
    </div>

    @if($pemesanans->isEmpty())
        <div class="text-center py-12 text-slate-400 text-sm">
            <i class="fa-solid fa-receipt text-5xl text-slate-300 mb-4 block"></i>
            Belum ada pemesanan masuk untuk lapangan olahraga Anda.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Lapangan / GOR</th>
                        <th>Jadwal Sewa</th>
                        <th>Total Harga</th>
                        <th>Status Booking</th>
                        <th>Bukti Transfer</th>
                        <th class="text-center w-52">Konfirmasi Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemesanans as $pesanan)
                        <tr>
                            <td class="font-mono text-xs font-bold text-slate-600">#SP-{{ str_pad($pesanan->id_pemesanan, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $pesanan->pelanggan->nama }}</div>
                                <div class="text-[10px] text-slate-400">{{ $pesanan->pelanggan->no_telepon }}</div>
                            </td>
                            <td>
                                <div class="font-bold text-slate-700">{{ $pesanan->jadwal->lapangan->venue->nama_venue }}</div>
                                <div class="text-xs text-slate-500">{{ $pesanan->jadwal->lapangan->nama_lapangan }}</div>
                            </td>
                            <td>
                                <div class="text-xs text-slate-700 font-semibold">{{ $pesanan->jadwal->tanggal->format('d/m/Y') }}</div>
                                <div class="text-[10px] text-slate-500">{{ $pesanan->waktu_sewa }}</div>
                            </td>
                            <td class="font-bold text-slate-800">{{ $pesanan->total_harga_formatted }}</td>
                            <td>
                                <span class="badge {{ $pesanan->status_label['class'] }}">
                                    {{ $pesanan->status_label['label'] }}
                                </span>
                            </td>
                            <td>
                                @if($pesanan->pembayaran && $pesanan->pembayaran->bukti_transfer)
                                    <a href="{{ $pesanan->pembayaran->bukti_bayar_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-semibold text-xs inline-flex items-center gap-1">
                                        <i class="fa-solid fa-file-image"></i> Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 italic">Belum diupload</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(in_array($pesanan->status_pesan, ['menunggu_pembayaran', 'menunggu_konfirmasi']))
                                    <div class="flex gap-2 justify-center">
                                        <!-- Reject Form -->
                                        <form action="{{ route('pemilik.pembayaran.konfirmasi', $pesanan->id_pemesanan) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="btn-danger py-1 px-3 text-xs font-bold inline-flex items-center gap-1" onclick="return confirm('Apakah Anda yakin ingin menolak pembayaran ini?')">
                                                Tolak
                                            </button>
                                        </form>

                                        <!-- Approve Form -->
                                        <form action="{{ route('pemilik.pembayaran.konfirmasi', $pesanan->id_pemesanan) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="dikonfirmasi">
                                            <button type="submit" class="btn-success py-1 px-3 text-xs font-bold inline-flex items-center gap-1" onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi pembayaran ini?')">
                                                Setujui
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="badge {{ $pesanan->status_label['class'] }}">
                                        {{ $pesanan->status_label['label'] }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

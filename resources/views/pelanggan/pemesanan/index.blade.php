@extends('layouts.pelanggan')

@section('title', 'Pemesanan Saya')

@section('content')
<div class="card p-6 animate-fade-in-up">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pemesanan Lapangan Saya</h3>
        <p class="text-sm text-slate-500">Pantau seluruh riwayat booking dan status pembayaran penyewaan lapangan Anda.</p>
    </div>

    @if($pemesanans->isEmpty())
        <div class="text-center py-12 text-slate-400 text-sm">
            <i class="fa-solid fa-receipt text-5xl text-slate-300 mb-4 block"></i>
            Anda belum pernah memesan lapangan olahraga.
            <a href="{{ route('pelanggan.dashboard') }}" class="btn-primary py-2 px-6 font-bold text-xs mt-4 inline-block">Cari Lapangan Sekarang</a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Venue / GOR</th>
                        <th>Lapangan</th>
                        <th>Jadwal Sewa</th>
                        <th>Total Harga</th>
                        <th>Status Booking</th>
                        <th>Status Pembayaran</th>
                        <th class="text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemesanans as $pesanan)
                        <tr>
                            <td class="font-mono text-xs font-bold text-slate-600">#SP-{{ str_pad($pesanan->id_pemesanan, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="font-bold text-slate-800">{{ $pesanan->jadwal->lapangan->venue->nama_venue }}</td>
                            <td class="font-medium text-slate-700">{{ $pesanan->jadwal->lapangan->nama_lapangan }}</td>
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
                                @if($pesanan->pembayaran)
                                    <span class="badge {{ $pesanan->pembayaran->status_label['class'] }}">
                                        {{ $pesanan->pembayaran->status_label['label'] }}
                                    </span>
                                @else
                                    <span class="badge badge-danger">Belum Bayar</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('pelanggan.pemesanan.show', $pesanan->id_pemesanan) }}" class="btn-secondary py-1.5 px-3 text-xs font-bold inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-receipt text-[10px]"></i> Detail Invoice
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

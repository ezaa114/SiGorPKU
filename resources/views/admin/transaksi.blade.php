@extends('layouts.admin')

@section('title', 'Monitor Seluruh Transaksi')
@section('header_title', 'Semua Transaksi')

@section('content')
<div class="card p-6 animate-fade-in-up">
    <div class="mb-6">
        <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Monitor Transaksi Lapangan</h3>
        <p class="text-sm text-slate-500">Melihat seluruh data pemesanan dan konfirmasi pembayaran di Kota Pekanbaru.</p>
    </div>

    @if($pemesanans->isEmpty())
        <div class="text-center py-12 text-slate-400 text-sm">
            <i class="fa-solid fa-receipt text-5xl text-slate-300 mb-4 block"></i>
            Belum ada transaksi pemesanan lapangan olahraga di platform.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Booking</th>
                        <th>Pelanggan</th>
                        <th>GOR / Lapangan</th>
                        <th>Jadwal Sewa</th>
                        <th>Total Harga</th>
                        <th>Status Booking</th>
                        <th>Status Pembayaran</th>
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
                                <div class="text-xs text-slate-700 font-semibold">{{ $pesanan->jadwal->tanggal->format('d M Y') }}</div>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

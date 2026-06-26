<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $table = 'pemesanans';
    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'id_pelanggan',
        'id_jadwal',
        'durasi_jam',
        'tgl_pesan',
        'total_harga',
        'status_pesan',
    ];

    protected function casts(): array
    {
        return [
            'tgl_pesan'   => 'date',
            'total_harga' => 'decimal:2',
        ];
    }

    // Relations
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan', 'id_pemesanan');
    }

    // Helpers
    public function getTotalHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getWaktuSewaAttribute(): string
    {
        if (!$this->jadwal) {
            return '';
        }
        $start = \Carbon\Carbon::parse($this->jadwal->jam_mulai);
        $duration = $this->durasi_jam ?? 1;
        $end = $start->copy()->addHours($duration);
        return $start->format('H:i') . ' - ' . $end->format('H:i');
    }

    public function getStatusLabelAttribute(): array
    {
        return match ($this->status_pesan) {
            'menunggu_pembayaran'  => ['label' => 'Menunggu Pembayaran', 'class' => 'badge-warning'],
            'menunggu_konfirmasi'  => ['label' => 'Pending', 'class' => 'badge-info'],
            'dikonfirmasi'         => ['label' => 'Dikonfirmasi', 'class' => 'badge-success'],
            'dibatalkan'           => ['label' => 'Dibatalkan', 'class' => 'badge-danger'],
            default                => ['label' => $this->status_pesan, 'class' => 'badge-gray'],
        };
    }
}

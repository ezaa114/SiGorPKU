<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_pemesanan',
        'tgl_bayar',
        'jumlah_bayar',
        'bukti_transfer',
        'metode_bayar',
        'status_bayar',
    ];

    protected function casts(): array
    {
        return [
            'tgl_bayar'    => 'date',
            'jumlah_bayar' => 'decimal:2',
        ];
    }

    // Relations
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }

    // Helpers
    public function getJumlahFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->jumlah_bayar, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): array
    {
        return match ($this->status_bayar) {
            'menunggu'    => ['label' => 'Pending', 'class' => 'badge-warning'],
            'dikonfirmasi'=> ['label' => 'Dikonfirmasi', 'class' => 'badge-success'],
            'ditolak'     => ['label' => 'Ditolak', 'class' => 'badge-danger'],
            default       => ['label' => $this->status_bayar, 'class' => 'badge-gray'],
        };
    }

    public function getBuktiBayarUrlAttribute(): ?string
    {
        return $this->bukti_transfer
            ? asset('storage/' . $this->bukti_transfer)
            : null;
    }
}

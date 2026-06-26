<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    protected $table = 'lapangans';
    protected $primaryKey = 'id_lapangan';

    protected $fillable = [
        'id_venue',
        'id_jenis',
        'nama_lapangan',
        'harga_per_jam',
        'status',
        'gambar_lapangan',
    ];

    protected function casts(): array
    {
        return [
            'harga_per_jam' => 'decimal:2',
        ];
    }

    // Relations
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'id_venue', 'id_venue');
    }

    public function jenisLapangan()
    {
        return $this->belongsTo(JenisLapangan::class, 'id_jenis', 'id_jenis');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_lapangan', 'id_lapangan');
    }

    // Scope: only active fields
    public function scopeAktif($query)
    {
        return $query->where('status', 'tersedia');
    }

    // Helper
    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_per_jam, 0, ',', '.');
    }
}

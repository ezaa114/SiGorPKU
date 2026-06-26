<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwals';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_lapangan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'ketersediaan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    // Relations
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'id_lapangan', 'id_lapangan');
    }

    public function pemesanan()
    {
        return $this->hasOne(Pemesanan::class, 'id_jadwal', 'id_jadwal');
    }

    // Scopes
    public function scopeTersedia($query)
    {
        return $query->where('ketersediaan', 'tersedia');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tanggal', '>=', now()->toDateString());
    }

    // Helpers
    public function getWaktuAttribute(): string
    {
        return substr($this->jam_mulai, 0, 5) . ' - ' . substr($this->jam_selesai, 0, 5);
    }

    public function isTersedia(): bool
    {
        return $this->ketersediaan === 'tersedia';
    }
}

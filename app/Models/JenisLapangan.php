<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisLapangan extends Model
{
    protected $table = 'jenis_lapangans';
    protected $primaryKey = 'id_jenis';

    protected $fillable = [
        'nama_jenis',
        'deskripsi',
    ];

    // Relations
    public function lapangans()
    {
        return $this->hasMany(Lapangan::class, 'id_jenis', 'id_jenis');
    }
}

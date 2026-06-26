<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $table = 'venues';
    protected $primaryKey = 'id_venue';

    protected $fillable = [
        'id_pemilik',
        'nama_venue',
        'alamat',
        'kecamatan',
        'no_telepon',
        'gambar_venue',
        'status',
    ];

    // Relations
    public function pemilikGor()
    {
        return $this->belongsTo(PemilikGor::class, 'id_pemilik', 'id_pemilik');
    }

    public function lapangans()
    {
        return $this->hasMany(Lapangan::class, 'id_venue', 'id_venue');
    }
}

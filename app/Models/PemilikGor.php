<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PemilikGor extends Authenticatable
{
    use Notifiable;

    protected $table = 'pemilik_gors';
    protected $primaryKey = 'id_pemilik';

    protected $fillable = [
        'nama',
        'no_telepon',
        'email',
        'password',
        'nama_usaha',
        'status_verifikasi',
    ];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Helpers
    public function isVerified(): bool
    {
        return $this->status_verifikasi === 'terverifikasi';
    }

    public function isPending(): bool
    {
        return $this->status_verifikasi === 'pending';
    }

    // Relations
    public function venues()
    {
        return $this->hasMany(Venue::class, 'id_pemilik', 'id_pemilik');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueClosure extends Model
{
    protected $table = 'venue_closures';
    protected $primaryKey = 'id_closure';

    protected $fillable = [
        'id_venue',
        'tanggal',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'id_venue', 'id_venue');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;

class RokySeeder extends Seeder
{
    public function run(): void
    {
        Pelanggan::create([
            'nama'       => 'Roky',
            'no_telepon' => '081299887766',
            'email'      => 'roky@demo.com',
            'password'   => Hash::make('roky123'),
        ]);
    }
}

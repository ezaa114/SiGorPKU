<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\JenisLapangan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin account (stored in users table with role column workaround)
        // We use a simple admin table via config or session
        // For this system, admin is identified by a fixed config
        DB::table('users')->insert([
            [
                'name'       => 'Administrator SiGOR PKU',
                'email'      => 'admin@sigorpku.com',
                'password'   => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'achmad24',
                'email'      => 'achmad24@sigorpku.com',
                'password'   => Hash::make('achmad123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 2. Jenis Lapangan master data
        $jenis = [
            ['nama_jenis' => 'Badminton',   'deskripsi' => 'Lapangan bulu tangkis standar BWF'],
            ['nama_jenis' => 'Futsal',       'deskripsi' => 'Lapangan futsal standar FIFA'],
            ['nama_jenis' => 'Mini Soccer',  'deskripsi' => 'Lapangan sepak bola mini'],
            ['nama_jenis' => 'Voli',         'deskripsi' => 'Lapangan bola voli standar FIVB'],
            ['nama_jenis' => 'Basket',       'deskripsi' => 'Lapangan bola basket standar FIBA'],
        ];

        foreach ($jenis as $item) {
            JenisLapangan::create($item);
        }

        // 3. Demo Pelanggan
        DB::table('pelanggan')->insert([
            'nama'       => 'Budi Santoso',
            'no_telepon' => '08123456789',
            'email'      => 'pelanggan@demo.com',
            'password'   => Hash::make('pelanggan123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Demo Pemilik GOR (terverifikasi)
        DB::table('pemilik_gors')->insert([
            'nama'               => 'Ahmad Fauzi',
            'no_telepon'         => '08987654321',
            'email'              => 'pemilik@demo.com',
            'password'           => Hash::make('pemilik123'),
            'nama_usaha'         => 'GOR Pekanbaru Jaya',
            'status_verifikasi'  => 'terverifikasi',
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        // 5. Seed realistic GOR venues in Pekanbaru
        $this->call([
            VenueSeeder::class,
            ZakiSeeder::class,
            RokySeeder::class,
        ]);
    }
}

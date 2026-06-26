<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\PemilikGor;
use App\Models\Venue;
use App\Models\Lapangan;
use App\Models\Jadwal;
use App\Models\JenisLapangan;
use Carbon\Carbon;

class ZakiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Pemilik GOR Zaki
        $pemilik = PemilikGor::create([
            'nama'               => 'Zaki',
            'no_telepon'         => '08122334455',
            'email'              => 'zaki@demo.com',
            'password'           => Hash::make('zaki123'),
            'nama_usaha'         => 'GOR Badminton Zaki',
            'status_verifikasi'  => 'terverifikasi',
        ]);

        // 2. Create Venue
        $venue = Venue::create([
            'id_pemilik' => $pemilik->id_pemilik,
            'nama_venue' => 'GOR Badminton Zaki',
            'alamat'     => 'Jl. HR. Subrantas No. 45, Panam, Pekanbaru',
            'kecamatan'  => 'Binawidya',
            'no_telepon' => '08122334455',
            'status'     => 'aktif',
        ]);

        // 3. Find Badminton category
        $badmintonCategory = JenisLapangan::where('nama_jenis', 'Badminton')->first();
        $idJenis = $badmintonCategory ? $badmintonCategory->id_jenis : 1;

        // 4. Create 3 Badminton courts
        $lapangans = [];
        for ($i = 1; $i <= 3; $i++) {
            $lapangans[] = Lapangan::create([
                'id_venue'      => $venue->id_venue,
                'id_jenis'      => $idJenis,
                'nama_lapangan' => 'Lapangan Badminton ' . $i,
                'harga_per_jam' => 35000,
                'status'        => 'tersedia',
            ]);
        }

        // 5. Create schedule slots for the next 7 days
        $startDay = Carbon::today();
        $hours = [
            ['08:00:00', '09:00:00'],
            ['09:00:00', '10:00:00'],
            ['10:00:00', '11:00:00'],
            ['13:00:00', '14:00:00'],
            ['14:00:00', '15:00:00'],
            ['15:00:00', '16:00:00'],
            ['16:00:00', '17:00:00'],
            ['18:00:00', '19:00:00'],
            ['19:00:00', '20:00:00'],
            ['20:00:00', '21:00:00'],
            ['21:00:00', '22:00:00'],
        ];

        for ($day = 0; $day < 7; $day++) {
            $targetDate = $startDay->copy()->addDays($day)->toDateString();
            foreach ($lapangans as $lapangan) {
                foreach ($hours as $hour) {
                    Jadwal::create([
                        'id_lapangan'  => $lapangan->id_lapangan,
                        'tanggal'      => $targetDate,
                        'jam_mulai'    => $hour[0],
                        'jam_selesai'  => $hour[1],
                        'ketersediaan' => 'tersedia',
                    ]);
                }
            }
        }
    }
}

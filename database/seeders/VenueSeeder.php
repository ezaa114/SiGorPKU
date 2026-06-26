<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\PemilikGor;
use App\Models\Venue;
use App\Models\Lapangan;
use App\Models\Jadwal;
use App\Models\JenisLapangan;
use Carbon\Carbon;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        // Find categories
        $badminton = JenisLapangan::where('nama_jenis', 'Badminton')->first();
        $futsal = JenisLapangan::where('nama_jenis', 'Futsal')->first();
        $minisoccer = JenisLapangan::where('nama_jenis', 'Mini Soccer')->first();
        $voli = JenisLapangan::where('nama_jenis', 'Voli')->first();
        $basket = JenisLapangan::where('nama_jenis', 'Basket')->first();

        $idBadminton = $badminton ? $badminton->id_jenis : 1;
        $idFutsal = $futsal ? $futsal->id_jenis : 2;
        $idMiniSoccer = $minisoccer ? $minisoccer->id_jenis : 3;
        $idVoli = $voli ? $voli->id_jenis : 4;
        $idBasket = $basket ? $basket->id_jenis : 5;

        // Data Venue GOR Pekanbaru
        $venuesData = [
            [
                'owner' => [
                    'nama' => 'Hendra Wijaya',
                    'email' => 'angkasa@demo.com',
                    'password' => Hash::make('angkasa123'),
                    'no_telepon' => '08123456701',
                    'nama_usaha' => 'GOR Badminton Angkasa',
                    'status_verifikasi' => 'terverifikasi',
                ],
                'venue' => [
                    'nama_venue' => 'GOR Badminton Angkasa',
                    'alamat' => 'Jl. Angkasa No. 9, Delima, Kec. Binawidya, Kota Pekanbaru, Riau',
                    'kecamatan' => 'Binawidya',
                    'no_telepon' => '08123456701',
                    'status' => 'aktif',
                ],
                'lapangans' => [
                    ['nama_lapangan' => 'Lapangan Badminton 1 (Synthetic)', 'harga' => 40000, 'jenis' => $idBadminton],
                    ['nama_lapangan' => 'Lapangan Badminton 2 (Synthetic)', 'harga' => 40000, 'jenis' => $idBadminton],
                    ['nama_lapangan' => 'Lapangan Badminton 3 (Synthetic)', 'harga' => 40000, 'jenis' => $idBadminton],
                ]
            ],
            [
                'owner' => [
                    'nama' => 'Rahmat Hidayat',
                    'email' => 'panam@demo.com',
                    'password' => Hash::make('panam123'),
                    'no_telepon' => '08123456702',
                    'nama_usaha' => 'Panam Sport Center',
                    'status_verifikasi' => 'terverifikasi',
                ],
                'venue' => [
                    'nama_venue' => 'Panam Sport Center',
                    'alamat' => 'Jl. HR. Subrantas No. 100, Simpang Baru, Kec. Binawidya, Kota Pekanbaru, Riau',
                    'kecamatan' => 'Binawidya',
                    'no_telepon' => '08123456702',
                    'status' => 'aktif',
                ],
                'lapangans' => [
                    ['nama_lapangan' => 'Lapangan Futsal A (Vinyl)', 'harga' => 120000, 'jenis' => $idFutsal],
                    ['nama_lapangan' => 'Lapangan Futsal B (Vinyl)', 'harga' => 120000, 'jenis' => $idFutsal],
                ]
            ],
            [
                'owner' => [
                    'nama' => 'Susanto',
                    'email' => 'sudirman@demo.com',
                    'password' => Hash::make('sudirman123'),
                    'no_telepon' => '08123456703',
                    'nama_usaha' => 'GOR Sudirman Pekanbaru',
                    'status_verifikasi' => 'terverifikasi',
                ],
                'venue' => [
                    'nama_venue' => 'GOR Sudirman Pekanbaru',
                    'alamat' => 'Jl. Jend. Sudirman No. 345, Wonorejo, Kec. Marpoyan Damai, Kota Pekanbaru, Riau',
                    'kecamatan' => 'Marpoyan Damai',
                    'no_telepon' => '08123456703',
                    'status' => 'aktif',
                ],
                'lapangans' => [
                    ['nama_lapangan' => 'Lapangan Bulutangkis Utama', 'harga' => 45000, 'jenis' => $idBadminton],
                    ['nama_lapangan' => 'Lapangan Bulutangkis VIP', 'harga' => 60000, 'jenis' => $idBadminton],
                ]
            ],
            [
                'owner' => [
                    'nama' => 'Bambang Prasetyo',
                    'email' => 'minisoccer@demo.com',
                    'password' => Hash::make('minisoccer123'),
                    'no_telepon' => '08123456704',
                    'nama_usaha' => 'Arifin Ahmad Sport Arena',
                    'status_verifikasi' => 'terverifikasi',
                ],
                'venue' => [
                    'nama_venue' => 'Arifin Ahmad Sport Arena',
                    'alamat' => 'Jl. Arifin Ahmad No. 12, Sidomulyo Timur, Kec. Marpoyan Damai, Kota Pekanbaru, Riau',
                    'kecamatan' => 'Marpoyan Damai',
                    'no_telepon' => '08123456704',
                    'status' => 'aktif',
                ],
                'lapangans' => [
                    ['nama_lapangan' => 'Lapangan Mini Soccer (FIFA Grass)', 'harga' => 350000, 'jenis' => $idMiniSoccer],
                ]
            ],
            [
                'owner' => [
                    'nama' => 'Doni Siregar',
                    'email' => 'dwikora@demo.com',
                    'password' => Hash::make('dwikora123'),
                    'no_telepon' => '08123456705',
                    'nama_usaha' => 'GOR Dwikora Pekanbaru',
                    'status_verifikasi' => 'terverifikasi',
                ],
                'venue' => [
                    'nama_venue' => 'GOR Dwikora Pekanbaru',
                    'alamat' => 'Jl. Dwikora No. 23, Sekip, Kec. Limapuluh, Kota Pekanbaru, Riau',
                    'kecamatan' => 'Limapuluh',
                    'no_telepon' => '08123456705',
                    'status' => 'aktif',
                ],
                'lapangans' => [
                    ['nama_lapangan' => 'Lapangan Voli Indor Dwikora', 'harga' => 80000, 'jenis' => $idVoli],
                ]
            ],
            [
                'owner' => [
                    'nama' => 'Indra Putra',
                    'email' => 'rumbai@demo.com',
                    'password' => Hash::make('rumbai123'),
                    'no_telepon' => '08123456706',
                    'nama_usaha' => 'Rumbai Basketball Court',
                    'status_verifikasi' => 'terverifikasi',
                ],
                'venue' => [
                    'nama_venue' => 'Rumbai Basketball Court',
                    'alamat' => 'Jl. Yos Sudarso No. 50, Sri Meranti, Kec. Rumbai, Kota Pekanbaru, Riau',
                    'kecamatan' => 'Rumbai',
                    'no_telepon' => '08123456706',
                    'status' => 'aktif',
                ],
                'lapangans' => [
                    ['nama_lapangan' => 'Lapangan Basket Utama (Wooden Court)', 'harga' => 100000, 'jenis' => $idBasket],
                ]
            ]
        ];

        // Seed
        $startDay = Carbon::today();
        $hours = [
            ['08:00:00', '09:00:00'],
            ['09:00:00', '10:00:00'],
            ['10:00:00', '11:00:00'],
            ['14:00:00', '15:00:00'],
            ['15:00:00', '16:00:00'],
            ['16:00:00', '17:00:00'],
            ['19:00:00', '20:00:00'],
            ['20:00:00', '21:00:00'],
            ['21:00:00', '22:00:00'],
        ];

        foreach ($venuesData as $data) {
            $pemilik = PemilikGor::create($data['owner']);
            
            $venueData = $data['venue'];
            $venueData['id_pemilik'] = $pemilik->id_pemilik;
            $venue = Venue::create($venueData);

            foreach ($data['lapangans'] as $lapanganData) {
                $lapangan = Lapangan::create([
                    'id_venue' => $venue->id_venue,
                    'id_jenis' => $lapanganData['jenis'],
                    'nama_lapangan' => $lapanganData['nama_lapangan'],
                    'harga_per_jam' => $lapanganData['harga'],
                    'status' => 'tersedia',
                ]);

                // Create schedules for next 3 days to keep database lightweight but fully functional
                for ($day = 0; $day < 3; $day++) {
                    $targetDate = $startDay->copy()->addDays($day)->toDateString();
                    foreach ($hours as $hour) {
                        Jadwal::create([
                            'id_lapangan' => $lapangan->id_lapangan,
                            'tanggal' => $targetDate,
                            'jam_mulai' => $hour[0],
                            'jam_selesai' => $hour[1],
                            'ketersediaan' => 'tersedia',
                        ]);
                    }
                }
            }
        }
    }
}

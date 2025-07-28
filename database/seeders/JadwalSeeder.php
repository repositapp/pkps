<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\Jadwal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barbers = Barber::all();
        $hariDalamMinggu = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];

        foreach ($barbers as $barber) {
            foreach ($hariDalamMinggu as $hari) {
                // Hari Minggu sebagai hari libur
                $hariKerja = $hari !== 'minggu';

                Jadwal::create([
                    'barber_id' => $barber->id,
                    'hari_dalam_minggu' => $hari,
                    'waktu_buka' => '09:00:00',
                    'waktu_tutup' => '20:00:00',
                    'maksimum_pelanggan_per_jam' => 5,
                    'hari_kerja' => $hariKerja,
                ]);
            }
        }
    }
}

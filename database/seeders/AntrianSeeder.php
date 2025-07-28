<?php

namespace Database\Seeders;

use App\Models\Antrian;
use App\Models\Barber;
use App\Models\Pemesanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AntrianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemesanans = Pemesanan::all();
        $barbers = Barber::all();

        foreach ($pemesanans as $pemesanan) {
            Antrian::factory()->create([
                'pemesanan_id' => $pemesanan->id,
                'barber_id' => $pemesanan->barber_id,
                'tanggal_antrian' => $pemesanan->tanggal_pemesanan,
                'waktu_antrian' => $pemesanan->waktu_pemesanan,
            ]);
        }

        // Antrian tambahan untuk hari ini
        Antrian::factory(5)->create([
            'pemesanan_id' => Pemesanan::inRandomOrder()->first()->id,
            'barber_id' => $barbers->random()->id,
            'tanggal_antrian' => now()->format('Y-m-d'),
        ]);
    }
}

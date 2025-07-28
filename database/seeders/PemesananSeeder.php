<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\Layanan;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelanggans = User::where('role', 'pelanggan')->get();
        $barbers = Barber::all();
        $layanans = Layanan::all();

        // Pemesanan untuk pelanggan yang sudah ada
        foreach ($pelanggans as $pelanggan) {
            // 2-3 pemesanan per pelanggan
            $jumlahPemesanan = rand(2, 3);

            for ($i = 0; $i < $jumlahPemesanan; $i++) {
                $barber = $barbers->random();
                $layanan = $layanans->where('barber_id', $barber->id)->random();

                Pemesanan::factory()->create([
                    'user_id' => $pelanggan->id,
                    'barber_id' => $barber->id,
                    'layanan_id' => $layanan->id,
                ]);
            }
        }

        // Pemesanan tambahan
        Pemesanan::factory(10)->create([
            'user_id' => $pelanggans->random()->id,
            'barber_id' => $barbers->random()->id,
            'layanan_id' => $layanans->random()->id,
        ]);
    }
}

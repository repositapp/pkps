<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tagihan>
 */
class TagihanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $meter_awal = $this->faker->numberBetween(1000, 5000);
        $meter_akhir = $meter_awal + $this->faker->numberBetween(10, 200);
        $volume_air = $meter_akhir - $meter_awal;
        $biaya_administrasi = 2500; // Contoh biaya tetap
        $harga_per_meter = 5000; // Contoh harga per meter kubik
        $biaya_air = $volume_air * $harga_per_meter;
        $total_tagihan = $biaya_administrasi + $biaya_air;

        return [
            'pelanggan_id' => Pelanggan::factory(), // Membuat pelanggan baru jika belum ada
            'periode' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-01'), // Awal bulan
            'meter_awal' => $meter_awal,
            'meter_akhir' => $meter_akhir,
            'volume_air' => $volume_air,
            'biaya_administrasi' => $biaya_administrasi,
            'biaya_air' => $biaya_air,
            'total_tagihan' => $total_tagihan,
            'status_pembayaran' => $this->faker->boolean(30), // 30% sudah bayar
            'pembaca_meter' => $this->faker->name(),
        ];
    }
}

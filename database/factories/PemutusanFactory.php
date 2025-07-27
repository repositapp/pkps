<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pemutusan>
 */
class PemutusanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['pending', 'proses', 'disetujui', 'ditolak']);

        // Untuk jumlah tunggakan, kita bisa ambil dari tagihan yang belum dibayar
        // Tapi untuk factory, kita buat nilai acak saja
        $jumlah_tunggakan = $status !== 'disetujui' ? $this->faker->randomFloat(2, 0, 5000000) : 0;

        return [
            'pelanggan_id' => Pelanggan::factory(), // Membuat pelanggan baru jika belum ada
            'deskripsi' => $this->faker->sentence(),
            'lokasi' => $this->faker->latitude() . ',' . $this->faker->longitude(), // Format latitude,longitude
            'jumlah_tunggakan' => $jumlah_tunggakan,
            'status' => $status,
            'alasan_ditolak' => $status === 'ditolak' ? $this->faker->sentence() : null,
        ];
    }
}

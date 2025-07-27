<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengaduan>
 */
class PengaduanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pelanggan_id' => Pelanggan::factory(), // Membuat pelanggan baru jika belum ada
            'deskripsi' => $this->faker->sentence(),
            'lokasi' => $this->faker->latitude() . ',' . $this->faker->longitude(), // Format latitude,longitude
            'status' => $this->faker->randomElement(['pending', 'proses', 'selesai']),
            'alasan_penyelesaian' => $this->faker->optional()->sentence(),
        ];
    }
}

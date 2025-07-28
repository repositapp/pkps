<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jadwal>
 */
class JadwalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hari_dalam_minggu' => $this->faker->randomElement([
                'senin',
                'selasa',
                'rabu',
                'kamis',
                'jumat',
                'sabtu',
                'minggu'
            ]),
            'waktu_buka' => '08:00:00',
            'waktu_tutup' => '20:00:00',
            'maksimum_pelanggan_per_jam' => $this->faker->numberBetween(3, 8),
            'hari_kerja' => true,
        ];
    }

    /**
     * Hari libur
     */
    public function hariLibur(): static
    {
        return $this->state(fn(array $attributes) => [
            'hari_kerja' => false,
        ]);
    }
}

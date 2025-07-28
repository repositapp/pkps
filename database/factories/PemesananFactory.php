<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pemesanan>
 */
class PemesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggal = $this->faker->dateTimeBetween('now', '+1 month');

        return [
            'tanggal_pemesanan' => $tanggal->format('Y-m-d'),
            'waktu_pemesanan' => $this->faker->time('H:i:s', '18:00:00'),
            'status' => $this->faker->randomElement([
                'menunggu',
                'dikonfirmasi',
                'dibatalkan',
                'dalam_pengerjaan',
                'selesai'
            ]),
            'catatan' => $this->faker->sentence(),
        ];
    }

    /**
     * Pemesanan menunggu
     */
    public function menunggu(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'menunggu',
        ]);
    }

    /**
     * Pemesanan dikonfirmasi
     */
    public function dikonfirmasi(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'dikonfirmasi',
        ]);
    }

    /**
     * Pemesanan dibatalkan
     */
    public function dibatalkan(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'dibatalkan',
        ]);
    }

    /**
     * Pemesanan dalam pengerjaan
     */
    public function dalamPengerjaan(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'dalam_pengerjaan',
        ]);
    }

    /**
     * Pemesanan selesai
     */
    public function selesai(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'selesai',
        ]);
    }
}

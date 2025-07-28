<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Antrian>
 */
class AntrianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggal = $this->faker->dateTimeBetween('now', '+1 week');

        return [
            'tanggal_antrian' => $tanggal->format('Y-m-d'),
            'waktu_antrian' => $this->faker->time('H:i:s', '18:00:00'),
            'nomor_antrian' => $this->faker->numberBetween(1, 50),
            'status' => $this->faker->randomElement([
                'menunggu',
                'dalam_pengerjaan',
                'selesai',
                'dibatalkan'
            ]),
        ];
    }

    /**
     * Antrian menunggu
     */
    public function menunggu(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'menunggu',
        ]);
    }

    /**
     * Antrian dalam pengerjaan
     */
    public function dalamPengerjaan(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'dalam_pengerjaan',
        ]);
    }

    /**
     * Antrian selesai
     */
    public function selesai(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'selesai',
        ]);
    }

    /**
     * Antrian dibatalkan
     */
    public function dibatalkan(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'dibatalkan',
        ]);
    }
}

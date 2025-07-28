<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Layanan>
 */
class LayananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->randomElement([
                'Cukur Rambut',
                'Pangkas Jenggot',
                'Cuci Rambut',
                'Pijat Kepala',
                'Pangkas + Cuci',
                'Styling Rambut'
            ]),
            'deskripsi' => $this->faker->sentence(),
            'harga' => $this->faker->randomElement([25000, 30000, 35000, 40000, 45000, 50000]),
            'durasi' => $this->faker->randomElement([15, 20, 30, 45, 60]),
            'is_active' => true,
        ];
    }

    /**
     * Layanan tidak aktif
     */
    public function tidakAktif(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}

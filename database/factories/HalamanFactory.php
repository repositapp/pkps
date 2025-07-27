<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Halaman>
 */
class HalamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => mt_rand(1, 2),
            'judul' => $this->faker->sentence(mt_rand(2, 8)),
            'slug' => $this->faker->slug(),
            'konten' => $this->faker->paragraph(mt_rand(20, 30)),
            'status' => 1,
        ];
    }
}

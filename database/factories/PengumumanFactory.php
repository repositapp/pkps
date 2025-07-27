<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengumuman>
 */
class PengumumanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kategori_id' => mt_rand(1, 11),
            'user_id' => mt_rand(1, 2),
            'judul' => $this->faker->sentence(mt_rand(2, 8)),
            'slug' => $this->faker->slug(),
            'body' => $this->faker->paragraph(mt_rand(20, 30)),
            'gambar' => 'pengumuman-images/default.png',
            'status' => 1,
        ];
    }
}

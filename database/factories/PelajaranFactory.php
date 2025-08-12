<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelajaran>
 */
class PelajaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_mapel' => $this->faker->randomElement([
                'Matematika',
                'Bahasa Indonesia',
                'Bahasa Inggris',
                'IPA',
                'IPS',
                'PKn',
                'Fisika',
                'Kimia',
                'Biologi',
                'Seni Budaya',
                'Kesehatan Jasmani',
            ])
        ];
    }
}

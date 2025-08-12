<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelas>
 */
class KelasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_kelas' => $this->faker->randomElement([
                'VII 1',
                'VII 2',
                'VII 3',
                'VII 4',
                'VII 5',
                'VIII 1',
                'VIII 2',
                'VIII 3',
                'VIII 4',
                'VIII 5',
                'IX 1',
                'IX 2',
                'IX 3',
                'IX 4',
                'IX 5'
            ])
        ];
    }
}

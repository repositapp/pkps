<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barber>
 */
class BarberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->adminBarber(),
            'nama' => $this->faker->company() . ' Barber',
            'nama_pemilik' => $this->faker->name(),
            'deskripsi' => $this->faker->paragraph(),
            'alamat' => $this->faker->address(),
            'telepon' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->companyEmail(),
            'gambar' => null,
            'waktu_buka' => '08:00:00',
            'waktu_tutup' => '20:00:00',
            'is_active' => true,
            'is_verified' => true,
        ];
    }

    /**
     * Barber tidak aktif
     */
    public function tidakAktif(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Barber belum terverifikasi
     */
    public function belumTerverifikasi(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_verified' => false,
        ]);
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => mt_rand(2, 31),
            'nama_pelanggan' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'alamat' => $this->faker->address(),
            'nomor_telepon' => $this->faker->phoneNumber(),
            'nomor_sambungan' => mt_rand(01, 99) . '.' . mt_rand(01, 99) . '.' . mt_rand(00001, 00100),
            // 'nomor_sambungan' akan diisi saat pemasangan disetujui
            'file_ktp' => null, // Bisa diisi dengan path file contoh jika diperlukan
        ];
    }
}

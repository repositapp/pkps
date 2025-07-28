<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'username' => $this->faker->username(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'telepon' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
            'role' =>  $this->faker->randomElement(['admin_komunitas', 'admin_barber', 'pelanggan']),
            'status' => '1',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Admin Komunitas state
     */
    public function adminKomunitas(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'admin_komunitas',
        ]);
    }

    /**
     * Admin Barber state
     */
    public function adminBarber(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'admin_barber',
        ]);
    }

    /**
     * Pelanggan state
     */
    public function pelanggan(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'pelanggan',
        ]);
    }
}

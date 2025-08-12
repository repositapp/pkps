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
            'role' =>  $this->faker->randomElement(['admin', 'guru', 'ortu']),
            // 'role' =>  'admin',
            'status' => '1',
            'remember_token' => Str::random(10),
        ];
    }

    public function admin()
    {
        return $this->state(fn() => ['role' => 'admin']);
    }

    public function guru()
    {
        return $this->state(fn() => ['role' => 'guru']);
    }

    public function ortu()
    {
        return $this->state(fn() => ['role' => 'ortu']);
    }
}

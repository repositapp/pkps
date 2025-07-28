<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Komunitas
        User::create([
            'name' => 'Admin Komunitas Baubau',
            'username' => 'admin',
            'email' => 'admin@themesbrand.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'telepon' => '081234567890',
            'alamat' => 'Jl. Poros Baubau - Kendari',
            'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
            'role' => 'admin_komunitas',
            'status' => '1',
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

        // Admin Barber
        User::factory(5)->adminBarber()->create();

        // Pelanggan
        User::factory(20)->pelanggan()->create();

        // User tambahan untuk testing
        User::factory(10)->create();
    }
}

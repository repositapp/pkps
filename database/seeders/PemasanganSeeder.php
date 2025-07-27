<?php

namespace Database\Seeders;

use App\Models\Pemasangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemasanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 25 data pemasangan contoh
        Pemasangan::factory()->count(30)->create();
    }
}

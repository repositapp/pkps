<?php

namespace Database\Seeders;

use App\Models\Pemutusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemutusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 15 data pemutusan contoh
        Pemutusan::factory()->count(15)->create();
    }
}

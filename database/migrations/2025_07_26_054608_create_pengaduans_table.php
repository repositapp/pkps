<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->index()->constrained();
            $table->text('deskripsi');
            $table->string('lokasi')->nullable(); // Lokasi dari maps
            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
            $table->text('alasan_penyelesaian')->nullable(); // Alasan jika pengaduan selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};

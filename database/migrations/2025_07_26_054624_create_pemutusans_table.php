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
        Schema::create('pemutusans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->index()->constrained();
            $table->text('deskripsi');
            $table->string('lokasi')->nullable(); // Lokasi dari maps
            $table->decimal('jumlah_tunggakan', 10, 2)->default(0);
            $table->enum('status', ['pending', 'proses', 'disetujui', 'ditolak'])->default('pending');
            $table->text('alasan_ditolak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemutusans');
    }
};

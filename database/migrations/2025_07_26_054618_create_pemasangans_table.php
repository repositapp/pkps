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
        Schema::create('pemasangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->index()->constrained();
            $table->text('deskripsi');
            $table->string('lokasi')->nullable(); // Lokasi dari maps
            $table->date('tanggal_permohonan');
            $table->date('tanggal_penelitian')->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->string('spk_tanggal')->nullable();
            $table->string('spk_nomor')->nullable();
            $table->string('ba_tanggal')->nullable();
            $table->string('ba_nomor')->nullable();
            $table->string('merek_meteran')->nullable();
            $table->boolean('kedudukan')->default(0); // 0 = Baru, 1 = Perubahan
            $table->boolean('status_pembayaran')->default(false);
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
        Schema::dropIfExists('pemasangans');
    }
};

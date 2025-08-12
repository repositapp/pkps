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
        Schema::create('perilakus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('pelajaran_id')->constrained('pelajarans')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('kategori_perilaku', ['taat', 'disiplin', 'melanggar']);
            $table->text('catatan')->nullable();
            $table->foreignId('tahun_ajaran_id')->index()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perilakus');
    }
};

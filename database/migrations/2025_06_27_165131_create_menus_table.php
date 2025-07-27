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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // Nama menu (misal: Tentang Kami, Berita)
            $table->string('slug')->unique();        // Digunakan di URL frontend
            $table->enum('type', ['halaman', 'berita', 'kegiatan', 'pengumuman']);
            $table->unsignedBigInteger('target_id')->nullable(); // ID dari tabel tujuan
            $table->unsignedBigInteger('parent_id')->nullable(); // Untuk submenu
            $table->integer('order')->default(0);    // Urutan tampil
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};

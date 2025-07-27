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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->index()->constrained();
            $table->date('periode');
            $table->integer('meter_awal');
            $table->integer('meter_akhir');
            $table->integer('volume_air'); // Volume air yang digunakan
            $table->decimal('biaya_administrasi', 10, 2);
            $table->decimal('biaya_air', 10, 2);
            $table->decimal('total_tagihan', 10, 2);
            $table->boolean('status_pembayaran')->default(false); // True jika sudah bayar
            $table->string('pembaca_meter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_penerbangan', function (Blueprint $table) {
            $table->id();
            $table->string('no_penerbangan')->unique();
            $table->string('maskapai');
            $table->string('jenis_pesawat');
            $table->string('tipe_pesawat');

            // TAMBAHKAN DUA KOLOM INI UNTUK MENGUNCI RUTE PESAWAT
            $table->unsignedBigInteger('id_kota_asal');
            $table->unsignedBigInteger('id_kota_tujuan');

            $table->string('status_penerbangan')->default('belum_terbang');
            $table->timestamps();

            // Relasi foreign key ke tabel master_kota agar datanya konsisten
            $table->foreign('id_kota_asal')->references('id')->on('master_kota')->onDelete('cascade');
            $table->foreign('id_kota_tujuan')->references('id')->on('master_kota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_penerbangan');
    }
};

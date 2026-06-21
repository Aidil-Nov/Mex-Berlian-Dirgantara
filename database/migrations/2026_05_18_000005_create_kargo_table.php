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
        Schema::create('kargo', function (Blueprint $table) {
            $table->string('no_resi')->primary(); // Primary Key berupa String
            $table->foreignId('id_pengirim')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('id_penerima')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('id_kota_asal')->constrained('master_kota')->restrictOnDelete();
            $table->foreignId('id_kota_tujuan')->constrained('master_kota')->restrictOnDelete();
            $table->foreignId('id_jenis')->constrained('master_jenis_barang')->restrictOnDelete();
            $table->foreignId('id_user')->constrained('users')->restrictOnDelete(); // Admin yang memproses

            $table->decimal('berat', 8, 2); // Presisi 8 digit, 2 desimal (misal: 999999.99 kg)
            $table->string('isi_barang');
            $table->string('status_terakhir');
            $table->dateTime('tgl_terima');
            $table->timestamps();

            $table->string('no_penerbangan')->nullable(); // Menyimpan kode seperti GA-501, JT-714
            $table->string('maskapai')->nullable();       // Menyimpan nama maskapai seperti Garuda Indonesia
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kargos');
    }
};

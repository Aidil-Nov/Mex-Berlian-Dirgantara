<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('komplain', function (Blueprint $table) {
            $table->string('id_komplain')->primary(); // Format: COMP-001
            $table->string('no_resi');
            $table->foreign('no_resi')->references('no_resi')->on('kargo')->cascadeOnDelete();

            // Data Pelapor
            $table->string('nama_pelapor');
            $table->string('hp_pelapor');
            $table->string('email_pelapor')->nullable();

            // Detail Komplain
            $table->enum('kategori', ['keterlambatan', 'rusak', 'hilang', 'layanan']);
            $table->enum('tingkat_keparahan', ['rendah', 'sedang', 'tinggi', 'kritis']);
            $table->text('deskripsi');
            $table->string('estimasi_klaim')->nullable();

            // Data Penanganan
            $table->foreignId('id_user')->constrained('users'); // Admin yang mencatat
            $table->enum('channel', ['telepon', 'whatsapp', 'email', 'langsung']);
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->text('tindakan_solusi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komplain');
    }
};
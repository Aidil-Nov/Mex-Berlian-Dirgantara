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
        Schema::create('history_status', function (Blueprint $table) {
            $table->id();
            $table->string('no_resi');
            $table->foreign('no_resi')->references('no_resi')->on('kargo')->cascadeOnDelete();

            $table->foreignId('id_user')->constrained('users')->restrictOnDelete(); // Admin yang update
            $table->string('status');
            $table->text('keterangan')->nullable();
            $table->timestamp('waktu_update')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_statuses');
    }
};

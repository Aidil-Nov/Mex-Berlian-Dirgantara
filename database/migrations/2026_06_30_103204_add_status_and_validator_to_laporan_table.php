<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->enum('status', ['pending', 'validated'])->default('pending')->after('file_path');
            $table->foreignId('validator_id')->nullable()->constrained('users')->after('status');
            $table->timestamp('validated_at')->nullable()->after('validator_id');
        });
    }

    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['validator_id']);
            $table->dropColumn(['status', 'validator_id', 'validated_at']);
        });
    }
};
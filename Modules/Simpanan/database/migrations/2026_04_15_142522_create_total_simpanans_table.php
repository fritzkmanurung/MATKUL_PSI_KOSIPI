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
        Schema::create('total_simpanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_simpanan_pokok', 12, 2)->default(0);
            $table->decimal('total_simpanan_wajib', 12, 2)->default(0);
            $table->decimal('total_simpanan_sukarela', 12, 2)->default(0);
            $table->decimal('total_simpanan', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_simpanans');
    }
};

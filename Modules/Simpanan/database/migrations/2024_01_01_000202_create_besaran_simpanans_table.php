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
        Schema::create('besaran_simpanans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_simpanan')->default('Wajib');
            $table->decimal('nominal', 12, 2)->default(0);
            $table->boolean('is_aktif')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('besaran_simpanans');
    }
};

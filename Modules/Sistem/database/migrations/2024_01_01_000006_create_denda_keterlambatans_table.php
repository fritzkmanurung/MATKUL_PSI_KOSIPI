<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('denda_keterlambatans', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_denda', ['Simpanan Wajib', 'Pinjaman'])->default('Simpanan Wajib');
            $table->decimal('nominal_denda', 12, 2)->default(0);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denda_keterlambatans');
    }
};

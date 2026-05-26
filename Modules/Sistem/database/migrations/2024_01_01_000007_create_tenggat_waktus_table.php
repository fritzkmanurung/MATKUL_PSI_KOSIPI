<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenggat_waktus', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_tagihan')->default('Simpanan');
            $table->integer('tanggal_mulai')->default(1);
            $table->integer('tanggal_akhir')->default(7);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenggat_waktus');
    }
};

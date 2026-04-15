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
        Schema::create('simpanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('nominal_simpanan', 12, 2);
            $table->enum('jenis_simpanan', ['Wajib', 'Sukarela', 'Pokok']);
            $table->date('waktu_simpanan')->nullable();
            $table->string('periode', 50)->nullable();
            $table->string('bulan', 20)->nullable();
            $table->string('jenis_pembayaran', 50)->nullable();
            $table->string('status', 30)->default('Menunggu'); // Menunggu, Diterima, Ditolak
            $table->string('bukti_transfer')->nullable();
            $table->text('catatan_penolakan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanans');
    }
};

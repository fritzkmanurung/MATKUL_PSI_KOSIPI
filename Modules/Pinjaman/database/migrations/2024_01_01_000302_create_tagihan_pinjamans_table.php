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
        Schema::create('tagihan_pinjamans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tagihan')->unique();
            $table->foreignId('pinjaman_id')->constrained('pinjamans')->onDelete('cascade');
            $table->unsignedInteger('tagihan_ke'); // 1, 2, 3..
            $table->date('jatuh_tempo');
            $table->decimal('nominal_pokok', 12, 2);
            $table->decimal('nominal_bunga', 12, 2);
            $table->decimal('total_tagihan', 12, 2);
            $table->decimal('denda', 12, 2)->default(0);
            $table->string('status', 30)->default('Belum Dibayar'); // Belum Dibayar, Menunggu Verifikasi, Lunas, Ditolak
            $table->string('bukti_bayar_transfer')->nullable();
            $table->date('tanggal_bayar')->nullable();
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
        Schema::dropIfExists('tagihan_pinjamans');
    }
};

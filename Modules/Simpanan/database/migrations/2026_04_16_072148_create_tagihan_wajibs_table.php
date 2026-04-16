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
        Schema::create('tagihan_wajibs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kode_tagihan')->unique();
            $table->string('periode')->nullable(); // format YYYY-MM
            $table->string('bulan')->nullable(); // format MM
            $table->decimal('nominal_tagihan', 15, 2)->default(0);
            $table->enum('status', ['Belum Lunas', 'Lunas', 'Menunggu Verifikasi'])->default('Belum Lunas');
            $table->string('bukti_bayar')->nullable();
            $table->text('catatan_penolakan')->nullable();
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_wajibs');
    }
};

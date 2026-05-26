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
        Schema::create('pinjamans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pinjaman')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('jumlah_pinjaman', 12, 2);
            $table->unsignedInteger('tenor_bulan');
            $table->decimal('bunga_persen', 5, 2); // Disalin dari Master Bunga
            $table->string('alasan');
            $table->enum('status_pegawai', ['Kontrak', 'Tetap']);
            $table->unsignedInteger('masa_kontrak')->nullable(); // Dalam bulan

            $table->string('pekerjaan', 100);
            $table->string('status')->default('Menunggu'); // Menunggu, Disetujui, Ditolak, Lunas
            $table->string('dokumen_persetujuan_1')->nullable();
            $table->string('dokumen_persetujuan_2')->nullable();
            $table->string('bukti_transfer_admin')->nullable();
            $table->timestamp('tanggal_pinjaman')->nullable();
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
        Schema::dropIfExists('pinjamans');
    }
};

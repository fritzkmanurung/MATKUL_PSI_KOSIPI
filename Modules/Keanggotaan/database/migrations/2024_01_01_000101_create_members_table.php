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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Profil Koperasi
            $table->string('nba', 50)->nullable()->unique(); // No Baku Anggota
            $table->string('nip', 50)->nullable()->unique();
            $table->string('nik', 50)->nullable()->unique();
            
            // Profil Pribadi
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('status_perkawinan', 50)->nullable();
            $table->string('nama_suami_istri', 100)->nullable();
            
            // Relasi Sistem (Master Data)
            $table->foreignId('agama_id')->nullable()->constrained('agamas')->nullOnDelete();
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerjas')->nullOnDelete();
            $table->foreignId('instansi_id')->nullable()->constrained('instansis')->nullOnDelete();
            $table->foreignId('status_id')->nullable()->constrained('statuses')->nullOnDelete();
            
            // Keanggotaan
            $table->string('foto_profil')->nullable();
            $table->date('tanggal_bergabung')->nullable();
            $table->boolean('is_aktif')->default(true);
            
            // Ahli Waris
            $table->string('nama_ahli_waris', 100)->nullable();
            $table->string('hubungan_ahli_waris', 50)->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

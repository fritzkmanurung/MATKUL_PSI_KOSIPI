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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip', 50)->nullable()->unique()->after('id');
            $table->string('nik', 50)->nullable()->unique()->after('nip');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('email');
            $table->string('tempat_lahir', 100)->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->text('alamat')->nullable()->after('tanggal_lahir');
            $table->string('no_hp', 20)->nullable()->after('alamat');
            $table->foreignId('agama_id')->nullable()->constrained('agamas')->nullOnDelete();
            $table->foreignId('unit_kerja_id')->nullable()->constrained('unit_kerjas')->nullOnDelete();
            $table->foreignId('instansi_id')->nullable()->constrained('instansis')->nullOnDelete();
            $table->foreignId('status_id')->nullable()->constrained('statuses')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['agama_id']);
            $table->dropForeign(['unit_kerja_id']);
            $table->dropForeign(['instansi_id']);
            $table->dropForeign(['status_id']);
            $table->dropColumn([
                'nip', 'nik', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 
                'alamat', 'no_hp', 'agama_id', 'unit_kerja_id', 'instansi_id', 'status_id'
            ]);
        });
    }
};

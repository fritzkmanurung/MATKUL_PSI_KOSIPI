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
            $table->string('pekerjaan')->nullable()->after('no_hp');
            $table->string('status_pegawai')->nullable()->after('pekerjaan');
            $table->string('status_perkawinan')->nullable()->after('status_pegawai');
            $table->integer('masa_kontrak')->nullable()->after('status_perkawinan')->comment('dalam bulan');
            $table->string('nama_suami_istri')->nullable()->after('masa_kontrak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pekerjaan', 'status_pegawai', 'status_perkawinan', 'masa_kontrak', 'nama_suami_istri']);
        });
    }
};

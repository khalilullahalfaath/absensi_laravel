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
        Schema::create('peserta_magang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peserta');
            $table->string('no_presensi')->unique();
            $table->boolean('status_peserta_aktif')->default(true);
            $table->boolean('status_akun_aplikasi')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_peserta_magang');
    }
};

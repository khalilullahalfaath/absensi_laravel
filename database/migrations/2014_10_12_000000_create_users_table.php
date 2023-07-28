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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // create role column
            // 0. admin
            // 1. user
            $table->integer('role')->default(1);
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer("no_presensi");
            $table->string('asal_instansi');
            $table->string('nama_unit_kerja');
            $table->string('jenis_kelamin');
            $table->datetime('tanggal_lahir');
            $table->rememberToken();
            $table->timestamps();
           

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

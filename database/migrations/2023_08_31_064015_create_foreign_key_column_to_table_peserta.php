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
            // create column peserta_id to users
            $table->unsignedBigInteger('peserta_id')->nullable();
            // create foreign key to absensi_check_outs table
            $table->foreign('peserta_id')->references('id')->on('peserta_magang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // drop foreign key
            $table->dropForeign(['peserta_id']);
            // drop column peserta_id
            $table->dropColumn('peserta_id');
        });
    }
};

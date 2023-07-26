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
        Schema::table('absensi_checkin', function (Blueprint $table) {
            // create column peserta_id to absensi_checke
            $table->unsignedBigInteger('peserta_id');
            // create foreign key to peserta table
            $table->foreign('peserta_id')->references('id')->on('peserta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi_checkin', function (Blueprint $table) {
            // drop foreign key
            $table->dropForeign(['peserta_id']);
            // drop column peserta_id
            $table->dropColumn('peserta_id');
        });
    }
};

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
        Schema::table('record', function (Blueprint $table) {
            // create column id_absensi_checkin to absensi_check_out
            $table->unsignedBigInteger('id_absensi_checkin');
            // create foreign key to peserta table
            $table->foreign('id_absensi_checkin')->references('id')->on('absensi_checkin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('record', function (Blueprint $table) {
            // drop foreign key
            $table->dropForeign(['id_absensi_checkin']);
            // drop column id_absensi_checkin
            $table->dropColumn('id_absensi_checkin');
        });
    }
};

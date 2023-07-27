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
        Schema::table('records', function (Blueprint $table) {
            // create column absensi_check_out_id to absensi_check_out
            $table->unsignedBigInteger('absensi_check_out_id')->nullable();
            // create foreign key to absensi_check_outs table
            $table->foreign('absensi_check_out_id')->references('id')->on('absensi_check_outs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('records', function (Blueprint $table) {
            // drop foreign key
            $table->dropForeign(['absensi_check_out_id']);
            // drop column absensi_check_out_id
            $table->dropColumn('absensi_check_out_id');
        });
    }
};

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
        Schema::table('absensi_check_outs', function (Blueprint $table) {
            // create column users_id to absensi_check_out
            $table->unsignedBigInteger('user_id');
            // create foreign key to users table
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi_check_outs', function (Blueprint $table) {
            // drop foreign key
            $table->dropForeign(['user_id']);
            // drop column users_id
            $table->dropColumn('user_id');
        });
    }
};

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
        Schema::table('absensi_check_ins', function (Blueprint $table) {
            // create column users_id to absensi_checke
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
        Schema::table('absensi_check_ins', function (Blueprint $table) {
            // Check if the foreign key constraints exist and drop them
            if (Schema::hasColumn('absensi_check_ins', 'user_id')) {
                // Drop any foreign key constraints that reference the user_id column
                $table->dropForeign(['user_id']);
            }
        });
    }
};

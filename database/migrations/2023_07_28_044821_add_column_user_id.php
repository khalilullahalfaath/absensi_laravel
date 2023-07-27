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
        // add user_id column to records table
        Schema::table('records', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            // create foreign key to users table
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop foreign key
        Schema::table('records', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            // drop column user_id
            $table->dropColumn('user_id');
        });
    }
};

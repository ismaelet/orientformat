<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        // Remove duplicate administrators, keeping the lowest ID
        DB::statement('
            DELETE a1
            FROM administrators a1
            INNER JOIN administrators a2
                ON a1.user_id = a2.user_id
                AND a1.id > a2.id
        ');

        // Remove duplicate teachers, keeping the highest ID
        DB::statement('
            DELETE t1
            FROM teachers t1
            INNER JOIN teachers t2
                ON t1.user_id = t2.user_id
                AND t1.id < t2.id
        ');

        Schema::table('teachers', function (Blueprint $table) {
            $table->unique('user_id');
        });

        Schema::table('administrators', function (Blueprint $table) {
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
        });

        Schema::table('administrators', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
        });
    }
};

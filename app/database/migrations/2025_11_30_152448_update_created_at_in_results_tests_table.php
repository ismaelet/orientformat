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
        // Update the created_at and the updated_at columns in results_tests table to be equal to the time column, if they are null
        Schema::table('results_tests', function (Blueprint $table) {
            DB::statement('UPDATE results_tests SET created_at = time WHERE created_at IS NULL');
            DB::statement('UPDATE results_tests SET updated_at = time WHERE updated_at IS NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
    }
};

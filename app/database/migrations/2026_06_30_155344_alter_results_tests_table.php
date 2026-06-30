<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('results_tests', function (Blueprint $table) {
            $table->dropUnique('studentId_testId_index');
            $table->dropUnique('testId_studentId_index');
            $table->index(['studentId', 'testId'], 'studentId_testId_index');
            $table->index(['testId', 'studentId'], 'testId_studentId_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('results_tests', function (Blueprint $table) {
            $table->dropIndex('studentId_testId_index');
            $table->dropIndex('testId_studentId_index');
            $table->unique(['studentId', 'testId'], 'studentId_testId_index');
            $table->unique(['testId', 'studentId'], 'testId_studentId_index');
        });
    }
};

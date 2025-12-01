<?php

use App\Models\Schools\SchoolClass;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->unsignedBigInteger('grade_level_id')->nullable()->after('referentId');
        });

        $classes = SchoolClass::all();

        $classes->each(function ($class) {
            $grade = $class->grade();

            if (!$grade) {
                return;
            }

            $class->update([
                'grade_level_id' => $grade->id,
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropColumn('grade_level_id');
        });
    }
};

<?php

use App\Models\Activities\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('activities_sections', function (Blueprint $table) {
			$table->renameColumn('grades', 'legacy_grades');
		});

		Schema::create('grade_section', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('grade_id');
			$table->unsignedBigInteger('section_id');
			$table->unique(['grade_id', 'section_id']);
			$table->timestamps();
		});

		$sections = Section::with('grades')->get();

		foreach ($sections as $section) {
			$legacyGrades = explode(',', $section->legacy_grades);

			foreach ($legacyGrades as $gradeId) {
				$section->grades()->attach($gradeId);
			}
		}
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('grade_section');

		Schema::table('activities_sections', function (Blueprint $table) {
			$table->renameColumn('legacy_grades', 'grades');
		});
	}
};

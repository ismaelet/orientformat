<?php

use App\Models\Activities\Section;
use App\Models\Schools\Grade;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('activities_grades', function (Blueprint $table) {
			$table->timestamps();
		});

		$professionalGrades[] = Grade::updateOrCreate([
			'absolute_number' => 4,
			'school_relative_number' => 1,
			'is_highschool' => true,
			'is_professional' => true,
		], []);

		$professionalGrades[] = Grade::updateOrCreate([
			'absolute_number' => 5,
			'school_relative_number' => 2,
			'is_highschool' => true,
			'is_professional' => true,
		], []);

		$nonProfessionalGrades = Grade::where('is_highschool', true)
			->where('is_professional', false)
			->whereBetween('school_relative_number', [1, 2])
			->with('sections')
			->get();

		foreach ($professionalGrades as $grade) {
			$nonProfessionalGrade = $nonProfessionalGrades->firstWhere('school_relative_number', $grade->school_relative_number);

			foreach ($nonProfessionalGrade->sections as $section) {
				$grade->sections()->attach($section->id);
			}

			$grade->load('sections');
			$areas = $grade->sections->pluck('areaId')->unique();

			foreach ($areas as $areaId) {
				$grade->areas()->attach($areaId);
			}
		}
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('activities_grades', function (Blueprint $table) {
			$table->dropTimestamps();
		});

		$professionalGrades = Grade::where('is_professional', true)
			->whereIn('absolute_number', [4, 5])
			->get();

		foreach ($professionalGrades as $grade) {
			$grade->sections()->detach();
			$grade->areas()->detach();
			$grade->delete();
		}
	}
};

<?php

use App\Models\Schools\SchoolClass;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		$classes = SchoolClass::where('startingGrade', '>', 3)->get();

		$classes->each(function (SchoolClass $class) {
			$startingYear = $class->startingYear;
			$currentYear = 2025;
			$startingGrade = $class->startingGrade;
			$maxGrade = $class->isProfessional() ? 7 : 8;
			$class->update([
				'grade' => min($startingGrade + ($currentYear - $startingYear), $maxGrade),
			]);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		//
	}
};

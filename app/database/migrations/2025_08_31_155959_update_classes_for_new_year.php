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
		$classes = SchoolClass::where('ended', 0)->get();

		foreach ($classes as $class) {
			$newGrade = $class->grade + 1;

			if ($newGrade > $class->last_grade) {
				$class->update([
					'ended' => 1
				]);
				continue;
			}

			$class->update([
				'grade' => $newGrade
			]);

			if ($class->isHighSchool()) {
				$className = preg_replace_callback('/\d+/', function ($matches) {
					return $matches[0] + 1;
				}, $class->letter);

				$class->update([
					'letter' => $className
				]);
			}
		}
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
	}
};

<?php

use App\Models\Activities\Area;
use App\Models\Schools\Grade;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('area_grade', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('area_id');
			$table->unsignedBigInteger('grade_id');
			$table->unique(['grade_id', 'area_id']);
			$table->timestamps();
		});

		$grades = Grade::all();

		foreach ($grades as $grade) {
			$areas = $grade->legacy_areas();

			foreach ($areas as $area) {
				$grade->areas()->attach($area->id);
			}
		}
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('area_grade');
	}
};

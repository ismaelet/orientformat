<?php

use App\Models\User\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		$teachers = Teacher::whereNull('school_id')
			->with('school_classes', 'school_classes.school')
			->get();

		foreach ($teachers as $teacher) {
			$latestClass = $teacher->school_classes->sortByDesc('created_at')->first();

			if ($latestClass?->school) {
				$teacher->school_id = $latestClass->school->id;
				$teacher->save();
			}
		}

		Teacher::find(4719)
			->update(['school_id' => 24]);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('teachers', function (Blueprint $table) {
			//
		});
	}
};

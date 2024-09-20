<?php

use App\Models\Schools\SchoolClass;
use App\Models\User\Teacher;
use Illuminate\Database\Migrations\Migration;

class DisableHighschoolTeachers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		$highSchoolClasses = SchoolClass::where('startingGrade', '>', 3)->get();

		$highSchoolClasses->each(function ($class) {
			$teachers = Teacher::whereRaw("FIND_IN_SET(?, classes)", [$class->id])->get();

			$teachers->each(function ($teacher) {
				$teacher->user->update(['active' => false]);
			});
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		$disabledTeachers = Teacher::whereHas('user', function ($query) {
			$query->where('active', false);
		})->get();

		$disabledTeachers->each(function ($teacher) {
			$teacher->user->update(['active' => true]);
		});
	}
}

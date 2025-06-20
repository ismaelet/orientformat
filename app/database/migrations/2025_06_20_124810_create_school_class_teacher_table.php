<?php

use App\Models\Schools\SchoolClass;
use App\Models\User\Teacher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('school_class_teacher', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('school_class_id')->index();
			$table->unsignedBigInteger('teacher_id')->index();
			$table->timestamps();
		});

		$teachers = Teacher::all();

		foreach ($teachers as $teacher) {
			$classes = explode(',', $teacher->classes);

			foreach ($classes as $class) {
				if ($class && SchoolClass::where('id', $class)->exists()) {
					$class = SchoolClass::find($class);
					$teacher->school_classes()->attach($class->id);
				} else {
					continue;
				}
			}
		}

		Schema::table('teachers', function (Blueprint $table) {
			$table->dropColumn(['classes']);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('teachers', function (Blueprint $table) {
			$table->string('classes')->nullable();
		});

		$teachers = Teacher::all();

		foreach ($teachers as $teacher) {
			$classes = $teacher->school_classes()->pluck('id')->toArray();
			$teacher->classes = implode(',', $classes);
			$teacher->save();
		}

		Schema::dropIfExists('school_class_teacher');
	}
};

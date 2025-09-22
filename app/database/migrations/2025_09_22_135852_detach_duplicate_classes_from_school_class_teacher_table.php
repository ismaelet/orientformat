<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {

		$duplicates = DB::table('school_class_teacher')
			->select('school_class_id', 'teacher_id', DB::raw('COUNT(*) as count'))
			->groupBy('school_class_id', 'teacher_id')
			->having('count', '>', 1)
			->get();

		foreach ($duplicates as $duplicate) {
			$records = DB::table('school_class_teacher')
				->where('school_class_id', $duplicate->school_class_id)
				->where('teacher_id', $duplicate->teacher_id)
				->orderBy('created_at', 'asc')
				->get();

			// Detach all but the first record
			$first = true;
			foreach ($records as $record) {
				if ($first) {
					$first = false;
					continue;
				}

				DB::table('school_class_teacher')->delete($record->id);
			}
		}

		Schema::table('school_class_teacher', function (Blueprint $table) {
			$table->unique(['school_class_id', 'teacher_id'], 'school_class_teacher_unique');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('school_class_teacher', function (Blueprint $table) {
			$table->dropUnique('school_class_teacher_unique');
		});
	}
};

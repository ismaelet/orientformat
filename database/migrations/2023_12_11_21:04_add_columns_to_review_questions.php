<?php

use App\Models\Reviews\ReviewQuestion;
use App\Support\Database\Blueprint;

return new class {

	/**
	 * Run the migration
	 */
	public function up(): void {
		ReviewQuestion::alter(function (Blueprint $table) {
			$table->string('full_slug');
			$table->string('show_to_teacher')->default(1);
			$table->string('teacher_text')->length(1024);
		});

		DB::update("review_questions SET full_slug = CONCAT('s', areaId, 'd', slug), teacher_text = text");
	}

	/**
	 * Reverse the migration
	 */
	public function down(): void {
		ReviewQuestion::alter(function (Blueprint $table) {
			$table->drop('full_slug');
			$table->drop('show_to_teacher');
			$table->string('teacher_text');
		});
	}
};

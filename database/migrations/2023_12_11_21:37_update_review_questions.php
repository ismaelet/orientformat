<?php

use App\Models\Reviews\ReviewQuestion;

return new class {

	/**
	 * Run the migration
	 */
	public function up(): void {
		ReviewQuestion::find(14)
			->set(['show_to_teacher' => 0])
			->save();
	}

	/**
	 * Reverse the migration
	 */
	public function down(): void {
		ReviewQuestion::find(14)
			->set(['show_to_teacher' => 1])
			->save();
	}
};

<?php

use App\Models\User\Student;
use App\Support\Database\Blueprint;

return new class {

	/**
	 * Run the migration
	 */
	public function up(): void {
		Student::alter(function (Blueprint $table) {
			$table->int('id');
		});

		DB::update('students SET id = userID');
	}

	/**
	 * Reverse the migration
	 */
	public function down(): void {
		Student::alter(function (Blueprint $table) {
			$table->drop('id');
		});
	}
};

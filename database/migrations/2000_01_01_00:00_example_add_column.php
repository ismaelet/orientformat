<?php

use App\Support\Database\Blueprint;

return new class {

	/**
	 * Run the migration
	 */
	public function up(): void {
		// Model::alter(function (Blueprint $table) {
		// 	$table->string('column');
		// });
	}

	/**
	 * Reverse the migration
	 */
	public function down(): void {
		// Model::alter(function (Blueprint $table) {
		// 	$table->drop('column');
		// });
	}
};

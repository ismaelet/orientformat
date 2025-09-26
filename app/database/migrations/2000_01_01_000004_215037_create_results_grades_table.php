<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hasTable('results_grades')) {
			Schema::create('results_grades', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('studentId');
				$table->unsignedBigInteger('gradeId');
				$table->unsignedInteger('progressPercentage')->default(0);
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('results_grades');
	}
};

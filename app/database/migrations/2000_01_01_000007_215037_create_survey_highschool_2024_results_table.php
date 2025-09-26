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
		if (!Schema::hasTable('survey_highschool_2024_results')) {
			Schema::create('survey_highschool_2024_results', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('teacher_id');
				$table->text('results');
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
		Schema::dropIfExists('survey_highschool_2024_results');
	}
};

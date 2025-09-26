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
		if (!Schema::hasTable('activities_tests')) {
			Schema::create('activities_tests', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('sectionId');
				$table->unsignedBigInteger('areaId');
				$table->string('title');
				$table->string('slug');
				$table->string('template')->default('blade');
				$table->text('description')->nullable();
				$table->text('shortDescription')->nullable();
				$table->unsignedTinyInteger('steps')->default(1);
				$table->boolean('reviewResult')->default(false);
				$table->boolean('reviewable')->default(true);
				$table->boolean('active')->default(true);
				$table->unsignedBigInteger('requiredTestId')->nullable();
				$table->unsignedBigInteger('followUpTestId')->nullable();
				$table->unsignedBigInteger('recapTestId')->nullable();
				$table->unsignedBigInteger('surveyId')->nullable();
				$table->timestamps();
				$table->softDeletes();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('activities_tests');
	}
};

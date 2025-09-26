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
		if (!Schema::hasTable('students')) {
			Schema::create('students', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('userId');
				$table->unsignedBigInteger('schoolClassId')->nullable();
				$table->boolean('status')->default(true);
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
		Schema::dropIfExists('students');
	}
};

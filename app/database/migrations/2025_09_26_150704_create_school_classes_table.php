<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		if (!Schema::hasTable('school_classes')) {
			Schema::create('school_classes', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('schoolId');
				$table->unsignedBigInteger('referentId');
				$table->string('name');
				$table->string('letter');
				$table->string('code')->unique();
				$table->unsignedSmallInteger('grade');
				$table->unsignedSmallInteger('startingGrade');
				$table->unsignedInteger('year');
				$table->unsignedInteger('startingYear');
				$table->boolean('ended')->default(false);
				$table->boolean('professional')->default(false);
				$table->timestamps();
				$table->softDeletes();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('school_classes');
	}
};

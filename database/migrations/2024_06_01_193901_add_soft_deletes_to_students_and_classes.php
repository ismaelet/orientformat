<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToStudentsAndClasses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('students', function (Blueprint $table) {
			$table->softDeletes();
		});

		Schema::table('school_classes', function (Blueprint $table) {
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('students', function (Blueprint $table) {
			$table->dropSoftDeletes();
		});

		Schema::table('school_classes', function (Blueprint $table) {
			$table->dropSoftDeletes();
			$table->dropTimestamps();
		});
	}
}

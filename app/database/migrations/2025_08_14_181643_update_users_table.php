<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('users', function (Blueprint $table) {
			$table->renameColumn('firstName', 'first_name');
			$table->renameColumn('lastName', 'last_name');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('users', function (Blueprint $table) {
			$table->renameColumn('first_name', 'firstName');
			$table->renameColumn('last_name', 'lastName');
		});
	}
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('teachers', function (Blueprint $table) {
			$table->renameColumn('userId', 'id');
			$table->unsignedBigInteger('user_id')->after('id');
			$table->unsignedBigInteger('school_id')->after('user_id')->nullable();
		});

		// Copy every id value to user_id
		DB::table('teachers')->update(['user_id' => DB::raw('id')]);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		DB::table('teachers')->update(['id' => DB::raw('user_id')]);

		Schema::table('teachers', function (Blueprint $table) {
			$table->dropColumn(['user_id', 'school_id']);
			$table->renameColumn('id', 'userId');
		});
	}
};

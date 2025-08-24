<?php

use App\Models\Activities\Test;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('activities_tests', function (Blueprint $table) {
			$table->boolean('reviewable')->default(true);
		});

		Test::find(22)->update(['reviewable' => false]);
		Test::find(32)->update(['reviewable' => false]);
		Test::find(163)->update(['reviewable' => false]);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('activities_tests', function (Blueprint $table) {
			$table->dropColumn('reviewable');
		});
	}
};

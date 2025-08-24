<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('activities_sections', function (Blueprint $table) {
			$table->unsignedBigInteger('evaluation_test_id')->nullable()->after('areaId');
			$table->string('result_label')->nullable()->after('slug');
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('activities_sections', function (Blueprint $table) {
			$table->dropColumn('evaluation_test_id');
			$table->dropColumn('result_label');
		});
	}
};

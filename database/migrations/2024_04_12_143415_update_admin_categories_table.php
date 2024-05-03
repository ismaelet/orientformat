<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdminCategoriesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('admin_categories', function (Blueprint $table) {
			// Rename the column
			$table->renameColumn('manager', 'for_supervisors');
			$table->renameColumn('sort', 'order');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('admin_categories', function (Blueprint $table) {
			// Rename the column
			$table->renameColumn('for_supervisors', 'manager');
			$table->renameColumn('order', 'sort');
		});
	}
}

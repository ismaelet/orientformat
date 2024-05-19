<?php

use App\Models\Admin\AdminSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAdminTables extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('admin_categories', function (Blueprint $table) {
			$table->renameColumn('manager', 'for_superadmin');
			$table->renameColumn('sort', 'order');
			$table->timestamps();
		});

		Schema::table('admin_sections', function (Blueprint $table) {
			$table->timestamps();
		});

		AdminSection::join('admin_categories', 'admin_sections.category', '=', 'admin_categories.slug')
			->update([
				'admin_sections.category' => DB::raw('admin_categories.id'),
			]);

		Schema::table('admin_sections', function (Blueprint $table) {
			$table->renameColumn('category', 'category_id');
		});

		AdminSection::find(9)->delete();

		Schema::table('admin_sections', function (Blueprint $table) {
			$table->unsignedBigInteger('category_id')->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('admin_categories', function (Blueprint $table) {
			$table->renameColumn('for_superadmin', 'manager');
			$table->renameColumn('order', 'sort');
		});
	}
}

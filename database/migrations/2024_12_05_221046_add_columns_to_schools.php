<?php

use App\Models\Schools\School;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSchools extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('schools', function (Blueprint $table) {
			$table->boolean('has_high_school')->default(false);
			$table->timestamps();
		});

		$highSchoolsIds = [40, 67, 14, 48, 78, 79, 80];

		foreach ($highSchoolsIds as $id) {
			School::find($id)->update(['has_high_school' => true]);
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('schools', function (Blueprint $table) {
			$table->dropTimestamps();
		});
	}
}

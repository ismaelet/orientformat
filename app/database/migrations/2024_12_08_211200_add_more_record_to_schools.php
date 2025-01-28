<?php

use App\Models\Schools\School;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreRecordToSchools extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		School::create([
			'name' => 'Istituto d\'Istruzione Superiore Don Milani',
			'has_high_school' => true,
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		School::where('name', 'Istituto d\'Istruzione Superiore Don Milani')->delete();
	}
}

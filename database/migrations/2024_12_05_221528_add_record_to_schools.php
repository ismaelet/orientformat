<?php

use App\Models\Schools\School;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecordToSchools extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		School::create([
			'name' => 'Istituto Tecnico Economico Antonio Tambosi',
			'has_high_school' => true,
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		School::where('name', 'Istituto Tecnico Economico Antonio Tambosi')->delete();
	}
}

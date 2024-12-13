<?php

use App\Models\Schools\School;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecordToSchool121301 extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		School::create([
			'name' => 'Liceo Musicale e Coreutico Bonporti',
			'has_high_school' => true,
		]);

		School::create([
			'name' => 'ITET “Felice e Gregorio Fontana”',
			'has_high_school' => true,
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		School::where('name', 'Liceo Musicale e Coreutico Bonporti')->delete();
		School::where('name', 'ITET “Felice e Gregorio Fontana”')->delete();
	}
}

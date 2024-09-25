<?php

use App\Models\Activities\Test;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToActivitiesTestsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		// Test::create([
		// 	'sectionId' => 27,
		// 	'areaId' => 1,
		// 	'title' => 'I Volti Parlano',
		// 	'description' => 'Associa, trascinando col mouse, bocca e sguardo: ottieni così una particolare emozione. Qual è la tua in questo momento? Se riesci, puoi anche associare un nome all’emozione che hai realizzato col disegno.',
		// 	'shortDescription' => 'Crea emozioni, associando sguardo e bocca.',
		// 	'slug' => 'i-volti-parlano',
		// 	'step' => 4,
		// 	'template' => 'test-next',
		// ]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		// Test::where('slug', 'i-volti-parlano')->delete();
	}
}

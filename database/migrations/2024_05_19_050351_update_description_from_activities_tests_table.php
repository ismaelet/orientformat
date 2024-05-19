<?php

use App\Models\Activities\Test;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDescriptionFromActivitiesTestsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('activities_tests', function (Blueprint $table) {
			$table->timestamps();
		});

		Test::whereIn('id', [31, 109, 111, 113])->update(['description' => 'In base alle risposte che hai dato nel questionario sono stati calcolati i tui stili principali. I cerchi evidenziati indicano i risultati ottenuti. Gli stili con i cerchi evidenziati più grandi sono quelli che hai sviluppato di più.
		Come vedi, gli stili sono in opposizione. Non ci sono positivi o negativi, ma, quando uno stile è molto accentuato, riducendo molto l’uso dello contrapposto, può comportare difficoltà con persone di stile opposto, ad esempio insegnanti, o in certe situazioni.
		
		Se ti è possibile, puoi rifare il questionario insieme con qualcuno che ti conosce abbastanza bene.']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('activities_tests', function (Blueprint $table) {
			$table->dropTimestamps();
		});
	}
}

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
		Test::create([
			'sectionId' => 59,
			'areaId' => 4,
			'title' => 'Profilo Orientativo Individualizzato',
			'description' => 'Il <strong>POI</strong> ti fornisce un quadro complessivo e sintetico delle tue autovalutazioni relative alle competenze personali e alle
competenze di base trasversali. Il quadro viene integrato e aggiornato in base sezioni che hai completato. Il profilo che viene
così definendosi sulla base delle tue autovalutazioni è condiviso anche dai tuoi insegnanti. Se vuoi, puoi inserire il tuo POI
nell’e-portfolio.',
			'shortDescription' => 'Qui trovi il tuo profilo orientativo che si aggiorna con il progredire delle tue autovalutazioni',
			'slug' => 'poi',
			'step' => 1,
			'template' => 'blade',
		]);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Test::where('slug', 'poi')->delete();
	}
};

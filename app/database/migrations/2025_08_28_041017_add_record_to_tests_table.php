<?php

use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\Schools\Grade;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		$section = Section::create([
			'areaId' => 4,
			'name' => 'Autovalutazioni',
			'slug' => 'autovalutazioni',
			'description' => 'Qui puoi trovare tutte le autovalutazioni relative alle diverse aree che costituiscono il Profilo Orientativo Individualizzato (POI)',
			'active' => true,
			'isStandard' => false,
			'estimated_duration' => 1
		]);

		$grades = Grade::where('absolute_number', '>', 1)->get();

		$grades->each(function (Grade $grade) use ($section) {
			$grade->sections()->attach($section->id);
		});

		Test::create([
			'sectionId' => $section->id,
			'areaId' => 4,
			'title' => 'Autovalutazioni',
			'description' => 'In tutte le sezioni ti viene richiesta un’autovalutazione sulla base dei descrittori di competenza. In diverse sezioni ti viene
richiesto di metterti alla prova per verificare la fondatezza dei dati da te forniti. Ad ogni prova viene attribuito un punteggio,
che funziona da stimolo a rivedere eventualmente la tua autovalutazione, ma non influisce sul punteggio della sezione che
trovi nel Profilo Orientativo Individualizzato (POI). Puoi decidere tu quali autovalutazioni vuoi inserire nell’e-portfolio.',
			'shortDescription' => 'Qui puoi trovare tutte le autovalutazioni relative alle diverse aree che costituiscono il Profilo Orientativo Individualizzato (POI)',
			'slug' => 'autovalutazioni',
			'step' => 1,
			'template' => 'blade',
		]);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Section::where('slug', 'autovalutazioni')->forceDelete();
		Test::where('slug', 'autovalutazioni')->forceDelete();
	}
};

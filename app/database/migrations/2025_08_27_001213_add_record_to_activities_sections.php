<?php

use App\Models\Activities\Section;
use App\Models\Schools\Grade;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('activities_sections', function (Blueprint $table) {
			$table->string('years')->nullable()->change();
		});

		Section::find(22)?->delete();

		$section = Section::create([
			'areaId' => 4,
			'name' => 'POI',
			'slug' => 'poi',
			'description' => 'Qui trovi il tuo profilo orientativo che si aggiorna con il progredire delle tue autovalutazioni',
			'active' => true,
			'isStandard' => false,
			'estimated_duration' => 1
		]);

		$grades = Grade::where('absolute_number', '>', 1)->get();

		$grades->each(function (Grade $grade) use ($section) {
			$grade->sections()->attach($section->id);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		$poi = Section::where('slug', 'poi')->first();
		$grades = Grade::where('absolute_number', '>', 1)->get();

		$grades->each(function (Grade $grade) use ($poi) {
			$grade->sections()->detach($poi->id);
		});

		$poi->delete();
		Section::withTrashed()->find(22)->restore();
	}
};

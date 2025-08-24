<?php

use App\Models\Activities\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::table('activities_sections', function (Blueprint $table) {
			$table->timestamps();
		});

		Section::find(1)->update([
			'evaluation_test_id' => 31,
			'result_label' => 'Stile prevalente'
		]);

		Section::find(3)->update([
			'evaluation_test_id' => 50,
			'result_label' => 'Livello di resilienza'
		]);

		Section::find(4)->update([
			'evaluation_test_id' => 15,
			'result_label' => 'Autostima media'
		]);

		Section::find(5)->update([
			'evaluation_test_id' => 94,
			'result_label' => null
		]);

		Section::find(6)->update([
			'evaluation_test_id' => 48,
			'result_label' => 'Stile prevalente'
		]);

		Section::find(7)->update([
			'evaluation_test_id' => 20,
			'result_label' => 'Area d\'interesse prevalente'
		]);

		Section::find(8)->update([
			'evaluation_test_id' => 46,
			'result_label' => 'Temperamento più pronunciato'
		]);

		Section::find(9)->update([
			'evaluation_test_id' => 16,
			'result_label' => null
		]);

		Section::find(10)->update([
			'evaluation_test_id' => 52,
			'result_label' => null
		]);

		Section::find(11)->update([
			'evaluation_test_id' => 27,
			'result_label' => null
		]);

		Section::find(12)->update([
			'evaluation_test_id' => 59,
			'result_label' => null
		]);

		Section::find(14)->update([
			'evaluation_test_id' => 61,
			'result_label' => null
		]);

		Section::find(17)->update([
			'evaluation_test_id' => 81,
			'result_label' => null
		]);

		Section::find(24)->update([
			'evaluation_test_id' => 92,
			'result_label' => 'Area d\'interesse prevalente'
		]);

		Section::find(25)->update([
			'evaluation_test_id' => null,
			'result_label' => null
		]);

		Section::find(26)->update([
			'evaluation_test_id' => null,
			'result_label' => null
		]);

		Section::find(27)->update([
			'evaluation_test_id' => 116,
			'result_label' => 'Emozioni prevalenti'
		]);

		Section::find(28)->update([
			'evaluation_test_id' => 109,
			'result_label' => 'Stile prevalenti'
		]);

		Section::find(29)->update([
			'evaluation_test_id' => 107,
			'result_label' => 'Autostima media'
		]);

		Section::find(30)->update([
			'evaluation_test_id' => 119,
			'result_label' => null
		]);

		Section::find(31)->update([
			'evaluation_test_id' => 117,
			'result_label' => null
		]);

		Section::find(32)->update([
			'evaluation_test_id' => 126,
			'result_label' => null
		]);

		Section::find(33)->update([
			'evaluation_test_id' => 137,
			'result_label' => null
		]);

		Section::find(39)->update([
			'evaluation_test_id' => 130,
			'result_label' => null
		]);

		Section::find(40)->update([
			'evaluation_test_id' => 132,
			'result_label' => null
		]);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('activities_sections', function (Blueprint $table) {
			$table->dropTimestamps();
		});
	}
};

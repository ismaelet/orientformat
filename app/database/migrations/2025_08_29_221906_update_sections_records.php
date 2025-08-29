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

		Section::find(13)->update([
			'evaluation_test_id' => 98,
			'result_label' => null
		]);

		Section::find(15)->update([
			'evaluation_test_id' => 35,
			'result_label' => null
		]);

		Section::find(18)->update([
			'evaluation_test_id' => null,
			'result_label' => null,
		]);

		Section::find(36)->update([
			'evaluation_test_id' => 111,
			'result_label' => 'Stile principale',
		]);

		Section::find(37)->update([
			'evaluation_test_id' => 113,
			'result_label' => 'Stile principale',
		]);

		Section::find(38)->update([
			'evaluation_test_id' => 162,
			'result_label' => null,
		]);

		Section::find(41)->update([
			'evaluation_test_id' => 146,
			'result_label' => 'Tasso di autostima',
		]);

		Section::find(42)->update([
			'evaluation_test_id' => 147,
			'result_label' => null,
		]);

		Section::find(45)->update([
			'evaluation_test_id' => 151,
			'result_label' => 'Interesse prevalente',
		]);

		Section::find(47)->update([
			'evaluation_test_id' => 154,
			'result_label' => null,
		]);

		Section::find(48)->update([
			'evaluation_test_id' => 157,
			'result_label' => null,
		]);

		Section::find(49)->update([
			'evaluation_test_id' => 160,
			'result_label' => null,
		]);

		Section::find(50)->update([
			'evaluation_test_id' => 165,
			'result_label' => null,
		]);

		Section::find(51)->update([
			'evaluation_test_id' => 170,
			'result_label' => null,
		]);

		Section::find(53)->update([
			'evaluation_test_id' => 199,
			'result_label' => null,
		]);

		Section::find(55)->update([
			'evaluation_test_id' => 180,
			'result_label' => null,
		]);

		Section::find(56)->update([
			'evaluation_test_id' => 186,
			'result_label' => null,
		]);

		Section::find(57)->update([
			'evaluation_test_id' => 195,
			'result_label' => null,
		]);

		Section::find(58)->update([
			'evaluation_test_id' => 208,
			'result_label' => 'Emozioni prevalenti',
		]);
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		//
	}
};

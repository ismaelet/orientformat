<?php

use App\Models\Schools\SchoolClass;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		$endedClasses = SchoolClass::where('grade', '>', 5)->get();

		$endedClasses->each(function ($class) {
			$class->update([
				'ended' => 1,
				'grade' => 5,
			]);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		//
	}
};

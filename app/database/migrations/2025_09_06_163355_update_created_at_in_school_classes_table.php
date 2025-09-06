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
		$schoolClasses = SchoolClass::where('created_at', null)->get();

		foreach ($schoolClasses as $class) {
			$class->created_at = $class->time;
			$class->save();
		}
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
	}
};

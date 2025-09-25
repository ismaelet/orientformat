<?php

use App\Helpers\ClassHelper;
use App\Models\Schools\SchoolClass;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void {
		DB::table('school_classes')->update(['ended' => false]);

		$classes = SchoolClass::all();

		foreach ($classes as $class) {
			ClassHelper::updateToNewYear($class);
		}
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
	}
};

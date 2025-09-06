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
		Schema::table('school_classes', function (Blueprint $table) {
			$table->string('name')->after('id');
		});

		$classes = SchoolClass::all();

		foreach ($classes as $class) {
			$class->name = $class->genName();
			$class->save();
		}
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::table('school_classes', function (Blueprint $table) {
			$table->dropColumn('name');
		});
	}
};

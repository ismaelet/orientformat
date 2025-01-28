<?php

use App\Models\Admin\AdminSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdminSections extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		AdminSection::where('name', 'Lista degli studenti')->update(['resource' => 'students', 'action' => 'index']);
		AdminSection::where('name', 'Modifica uno studente')->update(['resource' => 'students', 'action' => 'edit']);
		AdminSection::where('name', 'Lista delle classi')->update(['resource' => 'school_classes', 'action' => 'index']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
	}
}

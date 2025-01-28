<?php

use App\Models\Notification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotification extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Notification::create([
			'text' => 'Le classi che hanno terminato il percorso sono ora nascoste. Per visualizzarle, clicca su <strong>Mostra le classi che hanno terminato il percorso</strong> nella sezione "Le mie classi".',
		]);
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

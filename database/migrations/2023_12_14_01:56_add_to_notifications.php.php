<?php

use app\Models\Helpers\Notification;
use App\Models\Reviews\ReviewQuestion;

return new class {

	/**
	 * Run the migration
	 */
	public function up(): void {
		Notification::add(
			['text' => 'I risultati dei questionari iniziali e finali sono nuovamente disponibili. È possibile consultarli accedendo al pannello della classe e selezionando dal menu a sinistra <strong>Studenti > Progresso degli studenti</strong>. Compariranno come primi elementi nella pagina dei risultati.']
		);

		Notification::add(
			['text' => 'I principali grafici dei risultati medi della classe sono nuovamente disponibili. È possibile consultarli accedendo al pannello della classe e selezionando dal menu a sinistra <strong>Classe > Progresso della classe</strong>.']
		);
	}

	/**
	 * Reverse the migration
	 */
	public function down(): void {
	}
};

<?php

use app\Models\Helpers\Notification;

Notification::createTable(
	[
		'id INT(11) AUTO_INCREMENT PRIMARY KEY',
		'text VARCHAR(1024)',
		'time TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
	]
);

Notification::add(
	['text' => 'In questo pannello puoi trovare avvisi, notifiche e informazioni sugli ultimi aggiornamenti apportati alla piattaforma']
);

Notification::add(
	[
		'text' => 'Abbiamo deciso, raccogliendo anche sollecitazioni da parte di qualche docente, di utilizzare i questionari iniziali e finali, parzialmente modificati, in questo modo:<br>
		&middot; Alle classi di prima e seconda media non verrà più proposto nessun questionario all\'accesso
		&middot; Alle classi di terza media verrà richiesto, all\'accesso, la compilazione del questionario iniziale
		&middot; Per tutti, rimane l\'invito a compilare il questionario finale, prima del Consiglio orientativo'
	]
);

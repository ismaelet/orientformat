<?php

use app\Models\Helpers\Notification;

(new Notification(2))->post(
	[
		'text' => 'Abbiamo deciso, raccogliendo anche sollecitazioni da parte di qualche docente, di utilizzare i <strong>questionari iniziali e finali</strong>, parzialmente modificati, in questo modo:

		&middot; Alle classi di <strong>prima e seconda media</strong> non verrà più proposto nessun questionario all\'accesso
		&middot; Alle classi di <strong>terza media</strong> verrà richiesto, all\'accesso, la compilazione del questionario iniziale
		&middot; Per tutti, rimane l\'invito a compilare il <strong>questionario finale</strong>, prima del Consiglio orientativo'
	]
);

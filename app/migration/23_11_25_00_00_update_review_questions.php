<?php

use app\Models\Reviews\ReviewQuestion;

(new ReviewQuestion(14))->post(
	[
		'text' => 'Identità di genere',
		'`rows`' => 'Maschio,Femmina',
	]
);

(new ReviewQuestion(2))->post(
	[
		'`rows`' => 'Liceo,Istituto Tecnico,Istruzione e Formazione Professionale,Istituto Professionale',
	]
);

(new ReviewQuestion(8))->post(
	[
		'`rows`' => 'Liceo,Istituto Tecnico,Istruzione e Formazione Professionale,Istituto Professionale',
	]
);

(new ReviewQuestion(9))->post(
	[
		'`rows`' => 'Liceo,Istituto Tecnico,Istruzione e Formazione Professionale,Istituto Professionale',
	]
);

(new ReviewQuestion(17))->post(
	[
		'gridHeader' => 'Genitore 1,Genitore 2',
	]
);

(new ReviewQuestion(12))->post(
	[
		'`rows`' => 'Genitore 1,Genitore 2,I miei fratelli/sorelle,Altri parenti (per esempio nonni o zii),I miei amici,Uno o due professori con chiacchierate informali,Persone che conosco del mio paese o quartiere,Conoscenti che frequentano la scuola che mi interessa,Il consiglio di classe con il consiglio orientativo',
	]
);

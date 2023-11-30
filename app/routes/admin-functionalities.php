<?php

Route::add('/send-mass-email', function () {

	$emails = [];
	// all teacher with an active 3rd grade in the school year 2022/2033
	//$teachers = DB::select('referentId FROM classes WHERE grade=3 AND year=2022');

	// all teacher with an active 3rd grade in the school year 2022/2033 and no students that completed the final survery
	$teachers = DB::select('referentId FROM classes WHERE grade=3 AND year=2022');

	// generate email content
	$mailText = '
<h1 style="text-align: center; padding-bottom: 16px; font-weight: 600;">Consigli orientativi e questionario finale</h1><br><br>
Gentile Insegnante,<br><br>

sono trascorsi circa quattro mesi dai webinar di presentazione e dal lancio della piattaforma OrientFormat per l\'a.s. 2022/2023.
A conclusione del percorso delle le classi terze, vi ricordiamo di:<br><br>

- far compilare il secondo questionario agli studenti;<br>
- inserire il consiglio orientativo di ogni studente nella vostra area riservata all’interno della funzionalità “Studenti > Consigli orientativi”.<br><br>

Il questionario sarà visibile agli studenti solo quando lo attiverete attraverso un’apposita funzionalità.<strong><a href="https://www.iprase.tn.it/orientamento/help?category=2&topic=10#topic10" target="_blank">Clicca qui</a></strong> per vedere le istruzioni dettagliate su come abilitare il questionario.<br><br>

Il questionario può essere compilato anche da casa e richiede non più di 10 minuti. Vi chiediamo di monitorare l’avvenuta compilazione sempre attraverso la vostra area personale.<br><br>

Queste ultime due informazioni – questionario e consiglio orientativo – sono importanti perché consentono di visualizzare, a conclusione del percorso, l\'incertezza della scelta e il grado di accordo tra consiglio orientativo e scelta dello studente.
Chiediamo anche a chi non ha avuto modo di utilizzare la piattaforma di far compilare il questionario e di inserire il consiglio orientativo una volta formulato.<br><br>

Vi ringraziamo per la collaborazione e rimaniamo a completa disposizione per eventuali chiarimenti.</p>';

	$emailContent = Mail::prepareBody($mailText);

	// send email
	$emailData = [
		'debugger' => false,
		'from-address' => 'no-reply@iprase.tn.it',
		'from-name' => sysData('name'),
		'to' => 'ismaele.tuffanelli@gmail.com',
		'subject' => 'Consigli orientativi e questionario finale',
		'text' => $emailContent,
		'secure' => 'tls',
		'port' => 587,
	];

	while ($teacherRow = $teachers->fetch_assoc()) {
		$teacher = new Teacher($teacherRow['referentId']);

		if ($teacher->email && !in_array($teacher->email, $emails)) {
			$emails[] = $teacher->email;

			echo $teacher->email . '<br>';

			$emailData['to'] = $teacher->email;

			//Mail::send($emailData);
		}
	}
});

Route::add('/list-active-teachers', function () {
	$emails = [];

	$teachers = DB::select('
		referentId
		FROM classes
			INNER JOIN users ON classes.referentId = users.id
		WHERE year=2022
		ORDER BY lastname ASC, firstname ASC
	');

	while ($teacherRow = $teachers->fetch_assoc()) {
		$teacher = new Teacher($teacherRow['referentId']);

		if ($teacher->email && !in_array($teacher->email, ['prova@docente.com']) && !in_array($teacher->email, $emails)) {
			$emails[] = $teacher->email;

			echo $teacher->fullNameInv . ' - ' . $teacher->email . '<br>';
		}
	}
});

Route::add('/list-active-schools', function () {
	$schools = DB::select('
		id
		FROM schools
		WHERE id IN (SELECT school FROM classes WHERE year > 2021)
		ORDER BY name ASC
	');

	while ($schoolRow = $schools->fetch_assoc()) {
		$school = new School($schoolRow['id']);

		if (!in_array($school->name, ['Istituto Di Prova'])) {
			echo $school->name . '<br>';
		}
	}
});

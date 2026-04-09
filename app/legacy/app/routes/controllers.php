<?php

/**
 * Email controllers
 */

use App\Legacy\EmailInterface;

// Send reminder email
\App\Legacy\LegacyRoute::add('/emails/reminder', function () {
    if (!isset($_SESSION['email-sent-reminder'])) {
        $_SESSION['email-sent-reminder'] = true;
        $emails = [];
        $schoolClasses = \App\Legacy\LegacyDB::select('id FROM school_classes WHERE year = 2023 AND grade = 3');

        while ($schoolClass = $schoolClasses->fetch_assoc()) {
            $users = \App\Legacy\LegacyDB::select('email FROM users INNER JOIN teachers ON users.id = teachers.userId WHERE FIND_IN_SET(?, classes)', [$schoolClass['id']]);

            while ($user = $users->fetch_assoc()) {
                $emails[] = $user['email'];
            }
        }

        // $emails = ['ismaele.tuffanelli@gmail.com'];

        foreach ($emails as $email) {
            $subject = 'Consiglio Orientativo OrientFormat';
            $message = "
			<h1 style='text-align: center;'>Consiglio Orientativo</h1><br>
			<p>Buongiorno,<br>
			nel caso non lo si abbia ancora fatto, ricordiamo che è possibile assegnare fino a tre consigli orientativi ad ogni studente/studentessa delle classi terze.<br><br>
			
			Per farlo è molto semplice: una volta effettuato l'accesso, basta aprire il pannello gestionale della classe e nel menù a sinistra selezionare <strong>Studenti > Consigli orientativi</strong>. Nella pagina specifica per ogni alunno/a sarà presente un piccolo pannello di riepilogo con i dati principali che possono aiutare nella scelta del consiglio orientativo.<br><br>

			Ci preme segnalare che la registrazione del consiglio orientativo nel sito OrientFormat rende disponibile per tutta la comunità dei partecipanti un riscontro più preciso sull'efficacia della sperimentazione in atto.<br><br>
			
			Il team di Orient Format.</p>";

            $emailContent = EmailInterface::generateEmailContent($message);

            // send email
            $emailData = [
                'debug' => false,
                'from-address' => 'no-reply@iprase.tn.it',
                'from-name' => sysData('name'),
                'to' => $email,
                'subject' => $subject,
                'text' => $emailContent,
            ];

            // EmailInterface::sendEmail($emailData);
        }
    }
});

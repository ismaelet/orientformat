<?php

$sent = false;
$error = false;

/*
* Form handling
*/
if (isset($_POST['submit'])) {
	$sent = true;

	// generate email content
	$mailText = '<h1 style="text-align: center; padding-bottom: 16px; font-weight: 600;">Richiesta informazioni</h1>
	<p>Sei stato contattato da <strong>' . user()->fullName . '</strong> (<a href="mailto:' . user()->email . '">' . user()->email . '</a>) con la seguente domanda:<br><br>' . $_POST['text'] . '</p>';

	$emailContent = EmailInterface::generateEmailContent($mailText);

	// send email
	$emailData = [
		'debug' => false,
		'from-address' => 'no-reply@iprase.tn.it',
		'from-name' => sysData('name'),
		'to' => 'ismaele.tuffanelli@gmail.com',
		'reply-address' => user()->email,
		'reply-name' => user()->fullName,
		'subject' => 'Richiesta informazioni',
		'text' => $emailContent,
		'secure' => 'tls',
		'port' => 587,
	];

	EmailInterface::sendEmail($emailData);
}

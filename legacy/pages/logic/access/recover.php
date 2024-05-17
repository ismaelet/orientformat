<?php

$submitted = false;
$found = false;

if (isset($_POST['submit'])) {
	$submitted = true;
	$email = $_POST['email'];

	if ($userId = \System\Classes\DBOld::find('id FROM users WHERE email = ?', [$email])) {
		$found = true;
		$userToRecover = new User($userId);

		// generate reset security code
		if (!$resetCode = \System\Classes\DBOld::find('security FROM user_resets WHERE userId = ?', [$userToRecover->id])) {
			$resetCode = (string) random_string();
			\System\Classes\DBOld::add('user_resets (userId, security)', [$userToRecover->id, $resetCode]);
		}

		// generare reset endpoint
		$resetEndpoint = \System\Classes\ConfigOld::getInstance()->domain . '/reset?id=' . $userToRecover->id . '&security=' . $resetCode;

		// generate email content
		$mailText = '<h1 style="text-align: center; padding-bottom: 32px; font-weight: 600;">Recupero dati</h1>
		<p>L\'username associato a questo indirizzo email è il seguente, potrai usare l\'username o l\'indirizzo ' . $email . ' per accedere:<br>
		<span class="no-link" style="font-size: 1.5em; font-weight: bold;">' . $userToRecover->username . '</span><br><br>Per resettare la tua password puoi andare a questo link:<br><a href="' . $resetEndpoint . '">' . $resetEndpoint . '</a></p>';

		$emailContent = EmailInterface::generateEmailContent($mailText);

		// send email
		$emailData = [
			'debugger' => false,
			'from-address' => 'no-reply@iprase.tn.it',
			'from-name' => \System\Classes\ConfigOld::getInstance()->name,
			'to' => $email,
			'subject' => 'Recupero dati di accesso',
			'text' => $emailContent,
			'secure' => 'tls',
			'port' => 587,
		];

		EmailInterface::sendEmail($emailData);
	}
}

<?php

$submitted = false;
$found = false;

if (isset($_POST['submit'])) {
	$submitted = true;
	$email = $_POST['email'];

	if ($userId = \Legacy\System\Classes\LegacyDB::find('id FROM users WHERE email = ?', [$email])) {
		$found = true;
		$userToRecover = new \Legacy\System\Classes\User($userId);

		// generate reset security code
		if (!$resetCode = \Legacy\System\Classes\LegacyDB::find('security FROM user_resets WHERE userId = ?', [$userToRecover->id])) {
			$resetCode = (string) random_string();
			\Legacy\System\Classes\LegacyDB::add('user_resets (userId, security)', [$userToRecover->id, $resetCode]);
		}

		// generare reset endpoint
		$resetEndpoint = \Legacy\System\Classes\LegacyConfig::getInstance()->domain . '/reset?id=' . $userToRecover->id . '&security=' . $resetCode;

		// generate email content
		$mailText = '<h1 style="text-align: center; padding-bottom: 32px; font-weight: 600;">Recupero dati</h1>
		<p>L\'username associato a questo indirizzo email è il seguente, potrai usare l\'username o l\'indirizzo ' . $email . ' per accedere:<br>
		<span class="no-link" style="font-size: 1.5em; font-weight: bold;">' . $userToRecover->username . '</span><br><br>Per resettare la tua password puoi andare a questo link:<br><a href="' . $resetEndpoint . '">' . $resetEndpoint . '</a></p>';

		$emailContent = EmailInterface::generateEmailContent($mailText);

		// send email
		$emailData = [
			'debugger' => false,
			'from-address' => 'no-reply@iprase.tn.it',
			'from-name' => \Legacy\System\Classes\LegacyConfig::getInstance()->name,
			'to' => $email,
			'subject' => 'Recupero dati di accesso',
			'text' => $emailContent,
			'secure' => 'tls',
			'port' => 587,
		];

		EmailInterface::sendEmail($emailData);
	}
}

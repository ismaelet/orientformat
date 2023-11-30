<?php

$submitted = false;
$found = false;

if (isset($_POST['submit'])) {
	$submitted = true;
	$email = $_POST['email'];

	if ($userId = DB::find('id FROM users WHERE email=?', [$email])) {
		$found = true;
		$userToRecover = new User($userId);

		// generate reset security code
		if (!$resetCode = DB::find('security FROM user_resets WHERE userId=?', [$userToRecover->id])) {
			$resetCode = (string) random_string();
			DB::add('user_resets (userId, security)', [$userToRecover->id, $resetCode]);
		}

		// generare reset endpoint
		$resetEndpoint = __CLIENT_URL__ . '/reset?id=' . $userToRecover->id . '&security=' . $resetCode;

		// generate email content
		$mailText = '<h1 style="text-align: center; padding-bottom: 16px; font-weight: 600;">Recupero dati</h1>
		<p>L\'username associato a questo indirizzo email è:<br>
		<span class="no-link" style="font-size: 1.5em; font-weight: bold;">' . $userToRecover->username . '</span><br><br>Per resettare la tua password puoi andare a questo link:<br><a href="' . $resetEndpoint . '">' . $resetEndpoint . '</a></p>';

		$emailContent = Email::prepareBody($mailText);

		// send email
		$emailData = [
			'debugger' => false,
			'from-address' => sysConfig('mail-username'),
			'from-name' => sysConfig('name'),
			'to' => $email,
			'subject' => 'Recupero dati di accesso',
			'text' => $emailContent,
		];

		Email::send($emailData);
	}
}

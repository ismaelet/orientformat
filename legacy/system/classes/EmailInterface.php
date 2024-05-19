<?php

namespace Legacy\System\Classes;

/**
 * Requires: phpmailer/phpmailer
 */

/**
 * Parameters:
 *	? (bool) debug: to show a log
 *	? (string) host: something like email.domain.com, required but it's taken from the config file if not defined
 *	? (string) email-username: required but it's taken from the config file if not defined
 *	? (string) email-passsword: required but it's taken from the config file if not defined
 *	? (string) secure: usually is not defined and it's set automatically to ssl
 *	? (string) from-address: if not defined it's the email-username
 *	? (string) from-name: can be set to have a proper sender name instead of just an email address
 *	? (string) reply-address: can be set to have the reciver reply to a different email address than the from-address
 *	? (string) reply-name: can be set to have a more complete reply-address
 *	? (array) cc: additional receivers
 *	(string) to: receiver's email address
 *	(string) subject: the subject of the email
 *	(string) text: the body of the email
 */

use PHPMailer\PHPMailer\PHPMailer;

class EmailInterface {

	// send the email
	static function sendEmail(array $emailData) {
		$config = \Legacy\System\Classes\LegacyConfig::getInstance();
		$email = new PHPMailer();

		// email setup
		$emailData['from-address'] = $emailData['from-address'] ?? $config->emailUsername;
		$emailData['from-name'] = $emailData['from-name'] ?? $config->name;

		// SMTP setup
		$email->CharSet = 'UTF-8';
		$email->SMTPDebug = !empty($emailData['debug']);
		$email->isSMTP();
		$email->Host = $emailData['host'] ?? $config->emailHost;
		$email->SMTPAuth = true;
		$email->Username = $emailData['username'] ?? $config->emailUsername;
		$email->Password = $emailData['password'] ?? $config->emailPasssword;
		$email->SMTPSecure = $emailData['secure'] ?? 'ssl';
		$email->Port = $emailData['port'] ?? 465;
		$email->setFrom($emailData['from-address'], $emailData['from-name']);

		// recipient
		$email->addAddress($emailData['to']);

		if (isset($emailData['cc'])) {
			$ccs = (array) $emailData['cc'];

			foreach ($ccs as $cc) $email->AddCC($cc);
		}

		// reply
		if (isset($emailData['reply-address']) && isset($emailData['reply-name'])) $email->addReplyTo($emailData['reply-address'], $emailData['reply-name']);
		else if (isset($emailData['reply-address'])) $email->addReplyTo($emailData['reply-address']);

		// content
		$email->isHTML(true);
		$email->Subject = $emailData['subject'];
		$email->Body = $emailData['text'];

		// send
		$email->Send();
	}

	// prepare a standard email body
	static function generateEmailContent($emailBody) {
		$config = \Legacy\System\Classes\LegacyConfig::getInstance();

		$logo = $config->logoAbsoluteImage;

		$instagramLink = $config->contactInstagramLink ? '
			<tr>
				<td style="text-align: center">
					<a class="no-link" href="' . $config->contactInstagramLink . '">
						<img
							style="display: inline-block; vertical-align: middle; margin-right: 5px; max-width: 18px; max-height: 18px;"
							src="' . $config->websiteUrl . '/system/assets/icons/contacts/instagram-32.png"
							alt=""
						/>
						<p style="width: 103px; display: inline-block; vertical-align: middle; font-size: 12px; text-align: left">' . $config->contactInstagram . '</p>
					</a>
				</td>
			</tr>' : '';

		$facebookLink = $config->contactFacebookLink ? '
			<tr>
				<td style="text-align: center">
					<a class="no-link" href="' . $config->contactFacebookLink . '">
						<img
							style="display: inline-block; vertical-align: middle; margin-right: 5px; max-width: 18px; max-height: 18px;"
							src="' .  $config->websiteUrl . '/system/assets/icons/contacts/facebook-32.png"
							alt=""
						/>
						<p style="width: 103px; display: inline-block; vertical-align: middle; font-size: 12px; text-align: left">' . $config->contactFacebook . '</p>
					</a>
				</td>
			</tr>' : '';

		$emailLink = $config->contactEmailLink ? '
				<tr>
					<td style="text-align: center">
						<a class="no-link" href="' . $config->contactEmailLink . '">
							<img
								style="display: inline-block; vertical-align: middle; margin-right: 5px; max-width: 18px; max-height: 18px;"
								src="' .  $config->websiteUrl . '/system/assets/icons/contacts/email-32.png"
								alt=""
							/>
							<p style="width: 103px; display: inline-block; vertical-align: middle; font-size: 12px; text-align: left">' . $config->contactEmail . '</p>
						</a>
					</td>
				</tr>' : '';

		$emailTemplate = file_get_contents(server_path('/app/templates/assets/template-emails/default-framework.html'));

		$emailContent = str_replace('{{ logo }}', $logo, $emailTemplate);
		$emailContent = str_replace('{{ content }}', $emailBody, $emailContent);
		$emailContent = str_replace('{{ instagram-link }}', $instagramLink, $emailContent);
		$emailContent = str_replace('{{ facebook-link }}', $facebookLink, $emailContent);
		$emailContent = str_replace('{{ email-link }}', $emailLink, $emailContent);

		return $emailContent;
	}
}

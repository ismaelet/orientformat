<?php

namespace App\Http\Controllers;

use App\Legacy\EmailInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpController extends Controller {
	public function index() {
		ob_start();

		require app_path('Http') . '/legacy.php';

		$output = ob_get_clean();

		return $output;
	}

	/**
	 * Show the form to open a support ticket
	 */
	public function openTicket() {
		$user = Auth::user();

		return view('help.open-ticket', [
			'title' => 'Contattaci',
			'user' => $user,
		]);
	}

	/**
	 * Store a new support ticket
	 */
	public function storeTicket(Request $request) {
		$user = Auth::user();

		$mailText = '<h1 style="text-align: center; padding-bottom: 16px; font-weight: 600;">Richiesta informazioni</h1>
	<p>Sei stato contattato da <strong>' . $request->input('name') . '</strong> ' . ($user ? '' : '(utente non registrato)') . ' (<a href="mailto:' . $request->input('email') . '">' . $request->input('email') . '</a>) con la seguente domanda:<br><br>' . $request->input('message') . '</p>';

		$emailContent = EmailInterface::generateEmailContent($mailText);

		// send email
		$emailData = [
			'debug' => false,
			'from-address' => 'no-reply@iprase.tn.it',
			'from-name' => 'OrientFormat',
			'to' => 'ismaele.tuffanelli@gmail.com',
			'reply-address' => $request->input('email'),
			'reply-name' => $request->input('name'),
			'subject' => 'Richiesta informazioni',
			'text' => $emailContent,
			'secure' => 'tls',
			'port' => 587,
		];

		EmailInterface::sendEmail($emailData);

		return redirect()->route('help.ticket.open')->with('success', 'Richiesta inviata con successo');
	}
}

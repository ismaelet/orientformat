<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\GenericMail;
use App\Models\User;
use App\Models\User\PasswordResetToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class RecoverController extends Controller
{
    /**
     * Render the recover page
     */
    public function index()
    {

        return view('auth.recover')
            ->with('location', 'recover')
            ->with('title', 'Recupero accesso');
    }

    /**
     * Process the request
     */
    public function store(Request $request)
    {

        // Validation
        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email:rfc',
                'max:255',
                'regex:/^[A-Za-z0-9][A-Za-z0-9._%+\-]*@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}$/',
            ],
        ], [
            'email.required' => 'Inserisci un indirizzo email.',
            'email.email' => 'L\'indirizzo email inserito non è valido.',
            'email.regex' => 'L\'indirizzo email inserito non è valido.',
        ]);

        // Process the request
        $email = trim($validated['email']);
        $user = User::where('email', $email)->first();

        if ($user) {
            // Generate reset security code
            $passwordReset = PasswordResetToken::where('email', $user->email)->first();

            if ($passwordReset) {
                $token = $passwordReset->token;
            } else {
                $token = Str::random(50);

                PasswordResetToken::create(
                    [
                        'email' => $user->email,
                        'token' => $token,
                    ]
                );
            }

            // Generare the recovery endpoint
            $resetEndpoint = route('auth.reset', ['email' => $user->email, 'token' => $token]);

            // Generate the email
            $subject = 'Recupero dati di accesso';
            $content = '
					<h2 style="text-align: center; padding-bottom: 32px; font-weight: 600;">Recupero dati</h2>
					<p>
						L\'indirizzo email associato al tuo account, necessario per accedere, è:<br>'.$email.'.<br><br>
						Per resettare la tua password puoi usare questo link:<br><a href="'.$resetEndpoint.'">'.$resetEndpoint.'</a>
					</p>';

            $mail = new GenericMail($subject, $content);

            // Send the email

            try {
                Mail::to($user->email)->send($mail);
            } catch (TransportExceptionInterface $e) {
                return redirect()->route('auth.recover')->with([
                    'title' => 'Recupero accesso',
                    'email' => $email,
                    'mail_error' => 'Non è stato possibile inviare l\'email. Controlla che l\'indirizzo inserito sia valido.',
                ]);
            }
        }

        return redirect()->route('auth.recover')
            ->with([
                'title' => 'Recupero accesso',
                'submitted' => true,
                'email' => $email,
                'not_found' => ! $user,
            ]);
    }
}

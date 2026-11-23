<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
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
        $email = strtolower(trim($validated['email']));

        try {
            Password::broker()->sendResetLink(['email' => $email]);
        } catch (TransportExceptionInterface $exception) {
            report($exception);
        }

        return redirect()->route('auth.recover')
            ->with([
                'title' => 'Recupero accesso',
                'submitted' => true,
                'email' => $email,
            ]);
    }
}

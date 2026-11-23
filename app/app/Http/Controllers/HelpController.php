<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Services\LegacyPageRenderer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HelpController extends Controller
{
    /**
     * Display the support page
     */
    public function index(LegacyPageRenderer $renderer): Response
    {
        return $renderer->render(page: 'support', title: 'Supporto');
    }

    /**
     * Show the form to open a support ticket
     */
    public function openTicket()
    {
        $user = Auth::user();

        return view('help.open-ticket', [
            'title' => 'Contattaci',
            'user' => $user,
        ]);
    }

    /**
     * Store a new support ticket
     */
    public function storeTicket(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'message' => ['required', 'string', 'max:500'],
        ]);

        $user = Auth::user();
        if ($user) {
            $validated['name'] = $user->full_name;
            $validated['email'] = $user->email;
        }

        $isAdministrator = is_administrator();
        $isTeacher = is_teacher();
        $isStudent = is_student();

        $position = match (true) {
            $isAdministrator => 'referente per l\'orientamento',
            $isTeacher => 'docente',
            $isStudent => 'studente',
            default => 'utente non registrato/a',
        };

        Mail::to('ismaele.tuffanelli@gmail.com')
            ->send(new ContactMail(
                email: $validated['email'],
                name: $validated['name'],
                message: $validated['message'],
                position: $position,
            ));

        return redirect()->route('help.ticket.open')->with('success', 'Richiesta inviata con successo');
    }
}

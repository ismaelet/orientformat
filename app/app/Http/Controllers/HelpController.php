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
                email: $request->email,
                name: $request->name,
                message: $request->message,
                position: $position,
            ));

        return redirect()->route('help.ticket.open')->with('success', 'Richiesta inviata con successo');
    }
}

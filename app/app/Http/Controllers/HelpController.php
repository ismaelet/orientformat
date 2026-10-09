<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

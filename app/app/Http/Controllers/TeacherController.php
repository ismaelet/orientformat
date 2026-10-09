<?php

namespace App\Http\Controllers;

use App\Models\Class\InviteRequest;
use App\Models\Class\StudentJoinRequest;
use App\Models\Class\TeacherJoinRequest;
use App\Models\Notification;
use App\Models\Schools\School;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class TeacherController extends Controller {

    /**
     * Display the teacher dashboard
     */
    public function index(): View {
        $teacher = teacher()->load('school', 'school_classes', 'school_classes.school');
        $tutoringClasses = SchoolClass::where('referentId', $teacher->id)->get();

        $teacherJoinRequests = TeacherJoinRequest::where('referent_id', $teacher->id)
            ->with('requesting_teacher', 'class', 'requesting_teacher.user')
            ->get();

        $studentJoinRequests = StudentJoinRequest::whereIn('class_id', $tutoringClasses->pluck('id'))
            ->with('requesting_student', 'class', 'requesting_student.user')
            ->get();

        $inviteRequests = InviteRequest::where('invited_teacher_id', $teacher->id)
            ->with('class', 'inviting_teacher', 'inviting_teacher.user')
            ->get();

        $functionalities = [
            [
                'title' => 'Simulazione studente',
                'subtitle' => 'Per esplorare le attività',
                'desc' => 'Qui è possibile vedere quali saranno le attività proposte ai tuoi studenti e testare come funzionano.',
                'url' => client_url('/teacher/simulation'),
                'slug' => 'simulation'
            ],
            [
                'title' => 'Saperne di più',
                'subtitle' => 'Per approfondire',
                'desc' => 'Qui potrai accedere ad agili schede di approfondimento, arricchite da un Glossario ipertestuale.',
                'url' => client_url('/teacher/know-more'),
                'slug' => 'know-more'
            ],
            [
                'title' => 'Contattaci',
                'subtitle' => 'Per dubbi o chiarimenti',
                'desc' => 'Se hai qualche dubbio sul funzionamento della piattaforma o hai riscontrato qualche difficoltà, puoi contattarci qui.',
                'url' => route('help.ticket.open'),
                'slug' => 'support'
            ],
            [
                'title' => 'Modulistica',
                'subtitle' => 'Documenti e informative',
                'desc' => 'Qui puoi scaricare i moduli della <span class="txt-sbold">Certificazione delle competenze</span>, del <span class="txt-sbold">Consiglio orientativo</span> e altri documenti di supporto.',
                'url' => route('teacher.documents'),
                'slug' => 'documents'
            ],
            [
                'title' => 'Attribuzione Punteggi e Interpretazione dei Risultati',
                'subtitle' => 'Documenti e informative',
                'desc' => 'Qui puoi vedere, attraverso esempi, come vengono attribuiti i punteggi alle autovalutazioni degli studenti.',
                'url' => route('teacher.read.results'),
                'icon' => 'graph'
            ],
            [
                'title' => 'Impostazioni account',
                'subtitle' => '',
                'desc' => 'Qui puoi cambiare i dati associati al tuo account e modificare le impostazioni di base.',
                'url' => route('teacher.settings'),
                'slug' => 'settings'
            ]
        ];

        $notifications = Notification::latest()
            ->limit(10)
            ->get();

        $notices = array_filter([
            'teacher_join_requests' => $teacherJoinRequests->count() ? $teacherJoinRequests : null,
            'student_join_requests' => $studentJoinRequests->count() ? $studentJoinRequests : null,
            'invite_requests' => $inviteRequests->count() ? $inviteRequests : null,
        ]);

        return view('teacher.dashboard', [
            'title' => 'Dashboard Insegnante',
            'teacher' => $teacher,
            'functionalities' => $functionalities,
            'notifications' => $notifications,
            'notices' => $notices,
        ]);
    }

    /**
     * Show the read results page
     */
    public function showReadResults(): View {
        $structure = [
            [
                'title' => 'Valutare i tempi',
                'sections' => [
                    [
                        'title' => "Sviluppare una sezione",
                        "text" => 'Nel prospetto delle attività previste per
ciascun anno vengono indicati dei tempi (ad
esempio 3 ore per Risolvere problemi), che
comprendono: a) la presentazione della
sezione da parte del docente, b) l’attività
richiesta allo studente (autovalutazione ed
eventuale “mettersi alla prova”) e c) la
riflessione in classe sull’attività svolta.',
                    ],
                    [
                        'title' => 'Lo svolgimento dello studente',
                        'text' => 'Nel “Progresso degli studenti” compare il tempo impiegato dallo studente nel completamento di una sezione (ad esempio 7 minuti per Stare attenti). È importante rilevare se c’è uno scarto eccessivo tra il tempo previsto dal docente e il tempo effettivamente impiegato dallo studente, che può segnalare uno svolgimento superficiale e poco meditato, quindi scarsamente significativo.'
                    ]
                ],
            ],
            [
                'title' => 'Interpretare le mappe',
                'sections' => [
                    [
                        'title' => 'Il fattore prevalente',
                        'text' => 'I risultati dei questionari completati dallo
studente sono rappresentati sinteticamente
da mappe o grafici. In Stili cognitivi, ad
esempio, il rapporto tra i vari fattori viene
evidenziato dalla dimensione dei cerchietti:
quello più grande indica lo stile prevalente,
che verrà riportato come risultato nel profilo
di sintesi dello studente.'
                    ],
                    [
                        'title' => 'Fattori equivalenti',
                        'text' => 'Nel caso in cui il punteggio sia lo stesso per fattori diversi (ad esempio punteggio 6 su 6 per due dei cinque fattori del Temperamento), nel quadro delle Autovalutazioni e nel POI verranno riportati entrambi i fattori prevalenti (nell’esempio: “Risposta alle novità” e “Stabilità emotiva”).'
                    ]
                ]
            ],
            [
                'title' => 'Interpretare i risultati',
                'sections' => [
                    [
                        'title' => 'Sezioni senza prove',
                        'text' => 'In alcune sezioni, come ad esempio in
Autostima, si richiede allo studente di
autovalutarsi, ma non viene richiesto di
mettersi alla prova per verificare la fondatezza
dei dati forniti. In questi casi, il dato di sintesi
(nell’esempio l’autostima globale) viene
determinato dalla media tra i vari fattori.'
                    ],
                    [
                        'title' => 'Sezioni con le prove',
                        'text' => 'In diverse sezioni, oltre all’autovalutazione
imperniata su specifici descrittori di competenza, si
chiede allo studente di verificare la fondatezza delle
sue risposte mettendosi alla prova (le prove possono
variare da una a quattro). Ogni prova, che può essere
sospesa e ripresa, ottiene un punteggio, che serve
eventualmente per confermare oppure per indurre a
ripetere l’autovalutazione.<br><br>
Nell’ambiente docente, con la funzione “Progresso
degli studenti”, si possono vedere i risultati del
questionario di autovalutazione e delle singole
prove, oltre al tempo impiegato per sviluppare la
sezione. Se, come nell’esempio relativo a “Stare
attenti”, il tempo complessivo impiegato dallo
studente (7 minuti) si discosta troppo da quello
previsto dal docente, significa che lo studente si è
valutato e messo alla prova troppo superficialmente.'
                    ],
                    [
                        'title' => 'Autovalutazioni e Profilo Orientativo
Individualizzato (POI)',
                        'text' => 'Nel POI confluiscono le autovalutazioni relative
alle competenze che sono oggetto di
certificazione. Il Consiglio di classe sarà così in
grado di valutare quanto la visione che ha di sé lo
studente concordi con quella dei docenti. Il
punteggio di ogni sezione riportato nel POI si
riferisce solo alle autovalutazioni (media tra i
diversi descrittori di competenza) e non ai risultati
delle prove, che servono certamente di stimolo a
ripensare all’autovalutazione, ma possono essere
sostituite da altri dati forniti dai docenti. Nel POI,
che si aggiorna in base ai nuovi dati immessi dallo
studente, risultano sia i risultati delle sezioni
completate sia di quelle non ancora completate.'
                    ]
                ]
            ],
        ];

        return view('teacher.read.results', [
            'title' => 'Attribuzione Punteggi e Interpretazione dei Risultati',
            'structure' => $structure,
        ]);
    }

    public function documentsIndex() {
        return view('teacher.documents', [
            'title' => 'Modulistica',
        ]);
    }

    /**
     * Display the form to attach a school to a teacher
     */
    public function showSchool(): View {
        $schools = School::where('status', true)->orderBy('name')->get();

        return view('teacher.school', [
            'title' => 'Seleziona la tua scuola',
            'schools' => $schools,
        ]);
    }

    /**
     * Update the teacher's school
     */
    public function storeSchool(Request $request): RedirectResponse {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
        ]);

        teacher()->update([
            'school_id' => $request->input('school_id'),
        ]);

        return redirect()
            ->route('home')
            ->with('success', "La scelta dell'istituto è stata aggiornata con successo.");
    }

    /**
     * Display the simulation index
     */
    public function simulationIndex(): Response {
        return \App\Legacy\LegacyView::setPage('teacher/simulation')
            ->show();
    }

    /**
     * Display the settings form
     */
    public function settingsIndex(): View {
        $teacher = teacher();
        $schools = School::where('status', true)->orderBy('name')->get();

        return view('teacher.settings', [
            'title' => 'Impostazioni account',
            'teacher' => $teacher,
            'schools' => $schools,
        ]);
    }

    /**
     * Update the teacher's data
     */
    public function settingsUpdate(Request $request): RedirectResponse {
        $teacher = teacher();
        $user = teacher()->user;

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'school_id' => 'nullable|exists:schools,id',
        ]);

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        $teacher->update([
            'school_id' => $request->input('school_id'),
        ]);

        return redirect()
            ->route('teacher.settings')
            ->with('success', 'Dati aggiornati con successo.');
    }

    /**
     * Update the teacher's password
     */
    public function passwordUpdate(Request $request): RedirectResponse {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find(Auth::id());

        if (!password_verify($request->input('current_password'), $user->password)) {
            return redirect()
                ->route('teacher.settings')
                ->withErrors(['current_password' => 'La password attuale non è corretta.'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return redirect()
            ->route('teacher.settings')
            ->with('passwordSuccess', 'Password aggiornata con successo.');
    }
}

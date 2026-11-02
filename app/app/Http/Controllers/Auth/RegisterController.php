<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * The available email domains for teacher registration
     */
    public const array AVAILABLE_EMAIL_DOMAINS = [
        'arcivescoviletrento.it',
        'artigianelli.tn.it',
        'buonarroti.tn.it',
        'centromoda.tn.it',
        'cfp-upt.it',
        'cfpgveronesi.it',
        'enaip.tn.it',
        'fmach.it',
        'gardascuola.it',
        'iasma.it',
        'iprase.tn.it',
        'istitutodecarneri.it',
        'istitutosacrocuore.it',
        'liceodellearti.tn.it',
        'mileschool.it',
        'operaarmidabarelli.org',
        'pavoniani.tn.it',
        'provincia.tn.it',
        'sacrafamigliatrento.it',
        'scuolasteiner-trento.it',
        'scuolaveronesi.it',
        'scuole.provincia.tn.it',
        'sdbmezzano.it',
        'sdbtrento.it',
        'icfondorevo.it',
    ];

    /**
     * Handle an incoming registration request
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->has('email')) {
            $request->merge([
                'email' => strtolower(trim((string) $request->input('email'))),
            ]);
        }

        $loginType = $request->type;

        return match ($loginType) {
            'student' => $this->storeStudent($request),
            'teacher' => $this->storeTeacher($request),
            default => redirect()->back()
                ->withErrors(['type' => 'Si è verificato un errore. Riprova più tardi o contattaci tramite il supporto.'])
                ->withInput(),
        };
    }

    /**
     * Store a newly created student in storage
     */
    private function storeStudent(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:30|confirmed',
            'email' => 'required|string|email|max:255|unique:users,email',
            'birthdate' => 'required|date|before:'.now()->subYears(10)->format('Y-m-d').'|after:'.now()->subYears(100)->format('Y-m-d'),
            'class' => 'required|string|exists:school_classes,code',
        ]);

        $class = SchoolClass::where('code', $request->class)->first();

        if (Student::where('schoolClassId', $class->id)
            ->whereHas('user', function ($query) use ($request) {
                $query->where('first_name', $request->first_name)
                    ->where('last_name', $request->last_name);
            })->exists()
        ) {
            return redirect()
                ->back()
                ->withErrors(['name' => 'Esiste già un account con questo nome e cognome registrato a questa classe.'])
                ->withInput();
        }

        $hashedPassword = Hash::make($request->password);

        // Create the user
        $user = DB::transaction(function () use ($request, $class, $hashedPassword) {
            $user = $this->createUserSafely([
                'password' => $hashedPassword,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'birthdate' => $request->birthdate ?? null,
            ]);

            // Create the student
            Student::create([
                'id' => $user->id,
                'userId' => $user->id,
                'schoolClassId' => $class->id,
            ]);

            return $user;
        });

        // Sign in the user
        Auth::login($user);

        // Redirect
        return redirect()->route('home');
    }

    /**
     * Store a newly created teacher in storage
     */
    private function storeTeacher(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:30|confirmed',
            'email' => 'required|string|email|max:255|unique:users,email',
        ]);

        $emailDomain = explode('@', $request->email)[1] ?? '';
        $emailDomain = strtolower($emailDomain);

        if (! $emailDomain || ! in_array($emailDomain, self::AVAILABLE_EMAIL_DOMAINS)) {
            return redirect()
                ->back()
                ->withErrors(['email' => 'Indirizzo email non supportato. Per vedere la lista dei domini email supportati dalla piattaforma clicca <a class="font-bold" href="'.route('help', ['category' => 1, 'topic' => 11]).'#topic11">qui</a>'])
                ->withInput();
        }

        $hashedPassword = Hash::make($request->password);

        // Create the user
        $user = DB::transaction(function () use ($request, $hashedPassword) {
            $user = $this->createUserSafely([
                'password' => $hashedPassword,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'birthdate' => $request->birthdate ?? null,
            ]);

            // Create the teacher
            Teacher::create([
                'id' => $user->id,
                'user_id' => $user->id,
            ]);

            return $user;
        });

        // Sign in the user
        Auth::login($user);

        // Redirect
        return redirect()->route('home');
    }

    private function createUserSafely(array $data): User
    {
        try {
            return User::create($data);
        } catch (QueryException $e) {
            $sqlState = $e->errorInfo[0] ?? null;
            $driverCode = $e->errorInfo[1] ?? null;

            if ($sqlState === '23000' && $driverCode === 1062) {
                throw ValidationException::withMessages([
                    'email' => 'Esiste già un account registrato con questa email.',
                ]);
            }

            throw $e;
        }
    }
}

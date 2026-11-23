<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetController extends Controller
{
    /**
     * Render the reset page
     */
    public function index(Request $request, ?string $token = null)
    {
        return view('auth.reset')
            ->with([
                'title' => 'Reset accesso',
                'email' => $request->query('email'),
                'token' => $token ?? $request->query('token'),
            ]);
    }

    /**
     * Process the request
     */
    public function update(Request $request)
    {

        // Validation
        $this->validate($request, [
            'email' => ['required', 'email', 'max:255'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
        ]);

        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');
        $status = Password::broker()->reset($credentials, function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
            ? back()->with('submitted', true)
            : back()->with('error', 'Il link di reset non è valido o è scaduto');
    }
}

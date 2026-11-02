<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Show the student settings page
     */
    public function settingsIndex(): View
    {
        $student = Auth::user()->student;

        return view('student.settings', [
            'student' => $student,
        ]);
    }

    /**
     * Update the student's data
     */
    public function settingsUpdate(Request $request): RedirectResponse
    {
        $student = student();
        $user = $student->user;

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'school_id' => 'nullable|exists:schools,id',
        ]);

        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        $student->update([
            'school_id' => $request->input('school_id'),
        ]);

        return redirect()
            ->route('student.settings')
            ->with('success', 'Dati aggiornati con successo.');
    }

    /**
     * Update the student's password
     */
    public function passwordUpdate(Request $request): RedirectResponse
    {
        $student = student();
        $user = $student->user;

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (! password_verify($request->input('current_password'), $user->password)) {
            return redirect()
                ->route('student.settings')
                ->withErrors(['current_password' => 'La password attuale non è corretta.'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return redirect()
            ->route('student.settings')
            ->with('passwordSuccess', 'Password aggiornata con successo.');
    }
}

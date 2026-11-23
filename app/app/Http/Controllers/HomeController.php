<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Redirects to the appropriate dashboard based on user role
     */
    public function index(): RedirectResponse
    {
        if (Auth::user()->requiresEmailVerification()) {
            return redirect()->route('verification.notice');
        }

        if (Auth::user()->isSuperadmin()) {
            return redirect('/admin');
        }

        if (is_administrator()) {
            return redirect()->route('administrator.dashboard');
        }

        if (is_teacher()) {
            return redirect()->route('teacher.dashboard');
        }

        return redirect()->route('student');
    }
}

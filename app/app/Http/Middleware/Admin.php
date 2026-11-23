<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->requiresEmailVerification()) {
            return redirect()->route('verification.notice');
        }

        // Check if the user is authenticated and is an admin
        if (! auth()->check() || ! auth()->user()->isSuperadmin()) {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UnderContruction
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! (Auth::check() && in_array(Auth::user()->email, config('custom.under_construction_whitelist', [])))) {
            abort(503);
        }

        return $next($request);
    }
}

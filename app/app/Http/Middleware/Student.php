<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Student {

	/**
	 * Handle an incoming request.
	 */
	public function handle(Request $request, Closure $next): Response {
		// Check if the user is authenticated and is an admin
		if (!auth()->check() || !is_student()) {
			return redirect()->route('login');
		}

		return $next($request);
	}
}

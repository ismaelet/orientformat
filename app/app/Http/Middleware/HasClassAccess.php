<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasClassAccess {

	/**
	 * Handle an incoming request.
	 */
	public function handle(Request $request, Closure $next): Response {
		$class = $request->route('class');
		$teacher = teacher();

		if (!$class || !$teacher->hasAccessToClass($class)) {
			return redirect()->route('teacher.dashboard');
		}

		return $next($request);
	}
}

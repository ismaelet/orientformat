<?php

namespace App\Http\Middleware;

use App\Models\Schools\SchoolClass;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasClassAccess {

	/**
	 * Handle an incoming request.
	 */
	public function handle(Request $request, Closure $next): Response {
		$class = $request->route('class');
		$class = is_string($class) ? SchoolClass::find($class) : $class;
		$teacher = teacher();

		if (!$class || !$teacher->hasAccessToClass($class)) {
			return redirect()->route('teacher.dashboard');
		}

		return $next($request);
	}
}

<?php

namespace App\Http\Middleware;

use App\Models\Schools\SchoolClass;
use App\Models\User\Student;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasStudentAccess {

	/**
	 * Handle an incoming request.
	 */
	public function handle(Request $request, Closure $next): Response {
		$student = $request->route('student');
		$student = is_string($student) ? Student::find($student) : $student;
		$studentClass = $student->class;

		if ($student->userId == Auth::id()) {
			return $next($request);
		}

		if (is_administrator() && administrator()->hasAccessToClass($studentClass)) {
			return $next($request);
		}

		if (is_teacher() && teacher()->hasAccessToClass($studentClass)) {
			return $next($request);
		}

		return redirect()->route('home');
	}
}

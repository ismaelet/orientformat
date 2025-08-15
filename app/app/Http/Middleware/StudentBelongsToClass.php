<?php

namespace App\Http\Middleware;

use App\Models\Schools\SchoolClass;
use App\Models\User\Student as UserStudent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentBelongsToClass {

	/**
	 * Handle an incoming request.
	 */
	public function handle(Request $request, Closure $next): Response {
		$student = $request->route('student');
		$student = is_string($student) ? UserStudent::find($student) : $student;
		$class = $request->route('class');
		$class = is_string($class) ? SchoolClass::find($class) : $class;

		if (!$class) {
			return redirect()->route('home');
		}

		if ($student->schoolClassId != $class->id) {
			return redirect()->route('class.students.results.index', [$class]);
		}

		return $next($request);
	}
}

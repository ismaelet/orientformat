<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherBelongsToSchool
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! teacher()->school) {
            return redirect()->route('teacher.school.show');
        }

        return $next($request);
    }
}

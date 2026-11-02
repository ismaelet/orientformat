<?php

namespace App\Http\Middleware;

use App\Models\Schools\SchoolClass;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasClassAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $class = $request->route('class');
        $class = is_string($class) ? SchoolClass::find($class) : $class;

        if (is_administrator() && administrator()->hasAccessToClass($class)) {
            return $next($request);
        }

        if (is_teacher() && teacher()->hasAccessToClass($class)) {
            return $next($request);
        }

        if (is_student() && student()->school_class_id == $class->id) {
            return $next($request);
        }

        return redirect()->route('teacher.dashboard');
    }
}

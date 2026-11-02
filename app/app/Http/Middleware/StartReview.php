<?php

namespace App\Http\Middleware;

use App\Models\ReviewResult;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StartReview
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $student = Auth::user()->student;
        $class = $student->class;

        /**
         * Starting review
         */
        $relativeGrade = $class?->grade()->relative_number;
        $startingGrade = $class?->startingGrade;
        $currentGrade = $class?->grade;

        switch (true) {
            case $student->isMiddleSchoolStudent() && $relativeGrade == 3:
                // third middleschool year
                $reviewId = 2;
                break;

            case $student->isHighSchoolStudent() && ($relativeGrade == 1 || $startingGrade == $currentGrade):
                // first higschool year
                $reviewId = 4;
                break;

            case $student->isHighSchoolStudent():
                // other higschool years
                $reviewId = 5;
                break;
            default:
                $reviewId = null;
        }

        if (
            $class &&
            $reviewId &&
            ReviewResult::where('studentId', Auth::id())
                ->where('reviewId', $reviewId)
                ->doesntExist()
        ) {
            return redirect()->route('review.show', ['review' => $reviewId]);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\ReviewResult;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EndReview {

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response {
        $reviewId = 3;
        $student = Auth::user()->student;
        $class = $student->class;
        $currentGrade = $class?->current_grade;
        $lastGrade = $class?->last_grade;
        $year = $class?->year + 1;
        $endReviewDate = now()->setDate($year, 1, 6);

        $hasCompletedReview = ReviewResult::where('studentId', $student->id)
            ->where('reviewId', $reviewId)
            ->exists();
        $isInFinalYear = $currentGrade == $lastGrade;
        $isAfterEndDate = now()->greaterThanOrEqualTo($endReviewDate);

        if (
            $class &&
            !$hasCompletedReview &&
            $isInFinalYear &&
            $isAfterEndDate
        ) {
            return redirect()->route('review.show', ['review' => $reviewId]);
        }

        return $next($request);
    }
}

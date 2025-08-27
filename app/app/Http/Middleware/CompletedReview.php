<?php

namespace App\Http\Middleware;

use App\Models\ReviewResult;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CompletedReview {

	/**
	 * Handle an incoming request.
	 */
	public function handle(Request $request, Closure $next): Response {
		$student = Auth::user()->student;

		/**
		 * Starting review
		 */
		$relativeGrade = $student->school_class->grade()->relative_number;
		$startingGrade = $student->school_class->startingGrade;
		$currentGrade = $student->school_class->grade;

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
			$reviewId &&
			ReviewResult::where('studentId', Auth::id())
			->where('reviewId', $reviewId)
			->doesntExist()
		) {
			return redirect()->route('review', ['id' => $reviewId]);
		}

		/**
		 * Ending review
		 */
		if ($student->school_class->ended) {
			$reviewId = $student->isMiddleSchoolStudent() ? 3 : 6;

			if (
				$reviewId &&
				ReviewResult::where('studentId', Auth::id())
				->where('reviewId', $reviewId)
				->doesntExist()
			) {
				return redirect()->route('review', ['id' => $reviewId]);
			}
		}

		return $next($request);
	}
}

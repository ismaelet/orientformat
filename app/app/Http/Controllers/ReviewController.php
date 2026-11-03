<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use App\Models\ReviewResult;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Legacy\Review\Review as LegacyReview;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource
     */
    public function show(Request $request, Review $review)
    {
        $debugger = false;
        $legacyReview = new LegacyReview($review->id);

        return view('student.review.show', compact('review', 'legacyReview', 'debugger'));
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(StoreReviewRequest $request): RedirectResponse
    {
        $results = collect($request->answers())
            ->map(fn (string $value, string $slug) => $slug.'='.$value)
            ->implode(',');

        $result = ReviewResult::firstOrCreate([
            'studentId' => Auth::id(),
            'reviewId' => $request->review()->id,
        ], [
            'results' => $results,
        ]);

        // A concurrent submission already completed the questionnaire
        abort_unless($result->wasRecentlyCreated, 409);

        return redirect()->back()->with('success', true);
    }
}

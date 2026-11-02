<?php

namespace App\Http\Controllers;

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
    public function store(Request $request): RedirectResponse
    {
        $answers = array_filter($request->except(['_token']));
        $results = [];

        foreach ($answers as $questionSlug => $questionValue) {
            $results[] = $questionSlug.'='.str_replace(['=', "'"], '', $questionValue);
        }

        $results = implode(',', $results);

        ReviewResult::updateOrCreate([
            'studentId' => Auth::id(),
            'reviewId' => $request->input('review_id'),
        ], [
            'results' => $results,
        ]);

        return redirect()->back()->with('success', true);
    }
}

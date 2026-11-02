<?php

namespace App\Helpers\Tests;

use App\Interfaces\TestHelperInterface;
use App\Models\Results\User\AdditionalResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlberoAlberoHelper implements TestHelperInterface
{
    public array $branchResults = [];

    public array $fruitsResults = [];

    public function __construct()
    {
        $additionalResult = AdditionalResult::where('studentId', legacy_watched_student()->id)
            ->where('testId', testId())
            ->first();

        $this->branchResults = $additionalResult ? explode(',', $additionalResult->primaryResults) : [];
        $this->fruitsResults = $additionalResult ? explode(',', $additionalResult->secondaryResults) : [];
    }

    /**
     * Store the additional result for the Albero Albero test
     */
    public function storeAdditionalResult(Request $request): void
    {
        $branches = implode(',', $request->input('branch', []));
        $fruits = implode(',', $request->input('fruit', []));

        AdditionalResult::updateOrCreate(
            [
                'studentId' => Auth::id(),
                'testId' => testId(),
            ],
            [
                'primaryResults' => $branches,
                'secondaryResults' => $fruits,
            ]
        );
    }

    /**
     * Calculate the percentage of correct answers based on the provided fields
     */
    public function calculatePercentage(array $submittedAnswers): int
    {
        return 100;
    }
}

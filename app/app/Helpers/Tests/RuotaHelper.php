<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Support\Collection;

class RuotaHelper
{
    public static array $emotions = [
        1 => [
            'fear',
            'sadness',
            'anger',
            'joy',
        ],
        2 => [
            'fear',
            'surprise',
            'sadness',
            'disgust',
            'anger',
            'anticipation',
            'joy',
            'acceptance',
        ],
        3 => [
            'fear',
            'fright',
            'surprise',
            'disappointment',
            'sadness',
            'remorse',
            'disgust',
            'contempt',
            'anger',
            'aggressiveness',
            'anticipation',
            'optimism',
            'joy',
            'love',
            'acceptance',
            'submission',
        ],
    ];

    /**
     * Get the emotions for a specific test step
     */
    public static function emotions(Test $test): array
    {
        return array_map(fn ($emotion) => __($emotion), self::$emotions[$test->step]);
    }

    /**
     * Returns the selected emotions
     */
    public static function selectedEmotions(Test $test, Student|Teacher $user): Collection
    {
        $tests = Test::where('sectionId', $test->sectionId)
            ->where('step', '<=', $test->step)
            ->orderBy('step')
            ->get();

        $results = TestResult::whereIn('testId', $tests->pluck('id'))
            ->where('studentId', $user->id)
            ->where('completed', true)
            ->get();

        $emotions = $results->pluck('result')->map(function ($result) {
            $emotions = explode(',', $result);

            return collect(['emotion' => __en($emotions[0]), 'intensity' => $emotions[1]]);
        });

        return $emotions;
    }
}

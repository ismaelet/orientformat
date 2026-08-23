<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\User\Student;

class AttenzioneRiepilogoHelper {

    private const QUESTION_COUNT = 18;

    private const MAX_SCORE = 36;

    /**
     * @return array{
     *     Distraibilità: float,
     *     Iperattività: float
     * }|null
     */
    public static function percentages(
        Test $test,
        Student $student,
    ): ?array {
        $testResult = $student->testResult($test);

        if ($testResult === null) {
            return null;
        }

        $answers = $testResult->results();

        if (empty($answers)) {
            return null;
        }

        $focusScore = 0;
        $hyperactivityScore = 0;

        for (
            $index = 0;
            $index < self::QUESTION_COUNT;
            $index++
        ) {
            $score = isset($answers[$index])
                ? ((int) $answers[$index]) + 1
                : 0;

            if ($index % 2 === 0) {
                $focusScore += $score;
            } else {
                $hyperactivityScore += $score;
            }
        }

        return [
            'Distraibilità' => round(
                $focusScore
                    / self::MAX_SCORE
                    * 100,
            ),

            'Iperattività' => round(
                $hyperactivityScore
                    / self::MAX_SCORE
                    * 100,
            ),
        ];
    }
}

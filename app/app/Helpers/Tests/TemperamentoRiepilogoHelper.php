<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Support\Collection;

class TemperamentoRiepilogoHelper {

    public static function results(Test $test, Student|Teacher $student): ?Collection {
        $results = [];
        $dependentTests = $test->dependent_tests();

        foreach ($dependentTests as $dependentTest) {
            $testResult = self::resultRecord($dependentTest, $student);

            if ($testResult) {
                $percentage = $testResult->percentage;

                $results[] = collect([
                    'name' => self::getSections()[$dependentTest->step]['name'] ?? $dependentTest->name,
                    'value' => max(ceil($percentage / 100 * 5), 1),
                    'percentage' => $percentage
                ]);
            }
        }

        return empty($results) ? null : collect($results);
    }

    /**
     * Get the result record for a given student and test
     */
    public static function resultRecord(Test $test, Student|Teacher $student): ?TestResult {
        return $student->testResult($test);
    }

    /**
     * Get the names of the sections of the test
     */
    public static function getSections(): Collection {
        return collect([
            1 => [
                'name' => __('tests.46-section-1'),
            ],
            2 => [
                'name' => __('tests.46-section-2'),
            ],
            3 => [
                'name' => __('tests.46-section-3'),
            ],
            4 => [
                'name' => __('tests.46-section-4'),
            ],
            5 => [
                'name' => __('tests.46-section-5'),
            ],
        ]);
    }
}

<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Support\Collection;

class StiliMappaHelper
{
    /**
     * Calculate and return the test results for a given student and test
     */
    public static function results(Test $test, Student|Teacher $student, ?Collection $categories = null): ?Collection
    {
        if (! $categories) {
            $categories = self::getCategories();
        }

        // Get the database record of the test result
        $resultRecord = self::resultRecord($test, $student);

        if (! $resultRecord) {
            return null;
        }

        // Parse the raw results
        $rawResults = explode(',', $resultRecord->result);

        foreach ($categories as $categoryId => $category) {
            $result = [];
            $result['name'] = $category['name'];
            $result['translated_name'] = $category['translated_name'];
            $result['value'] = 0;
            $result['max'] = count($category['questionIds']) * 3;

            // Sum the values of the questions in this category
            foreach ($category['questionIds'] as $questionId) {
                $result['value'] += $rawResults[$questionId];
            }

            // Calculate the percentage
            $result['percentage'] = round($result['value'] / $result['max'] * 100);

            $results[$categoryId] = collect($result);
        }

        return collect(array_values($results));
    }

    /**
     * Get the result record for a given student and test
     */
    public static function resultRecord(Test $test, Student|Teacher $student): ?TestResult
    {
        return TestResult::where('testId', $test->required_test->id)
            ->where('studentId', $student->id)
            ->where('completed', true)
            ->first();
    }

    /**
     * Get the categories configuration
     */
    public static function getCategories(): Collection
    {
        return collect([
            1 => collect([
                'name' => 'Visivo',
                'translated_name' => __('tests.31-1-name'),
                'info' => __('tests.31-1-info'),
                'questionIds' => [3, 9, 13],
            ]),
            2 => collect([
                'name' => 'Uditivo',
                'translated_name' => __('tests.31-2-name'),
                'info' => __('tests.31-2-info'),
                'questionIds' => [1, 18, 23],
            ]),
            3 => collect([
                'name' => 'Globale',
                'translated_name' => __('tests.31-3-name'),
                'info' => __('tests.31-3-info'),
                'questionIds' => [5, 11, 16],
            ]),
            4 => collect([
                'name' => 'Analitico',
                'translated_name' => __('tests.31-4-name'),
                'info' => __('tests.31-4-info'),
                'questionIds' => [2, 4, 17],
            ]),
            5 => collect([
                'name' => 'Collaborativo',
                'translated_name' => __('tests.31-5-name'),
                'info' => __('tests.31-5-info'),
                'questionIds' => [6, 10, 19],
            ]),
            6 => collect([
                'name' => 'Autonomo',
                'translated_name' => __('tests.31-6-name'),
                'info' => __('tests.31-6-info'),
                'questionIds' => [0, 12, 21],
            ]),
            7 => collect([
                'name' => 'Sistematico',
                'translated_name' => __('tests.31-7-name'),
                'info' => __('tests.31-7-info'),
                'questionIds' => [8, 14, 20],
            ]),
            8 => collect([
                'name' => 'Intuitivo',
                'translated_name' => __('tests.31-8-name'),
                'info' => __('tests.31-8-info'),
                'questionIds' => [7, 15, 22],
            ]),
        ]);
    }
}

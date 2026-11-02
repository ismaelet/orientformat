<?php

namespace Legacy\Activity\Result;

use App\Legacy\LegacyDB;
use App\Models\Results\User\TestResult as UserTestResult;
use System\Traits\DatabaseObject;

/**
 * TestResult class
 *
 * @property array rawResults
 * @property array detailedResult
 */
class TestResult
{
    use DatabaseObject;

    public const TABLE = 'results_tests';

    public const INDEX = 'id';

    public const USER_INDEX = 'studentId';

    public const TEST_INDEX = 'testId';

    /**
     * Get methods
     */
    private function getRawResults()
    {
        return explode(',', (string) $this->result);
    }

    /**
     * Istance methods
     */
    public static function new(array $data)
    {
        // Save or update user test result
        UserTestResult::updateOrCreate([
            'studentId' => $data['studentId'],
            'testId' => $data['testId'],
        ], [
            'result' => $data['results'],
            'percentage' => $data['percentage'],
            'completed' => (bool) $data['completed'],
            'speed' => $data['speed'],
        ]);

        // permanent record
        if (! LegacyDB::exists('results_permanent WHERE studentId = ? AND testId = ?', [$data['studentId'], $data['testId']])) {
            self::saveToPermanentRecord($data);
        }
    }

    private static function saveToPermanentRecord(array $data)
    {
        LegacyDB::add(
            'results_permanent (studentId, testId, result, percentage, speed)',
            [$data['studentId'], $data['testId'], $data['results'], $data['percentage'], $data['speed']]
        );
    }
}

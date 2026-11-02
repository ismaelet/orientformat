<?php

namespace Legacy\Activity\Result;

use App\Models\Results\User\TestResult as UserTestResult;
use Illuminate\Support\Facades\DB;
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
        if (! DB::table('results_permanent')->where('studentId', $data['studentId'])->where('testId', $data['testId'])->exists()) {
            self::saveToPermanentRecord($data);
        }
    }

    private static function saveToPermanentRecord(array $data)
    {
        DB::table('results_permanent')->insert([
            'studentId' => $data['studentId'],
            'testId' => $data['testId'],
            'result' => $data['results'],
            'percentage' => $data['percentage'],
            'speed' => $data['speed'],
        ]);
    }
}

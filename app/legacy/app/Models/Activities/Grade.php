<?php

namespace LegacyModels\Activities;

use App\Legacy\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LegacyModels\Activities\Results\TestResult;
use LegacyModels\OldModel;

class Grade extends OldModel
{
    /**
     * Table name
     */
    protected const TABLE = 'activities_grades';

    private $testIds;

    private $completedTestIds;

    /**
     * Get methods
     */
    public function testIds(): array
    {
        if ($this->testIds) {
            return $this->testIds;
        }

        $legacyTestTable = Test::table();
        $legacyTestIndex = Test::indexName();
        $legacySectionTable = Section::table();
        $legacySectionIndex = Section::indexName();
        $legacySectionLinkedIndex = Test::linkedIndexName(Section::class);

        return $this->testIds = DB::table($legacyTestTable)
            ->join($legacySectionTable, "$legacyTestTable.$legacySectionLinkedIndex", '=', "$legacySectionTable.$legacySectionIndex")
            ->whereRaw('FIND_IN_SET(?, grades)', [$this->id()])
            ->where("$legacyTestTable.active", 1)
            ->where("$legacySectionTable.active", 1)
            ->pluck("$legacyTestTable.$legacyTestIndex")
            ->all();
    }

    public function testCount()
    {
        return count($this->testIds());
    }

    public function completedTestIds(): array
    {
        if ($this->completedTestIds) {
            return $this->completedTestIds;
        }

        $legacyTestResultTable = TestResult::table();
        $legacyTestResultUserIndex = TestResult::linkedIndexName(User::class);
        $legacyTestResultTestIndex = TestResult::linkedIndexName(Test::class);

        return $this->completedTestIds = DB::table($legacyTestResultTable)
            ->where($legacyTestResultUserIndex, Auth::id())
            ->whereIn($legacyTestResultTestIndex, $this->testIds())
            ->pluck(TestResult::indexName())
            ->all();
    }

    public function completedTestCount()
    {
        return count($this->completedTestIds());
    }

    public function completedPercentage()
    {
        return percent($this->completedTestCount(), $this->testCount());
    }
}

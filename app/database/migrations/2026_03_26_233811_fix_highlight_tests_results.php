<?php

use App\Models\Activities\Test;
use App\Models\Results\User\TestResult;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        $testIds = [37, 132, 149, 173, 174, 185, 187, 189, 190, 191];
        $results = TestResult::whereIn('testId', $testIds)->where('percentage', '>', 0)->get();
        $tests = Test::whereIn('id', $testIds)->with('section')->get()->keyBy('id');

        $results->each(function ($resultObj) use ($tests) {
            $test = $tests->get($resultObj->testId);
            $oldResult = explode(',', $resultObj->result);
            $helper = $test->helper();
            $solutions = $helper->solutions;

            if ($resultObj->percentage == 100) {
                $newResult = $solutions;
            } else {
                $newResult = [];

                foreach ($solutions as $partId => $marker) {
                    $newResult[] = isset($oldResult[$partId + 1]) ? $marker : '';
                }
            }

            $newResultString = implode(',', $newResult);
            $resultObj->result = $newResultString;
            $resultObj->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        //
    }
};

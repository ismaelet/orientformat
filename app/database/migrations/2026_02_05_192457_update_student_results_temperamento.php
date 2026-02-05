<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        $temperamentoTests = [41, 42, 43, 44, 45];

        $results = DB::table('results_tests')
            ->whereIn('testId', $temperamentoTests)
            ->get();

        foreach ($results as $result) {
            $answers = $result->result;

            if ($answers) {
                $answers = explode(',', $answers);

                // Lower each answer by 1
                $updatedAnswers = array_map(function ($answer) {
                    return max(0, intval($answer) - 1);
                }, $answers);

                $max = count($updatedAnswers) * 5;
                $score = array_sum($updatedAnswers);
                $percentage = round($score / $max * 100);

                DB::table('results_tests')
                    ->where('id', $result->id)
                    ->update([
                        'result' => implode(',', $updatedAnswers),
                        'percentage' => $percentage,
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        //
    }
};

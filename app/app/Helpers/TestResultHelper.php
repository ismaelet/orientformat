<?php

namespace App\Helpers;

use App\Models\Results\User\TestResult;

class TestResultHelper
{
    public static function getResult(
        int $studentId,
        int $testId,
    ): ?string {
        return match ($testId) {
            // Stili cognitivi
            // 31 => self::getResultStiliCognitivi(
            //     $studentId,
            //     $testId,
            // ),

            // // Resilienza
            // 49 => self::getResultResilienza(
            //     $studentId,
            //     $testId,
            // ),

            // // Autostima
            // 15,
            // 107,
            // 146 => self::getResultAutostima(
            //     $studentId,
            //     $testId,
            // ),

            // // Stile attributivo
            // 48 => self::getResultStileAttributivo(
            //     $studentId,
            //     $testId,
            // ),

            // // Motivazione
            // 20 => self::getResultMotivazione(
            //     $studentId,
            //     $testId,
            // ),

            // // Temperamento
            // 46 => self::getResultTemperamento(
            //     $studentId,
            //     $testId,
            // ),

            // // Creatività
            // 81 => self::getResultCreativita(
            //     $studentId,
            //     $testId,
            // ),

            // Ruota delle emozioni
            116 => self::getResultRuota($studentId),

            // etc.
            default => null,
        };
    }

    private static function getResultRuota(
        int $studentId,
    ): ?string {
        $testIds = [
            102,
            115,
            116,
        ];

        $latestResults = TestResult::query()
            ->where('studentId', $studentId)
            ->whereIn('testId', $testIds)
            ->where('completed', true)
            ->orderByDesc('created_at')
            ->get()
            ->unique('testId')
            ->keyBy('testId');

        $results = [];

        foreach ($testIds as $testId) {
            $result = $latestResults->get($testId);

            if (! $result) {
                continue;
            }

            $resultString = explode(
                ',',
                $result->result,
            )[0];

            if ($resultString) {
                $results[] = ucfirst(
                    __($resultString),
                );
            }
        }

        return $results
            ? implode(', ', $results)
            : null;
    }
}

<?php

namespace App\Helpers\Tests;

use App\Interfaces\TestHelperInterface;

class ProblemiEspertoGommeHelper implements TestHelperInterface
{
    /**
     * Helper method: calculates the test result percentage based on the user's selections
     */
    public function calculatePercentage(array $results): int
    {
        $answer = str_replace('.', '', $results[0] ?? '');

        return $answer == 16000 ? 100 : 0;
    }
}

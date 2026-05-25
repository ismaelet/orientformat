<?php

namespace App\Helpers\Tests;

use App\Interfaces\TestHelperInterface;

class ProblemiAnagrammaHelper implements TestHelperInterface {

    /**
     * Property: contains the riddles for the test, each riddle is an array with the scrambled word, the clue, and the correct answer
     */
    public array $riddles = [
        ['wyxj', 'è sempre teso', 'ARCO'],
        ['yjxw', 'la voce del raffreddore', 'ROCA'],
        ['jyxw', 'cetaceo di cattiva fama', 'ORCA'],
        ['xwyj', 'affettuoso, ma anche poco economico', 'CARO'],
    ];

    public function __construct() {
    }

    /**
     * Helper method: calculate the percentage of correct answers
     */
    public function calculatePercentage(array $results): int {
        $count = count($this->riddles);
        $rightAnswers = 0;

        foreach ($this->riddles as $riddleKey => $riddle) {
            if (strtolower(trim($results[$riddleKey] ?? '')) == strtolower($riddle[2])) {
                $rightAnswers++;
            }
        }

        return round($rightAnswers / $count * 100);
    }
}

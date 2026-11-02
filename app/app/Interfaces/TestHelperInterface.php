<?php

namespace App\Interfaces;

interface TestHelperInterface
{
    /**
     * Required method: calculate the percentage score based on the submitted answers and the correct answers
     */
    public function calculatePercentage(array $submittedAnswers): int;
}

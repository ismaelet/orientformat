<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Support\Collection;

class ProblemiSuperioriProblemGruppoHelper {

    /**
     * Constant: Maximum score per question
     */
    public const int MAX_SCORE = 4;

    /**
     * Get the results for the Problemi Superiori - Problem Solving di Gruppo test
     */
    public static function results(Test $test, Student|Teacher $user): Collection {
        $answers = $user->testResult($test)?->results() ?? [];
        $questions = self::questions();
        $roles = self::roles();

        $results = collect();

        foreach ($roles as $roleId => $roleName) {
            $roleQuestions = array_filter($questions, fn($q) => $q['role'] === $roleId);
            $roleAnswers = array_intersect_key($answers, $roleQuestions);
            $score = array_sum($roleAnswers);
            $maxScore = count($roleQuestions) * self::MAX_SCORE;
            $percentage = $maxScore > 0 ? round(($score / $maxScore) * 100) : 0;

            $results->push(collect([
                'id' => $roleId,
                'name' => $roleName,
                'answers' => $roleAnswers,
                'score' => $score,
                'percentage' => $percentage,
            ]));
        }

        return $results;
    }

    /**
     * Get the main roles for the Problemi Superiori - Problem Solving di Gruppo test
     */
    public static function mainRoles(Test $test, Student|Teacher $user): Collection {
        $results = self::results($test, $user);
        $topScore = $results->max('score');

        return $results->where('score', $topScore);
    }

    /**
     * Get the other roles for the Problemi Superiori - Problem Solving di Gruppo test
     */
    public static function otherRoles(Test $test, Student|Teacher $user): Collection {
        $results = self::results($test, $user);
        $mainRoles = self::mainRoles($test, $user);

        return $results->diff($mainRoles)->sortByDesc('score');
    }

    /**
     * Get the questions for the Problemi Superiori - Problem Solving di Gruppo test
     */
    public static function questions(): array {
        return [
            [
                'text' => __('tests.problemi-problem-gruppo-question-1'),
                'role' => 1
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-2'),
                'role' => 2
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-3'),
                'role' => 3
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-4'),
                'role' => 4
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-5'),
                'role' => 3
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-6'),
                'role' => 1
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-7'),
                'role' => 2
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-8'),
                'role' => 1
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-9'),
                'role' => 3
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-10'),
                'role' => 4
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-11'),
                'role' => 2
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-12'),
                'role' => 4
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-13'),
                'role' => 2
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-14'),
                'role' => 1
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-15'),
                'role' => 3
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-16'),
                'role' => 2
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-17'),
                'role' => 4
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-18'),
                'role' => 1
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-19'),
                'role' => 2
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-20'),
                'role' => 1
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-21'),
                'role' => 3
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-22'),
                'role' => 4
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-23'),
                'role' => 3
            ],
            [
                'text' => __('tests.problemi-problem-gruppo-question-24'),
                'role' => 4
            ],
        ];
    }

    /**
     * Get the roles for the Problemi Superiori - Problem Solving di Gruppo test
     */
    public static function roles(): array {
        return [
            1 => 'Stratega',
            2 => 'Esploratore',
            3 => 'Critico',
            4 => 'Saggio',
        ];
    }
}

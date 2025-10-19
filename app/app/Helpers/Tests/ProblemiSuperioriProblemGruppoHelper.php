<?php

namespace App\Helpers\Tests;

class ProblemiSuperioriProblemGruppoHelper {

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

<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Support\Collection;

class StiliEssereMappaHelper
{
    /**
     * Get the results of the "Mappa" test for a specific student
     */
    public static function results(Test $test, Student|Teacher $student): ?Collection
    {
        return StiliMappaHelper::results($test, $student, self::getCategories());
    }

    /**
     * Get the categories configuration
     */
    public static function getCategories(): Collection
    {
        return collect([
            1 => collect([
                'name' => 'Semplicità',
                'translated_name' => __('tests.113-1-name'),
                'info' => __('tests.113-1-info'),
                'questionIds' => collect([2, 17, 22]),
            ]),
            2 => collect([
                'name' => 'Complessità',
                'translated_name' => __('tests.113-2-name'),
                'info' => __('tests.113-2-info'),
                'questionIds' => collect([5, 11, 14]),
            ]),
            3 => collect([
                'name' => 'Giocoso',
                'translated_name' => __('tests.113-3-name'),
                'info' => __('tests.113-3-info'),
                'questionIds' => collect([3, 12, 19]),
            ]),
            4 => collect([
                'name' => 'Finalistico',
                'translated_name' => __('tests.113-4-name'),
                'info' => __('tests.113-4-info'),
                'questionIds' => collect([0, 15, 21]),
            ]),
            5 => collect([
                'name' => 'Divergente',
                'translated_name' => __('tests.113-5-name'),
                'info' => __('tests.113-5-info'),
                'questionIds' => collect([6, 8, 16]),
            ]),
            6 => collect([
                'name' => 'Convergente',
                'translated_name' => __('tests.113-6-name'),
                'info' => __('tests.113-6-info'),
                'questionIds' => collect([1, 10, 18]),
            ]),
            7 => collect([
                'name' => 'Esplorativo',
                'translated_name' => __('tests.113-7-name'),
                'info' => __('tests.113-7-info'),
                'questionIds' => collect([9, 20, 23]),
            ]),
            8 => collect([
                'name' => 'Evitante',
                'translated_name' => __('tests.113-8-name'),
                'info' => __('tests.113-8-info'),
                'questionIds' => collect([4, 7, 13]),
            ]),
        ]);
    }
}

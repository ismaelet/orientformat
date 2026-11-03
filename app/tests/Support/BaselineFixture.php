<?php

namespace Tests\Support;

use Illuminate\Support\Facades\DB;

/**
 * Minimal reference data the application expects to exist (site configuration,
 * activity sections and the tests the result calculators read). It replaces the
 * records tests used to find in the development database.
 */
final class BaselineFixture
{
    /** Section ids referenced by routes, graphs and result calculators under test. */
    public const SECTION_IDS = [
        1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 14, 17, 23, 24, 27, 28, 29, 30, 31, 32, 33, 34, 36, 37, 39, 40, 41, 45,
    ];

    /** Temperament section (8): test 46 and its five steps. */
    public const TEMPERAMENT_TEST_IDS = [46, 47, 48, 49, 50];

    public static function seed(): void
    {
        DB::table('config')->updateOrInsert(['name' => 'public'], ['value' => '1']);

        foreach (self::SECTION_IDS as $id) {
            DB::table('sections')->updateOrInsert(['id' => $id], [
                'areaId' => $id === 23 ? 4 : ($id === 9 || $id === 8 ? $id - 7 : 1),
                'name' => "Sezione {$id}",
                'slug' => "sezione-{$id}",
                'description' => 'Fixture',
                'isStandard' => $id === 23 ? 0 : 1,
            ]);
        }

        foreach (self::TEMPERAMENT_TEST_IDS as $step => $id) {
            self::test($id, 8, step: $step + 1);
        }

        foreach (range(1, 200) as $id) {
            if (! DB::table('tests')->where('id', $id)->exists()) {
                self::test($id, 1, step: 1);
            }
        }

        self::test(16, 9);
        self::test(21, 9, required: 22);
        self::test(22, 9);
    }

    private static function test(int $id, int $sectionId, ?int $step = null, int $required = 0): void
    {
        DB::table('tests')->updateOrInsert(['id' => $id], [
            'sectionId' => $sectionId,
            'areaId' => 1,
            'title' => "Test {$id}",
            'description' => 'Fixture',
            'shortDescription' => 'Fixture',
            'slug' => "test-{$id}",
            'step' => $step,
            'requiredTestId' => $required,
        ]);
    }
}

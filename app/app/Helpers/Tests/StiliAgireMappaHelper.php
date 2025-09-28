<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\User\Student;
use Illuminate\Support\Collection;

class StiliAgireMappaHelper {

	/**
	 * Get the results of the "Mappa" test for a specific student
	 */
	public static function results(Student $student): ?Collection {
		$test = Test::where('slug', 'mappa')
			->whereHas('section', function ($query) {
				$query->where('slug', 'stili-agire');
			})
			->firstOrFail();

		return StiliMappaHelper::results($test, $student, self::getCategories());
	}

	/**
	 * Get the categories configuration
	 */
	private static function getCategories() {
		return [
			1 => [
				'name' => 'Riflessivo',
				'translated_name' => __('tests.111-1-name'),
				'info' => __('tests.111-1-info'),
				'questionIds' => [5, 14, 21],
			],
			2 => [
				'name' => 'Pragmatico',
				'translated_name' => __('tests.111-2-name'),
				'info' => __('tests.111-2-info'),
				'questionIds' => [12, 16, 18],
			],
			3 => [
				'name' => 'Livellatore',
				'translated_name' => __('tests.111-3-name'),
				'info' => __('tests.111-3-info'),
				'questionIds' => [0, 8, 15],
			],
			4 => [
				'name' => 'Acutizzatore',
				'translated_name' => __('tests.111-4-name'),
				'info' => __('tests.111-4-info'),
				'questionIds' => [3, 11, 17],
			],
			5 => [
				'name' => 'Impulsivo',
				'translated_name' => __('tests.111-5-name'),
				'info' => __('tests.111-5-info'),
				'questionIds' => [2, 8, 23],
			],
			6 => [
				'name' => 'Metodico',
				'translated_name' => __('tests.111-6-name'),
				'info' => __('tests.111-6-info'),
				'questionIds' => [1, 7, 9],
			],
			7 => [
				'name' => 'Correttore',
				'translated_name' => __('tests.111-7-name'),
				'info' => __('tests.111-7-info'),
				'questionIds' => [10, 19, 22],
			],
			8 => [
				'name' => 'Pianificatore',
				'translated_name' => __('tests.111-8-name'),
				'info' => __('tests.111-8-info'),
				'questionIds' => [4, 13, 20],
			],
		];
	}
}

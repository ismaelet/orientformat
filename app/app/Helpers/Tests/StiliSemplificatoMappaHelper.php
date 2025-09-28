<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\User\Student;
use Illuminate\Support\Collection;

class StiliSemplificatoMappaHelper {

	/**
	 * Get the results of the "Mappa" test for a specific student
	 */
	public static function results(Student $student, Test $test): ?Collection {
		return StiliMappaHelper::results($test, $student, self::getCategories());
	}

	/**
	 * Get the categories configuration
	 */
	private static function getCategories(): array {
		return [
			1 => [
				'name' => 'Visivo',
				'translated_name' => __('tests.31-1-name'),
				'info' => __('tests.31-1-info'),
				'questionIds' => [2, 4, 7],
			],
			2 => [
				'name' => 'Uditivo',
				'translated_name' => __('tests.31-2-name'),
				'info' => __('tests.31-2-info'),
				'questionIds' => [1, 8, 11],
			],
			3 => [
				'name' => 'Collaborativo',
				'translated_name' => __('tests.31-5-name'),
				'info' => __('tests.31-5-info'),
				'questionIds' => [3, 5, 9],
			],
			4 => [
				'name' => 'Autonomo',
				'translated_name' => __('tests.31-6-name'),
				'info' => __('tests.31-6-info'),
				'questionIds' => [0, 6, 10],
			],
		];
	}
}

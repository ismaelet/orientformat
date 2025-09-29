<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\User\Student;
use Illuminate\Support\Collection;

class StiliSemplificatoMappaHelper {

	/**
	 * Get the results of the "Mappa" test for a specific student
	 */
	public static function results(Test $test, Student $student): ?Collection {
		return StiliMappaHelper::results($test, $student, self::getCategories());
	}

	/**
	 * Get the categories configuration
	 */
	public static function getCategories(): Collection {
		return collect([
			1 => collect([
				'name' => 'Visivo',
				'translated_name' => __('tests.31-1-name'),
				'info' => __('tests.31-1-info'),
				'questionIds' => [2, 4, 7],
			]),
			2 => collect([
				'name' => 'Uditivo',
				'translated_name' => __('tests.31-2-name'),
				'info' => __('tests.31-2-info'),
				'questionIds' => [1, 8, 11],
			]),
			3 => collect([
				'name' => 'Collaborativo',
				'translated_name' => __('tests.31-5-name'),
				'info' => __('tests.31-5-info'),
				'questionIds' => [3, 5, 9],
			]),
			4 => collect([
				'name' => 'Autonomo',
				'translated_name' => __('tests.31-6-name'),
				'info' => __('tests.31-6-info'),
				'questionIds' => [0, 6, 10],
			]),
		]);
	}
}

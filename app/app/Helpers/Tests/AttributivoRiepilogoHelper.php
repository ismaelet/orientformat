<?php

namespace App\Helpers\Tests;

use App\Models\Activities\Test;
use App\Models\User\Student;
use Illuminate\Support\Collection;

class AttributivoRiepilogoHelper {

	public static function results(Test $test, Student $student): ?Collection {
		$requiredTest = $test->required_test;
		$testResult = $student->testResult($requiredTest);

		if (!$testResult || !$testResult->completed()) {
			return null;
		}

		$results = [];
		$rawResults = explode(',', $testResult->result);
		$styles = self::getStyles();
		$max = count($styles);

		foreach ($styles as $styleId => $style) {
			$value = count(array_filter($rawResults, fn($item) => $item == $styleId));

			$results[] = collect([
				'name' => $style,
				'value' => $value,
				'percentage' => percent($value, $max),
			]);
		}

		return collect($results);
	}

	private static function getStyles(): array {
		return [
			1 => 'Tenacia',
			2 => 'Pregiudizio',
			3 => 'Abilità',
			4 => 'Destino',
			5 => 'Strategia',
			6 => 'Dipendenza',
			7 => 'Emozione',
			8 => 'Caso'
		];
	}
}

<?php

namespace LegacyModels\Activities\Results;

use LegacyModels\Activities\Test;
use LegacyModels\OldModel;
use \App\Legacy\User;

class TestResult extends OldModel {
	/**
	 * Table name
	 */
	protected const TABLE = 'results_tests';
	protected const TABLE_LINKS = [
		Test::class => 'testId',
		User::class => 'studentId',
	];

	/**
	 * Get all test ids based on 
	 */
}

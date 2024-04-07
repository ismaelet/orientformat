<?php

namespace app\Models\Activities\Results;

use app\Models\Activities\Test;
use app\Models\OldModel;
use User;

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

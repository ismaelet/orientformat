<?php

namespace LegacyModels\Activities\Results;

use LegacyModels\Activities\Section;
use LegacyModels\OldModel;
use User;

class CondensedSectionResult extends OldModel {
	/**
	 * Table name
	 */
	protected const TABLE = 'results_sections_condensed';
	protected const TABLE_LINKS = [
		Section::class => 'section_id',
		User::class => 'student_id',
	];

	/**
	 * Get methods
	 */
	public static function resultIndex() {
		return 'result';
	}

	public static function speedIndex() {
		return 'speed';
	}
}

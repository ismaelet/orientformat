<?php

namespace Legacy\UserSystem\Student;

use DatabaseObject;

class Advice {

	use \System\Traits\DatabaseObject;

	public const TABLE = 'advices_list';
	public const INDEX = 'id';

	/**
	 * Get methods
	 */
	private function getName() {
		return $this->advice;
	}

	private function getCategory() {
		return new AdviceCategory($this->categoryId);
	}
}

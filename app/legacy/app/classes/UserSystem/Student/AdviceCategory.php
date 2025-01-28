<?php

namespace Legacy\UserSystem\Student;

use DatabaseObject;

class AdviceCategory {

	use \System\Traits\DatabaseObject;

	public const TABLE = 'advices_categories';
	public const INDEX = 'id';
}

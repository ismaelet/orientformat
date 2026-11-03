<?php

namespace Legacy\UserSystem\Student;

use System\Traits\DatabaseObject;

class AdviceCategory
{
    use DatabaseObject;

    public const TABLE = 'advices_categories';

    public const INDEX = 'id';
}

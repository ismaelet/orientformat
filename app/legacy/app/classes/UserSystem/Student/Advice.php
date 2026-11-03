<?php

namespace Legacy\UserSystem\Student;

use System\Traits\DatabaseObject;

class Advice
{
    use DatabaseObject;

    public const TABLE = 'advices_list';

    public const INDEX = 'id';

    /**
     * Get methods
     */
    private function getName()
    {
        return $this->advice;
    }

    private function getCategory()
    {
        return new AdviceCategory($this->categoryId);
    }
}

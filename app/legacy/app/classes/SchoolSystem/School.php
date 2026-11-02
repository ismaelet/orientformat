<?php

namespace Legacy\SchoolSystem;

use System\Traits\DatabaseObject;

class School
{
    use DatabaseObject;

    public const TABLE = 'schools';

    public const INDEX = 'id';

    /**
     * Get methods
     */
    private function getName()
    {
        return ucwords(strtolower($this->databaseEntry['name']));
    }
}
